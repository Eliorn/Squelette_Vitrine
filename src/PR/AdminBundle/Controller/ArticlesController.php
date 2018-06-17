<?php

namespace PR\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use PR\VitrineBundle\Entity\Article;

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

    public function articleNewAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $articlesRepository = $em->getRepository('PRVitrineBundle:Article');
      $article= new Article();

      if ($request->request->get('action')== 'Valider'){
        $content = $request->request->get('form')['Content'];
        $title = $request->request->get('form')['Title'];
        if (isset($request->request->get('form')['Published'])){
            $published = true;
        }else{
            $published = false;          
        }
        $user = $this->get('security.token_storage')->getToken()->getUser()->getUsername();
        $date= new \DateTime();

        $article->setContent($content);
        $article->setTitle($title);
        $article->setDate($date);
        $article->setEditor($user);
        $article->setPublished($published);

        $em->persist($article);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "La création de l'article a été effectuée");
      }else if ($request->request->get('action')== 'Annuler'){
        $request->getSession()->getFlashBag()->add('warn', "Retour au début !");
      }

      $formBuilder = $this->createFormBuilder($article)
                          ->add('Title',    TextType::Class , array('empty_data' => 'Votre titre ici'))
                          ->add('Content',  CKEditorType::Class , array('empty_data' => 'Contenu de l\'article'))
                          ->add('Published', CheckboxType::Class, array('required' => false));

      $form= $formBuilder->getForm();

      return $this->render('PRAdminBundle:Admin:article_new.html.twig', array(
                'form' => $form->createView(),
            )
      );

    }

    public function articleEditAction($id, Request $request )
    {
      $em = $this->getDoctrine()->getManager();
      $articlesRepository = $em->getRepository('PRVitrineBundle:Article');
      $article= $articlesRepository->find($id);

      if ($request->request->get('action')== 'Valider'){
        $content = $request->request->get('form')['Content'];
        $title = $request->request->get('form')['Title'];
        $user = $this->get('security.token_storage')->getToken()->getUser()->getUsername();
        $date= new \DateTime();
        $article->setContent($content);
        $article->setTitle($title);
        $article->setDate($date);
        $article->setEditor($user);

        $em->persist($article);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "La mise a jour de l'article a été effectuée");
      }else if ($request->request->get('action')== 'Annuler'){
        $request->getSession()->getFlashBag()->add('warn', "Retour au début !");
      }

      $formBuilder = $this->createFormBuilder($article)
                          ->add('Title',    TextType::Class)
                          ->add('Content',  CKEditorType::Class);

      $form= $formBuilder->getForm();

      return $this->render('PRAdminBundle:Admin:article_edit.html.twig', array(
                'form' => $form->createView(),
                'article_id' => $id
              )
      );

    }

    public function articleDeleteAction($id , Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $articlesRepository = $em->getRepository('PRVitrineBundle:Article');
      $article= $articlesRepository->find($id);
      if (!$article){
        $request->getSession()->getFlashBag()->add('error', "L'article n'a pas pu être supprimé. Id $id non trouvé");
      }else{
        $em->remove($article);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "L'article a été supprimé.");

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
