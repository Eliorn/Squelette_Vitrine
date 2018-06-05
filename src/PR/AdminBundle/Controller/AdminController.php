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
      $em = $this->getDoctrine()->getManager();
      $accueilRepository = $em->getRepository('PRVitrineBundle:Accueil');
      $listAccueil = $accueilRepository->findAll();
      return $this->render('PRAdminBundle:Admin:accueil.html.twig', array(
                'listAccueil' => $listAccueil,
              )
      );
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
      $em = $this->getDoctrine()->getManager();
      $contactRepository = $em->getRepository('PRVitrineBundle:Contact');

      $listContacts = $contactRepository->findAll();
      return $this->render('PRAdminBundle:Admin:contact.html.twig', array(
                'listContacts' => $listContacts,
              )
      );

    }

    public function galleryAction()
    {
      $em = $this->getDoctrine()->getManager();
      $galleryRepository = $em->getRepository('PRVitrineBundle:Gallery');

      $listGalleries = $galleryRepository->findAll();
      return $this->render('PRAdminBundle:Admin:gallery.html.twig', array(
                'listGalleries' => $listGalleries,
              )
      );
    }


}
