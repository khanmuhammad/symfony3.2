<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Application;
use AppBundle\Form\ApplicationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Lengoo\Utils\Location;


class ApplicationController extends Controller
{

    public function indexAction(Request $request)
    {

        $application=new Application;
        //Call create form  builder
        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $clientIp= $request->getClientIp();
            $locationResponse=Location::findLocationFromIp($clientIp);
            $locationResponse=json_decode($locationResponse);
            if($locationResponse->status=="success"){
               $city=$locationResponse->city;
                $country=$locationResponse->country;
            }else{
                $city="Not Found";
                $country="Not Found";
            }


            $now=new\DateTime('now');
            $name=$form['name']->getData();
            $email=$form['email']->getData();
            $address=$form['address']->getData();
            $file=$application->getFileName();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            // Move the file to the directory where attachments are stored
            $file->move(
                $this->getParameter('attachments'),
                $fileName
            );

            //setting param
            $application->setName($name);
            $application->setEmail($email);
            $application->setAddress($address);
            $application->setCreatedAt($now);
            $application->setCity($city);
            $application->setCountry($country);
            $application->setIp($clientIp);
            $application->setFileName($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            // send email to applicant
            $this->sendEmail($name,$email);
            // set flash message
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Your Application is submitted we will response ASAP');
            return $this->redirectToRoute('application_form');

        }

        return $this->render('application/index.html.twig', array(
            'form' => $form->createView()));
    }

    private function sendEmail($name,$email)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($this->getParameter('email_subject'))
            ->setFrom($this->getParameter('email_from'))
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'emails/application.html.twig',
                    array('name' => $name)
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);
    }

}
