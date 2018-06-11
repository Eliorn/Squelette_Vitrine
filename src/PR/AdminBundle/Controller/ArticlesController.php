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

class ArticlesController extends Controller
{


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

    public function articleNewAction()
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

    public function articleEditAction()
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

    public function articleDeleteAction()
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

    public function articlePublishAction($id ,Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $articlesRepository = $em->getRepository('PRVitrineBundle:Article');

      $action=$request->request->get('action');
      $article= $articlesRepository->find($id);
      if ($action=="Publier"){
        $article->setPublished(true);
        $em->persist($article);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "L'article a été publié.");
      }else{
        $article->setPublished(false);
        $em->persist($article);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "L'article a été dépublié.");
      }




      $queryListArticles = $articlesRepository->createQueryBuilder('a')
                                              ->orderBy('a.date','DESC');
      $query = $queryListArticles->getQuery();
      $listArticles = $query->getResult();


      return $this->render('PRAdminBundle:Admin:article.html.twig', array(
                'listArticles' => $listArticles,
              )
      );

    }



}
