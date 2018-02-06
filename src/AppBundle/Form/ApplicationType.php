<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class ApplicationType  extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,array('label' => '* Name ','attr'=>array('class'=>'form-control input-lg','style'=>'margin-bottom:15px')))
            ->add('email', EmailType::class,array('label' => '* Email ','attr'=>array('class'=>'form-control input-lg','style'=>'margin-bottom:15px')))
            ->add('address', TextareaType::class,array('label' => '* Address ','attr'=>array('class'=>'form-control input-lg','style'=>'margin-bottom:15px')))

            ->add('file_name', FileType::class,array('label' => '* Attachment ','attr'=>array('class'=>'formcontrol','style'=>'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Submit ','attr'=>array('class'=>'btn btn-success btn-block btn-lg')))

        ;
    }

}







