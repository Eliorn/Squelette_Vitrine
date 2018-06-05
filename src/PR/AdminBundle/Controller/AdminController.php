<?php

namespace PR\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

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
      $accueil = $accueilRepository->findBy(array('id'=>1));

      $formBuilder = $this->createFormBuilder($accueil[0])
                          ->add('Contenu',  CKEditorType::Class);

      $form= $formBuilder->getForm();



      return $this->render('PRAdminBundle:Admin:accueil.html.twig', array(
                'form' => $form->createView(),

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
