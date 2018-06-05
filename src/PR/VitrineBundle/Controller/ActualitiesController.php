<?php

// src/PR/VitrineBundle/Controller/VitrineController.php

namespace PR\VitrineBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use PR\VitrineBundle\Form\Type\ContactType;

class ActualitiesController extends Controller
{

  public function actualitesAction()
  {

    $em = $this->getDoctrine()->getManager();
    $articlesRepository = $em->getRepository('PRVitrineBundle:Article');

    $queryListArticles = $articlesRepository->createQueryBuilder('a')
                                            ->where('a.published=1')
                                            ->orderBy('a.date','DESC');
    $query = $queryListArticles->getQuery();
    $listArticles = $query->getResult();
    return $this->render('PRVitrineBundle:Actualities:actualites.html.twig', array(
              'listArticles' => $listArticles,
            )
    );

  }





}
