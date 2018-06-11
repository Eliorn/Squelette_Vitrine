<?php

namespace PR\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ContactsController extends Controller
{



    public function contactAction()
    {
      $em = $this->getDoctrine()->getManager();
      $contactRepository = $em->getRepository('PRVitrineBundle:Contact');

      $listContacts = $contactRepository->findAll();
      return $this->render('PRAdminBundle:Admin:contact.html.twig', array(
                'listContacts' => $listContacts,
              )
      );

    }




}
