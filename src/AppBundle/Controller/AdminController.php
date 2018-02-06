<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Application;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends Controller
{

    public function listAction(Request $request)
    {
        $applications=$this->getDoctrine()
            ->getRepository('AppBundle:Application')
            ->findAll();
        return $this->render('admin/list.html.twig',array(
                'applications'=>$applications
            )
        );
    }

    public function applicationDetailAction($id,Request $request)
    {
        $application=$this->getDoctrine()
            ->getRepository('AppBundle:Application')
            ->find($id);
        if (!$application) {
            throw $this->createNotFoundException('Application not found');
        }

        return $this->render('admin/detail.html.twig',array(
                'application'=>$application
            )
        );
    }

    public function downloadFileAction($filename)
    {
        $basePath =$this->getParameter('attachments');
        $filePath = $basePath.'/'.$filename;
        return $this->file($filePath);
    }
}
