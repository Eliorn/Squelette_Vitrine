<?php

// src/OC/PlatformBundle/Controller/VitrineController.php

namespace PR\VitrineBundle\Controller;

// N'oubliez pas ce use :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class VitrineController extends Controller
{
  public function indexAction()
  {
    $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:layout.html.twig');

    return new Response($content);
  }
}
