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
    $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:accueil.html.twig');

    return new Response($content);
  }

  public function gallerieAction()
  {
    $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:gallerie.html.twig');

    return new Response($content);
  }

  public function contactsAction()
  {
    $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:contacts.html.twig');

    return new Response($content);
  }

  public function presentationAction()
  {
    $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:presentation.html.twig');

    return new Response($content);
  }
}
