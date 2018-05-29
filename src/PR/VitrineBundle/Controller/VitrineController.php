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


    $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:accueil.html.twig');

    return new Response($content);
  }





}
