<?php

namespace PR\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('PRAdminBundle:Admin:admin.html.twig');
    }

    public function accueilAction()
    {
        return $this->render('PRAdminBundle:Admin:accueil.html.twig');
    }

    public function articleAction()
    {
      $em = $this->getDoctrine()->getManager();
      $articlesRepository = $em->getRepository('PRVitrineBundle:Article');

      $queryListArticles = $articlesRepository->createQueryBuilder('a')
                                              ->orderBy('a.date','DESC');
      $query = $queryListArticles->getQuery();
      $listArticles = $query->getResult();
      return $this->render('PRAdminBundle:Admin:article.html.twig', array(
                'listArticles' => $listArticles,
              )
      );

    }

    public function contactAction()
    {

        return $this->render('PRAdminBundle:Admin:contact.html.twig');
    }

    public function galleryAction()
    {
        return $this->render('PRAdminBundle:Admin:gallery.html.twig');
    }


}
