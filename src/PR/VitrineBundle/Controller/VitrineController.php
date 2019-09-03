<?php

// src/PR/VitrineBundle/Controller/VitrineController.php

namespace PR\VitrineBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use PR\VitrineBundle\Form\Type\ContactType;

class VitrineController extends Controller
{
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $articlesRepository = $em->getRepository('PRVitrineBundle:Accueil');

    $listAccueil = $articlesRepository->findAll();
    return $this->render('PRVitrineBundle:Vitrine:accueil.html.twig', array(
              'listAccueil' => $listAccueil,
            )
    );
  }





}
