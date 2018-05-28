<?php

// src/OC/PlatformBundle/Controller/VitrineController.php

namespace PR\VitrineBundle\Controller;

// N'oubliez pas ce use :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class VitrineController extends Controller
{
  public function indexAction()
  {


    $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:accueil.html.twig');

    return new Response($content);
  }

  public function actualitesAction()
  {

    $em = $this->getDoctrine()->getManager();
    $articlesRepository = $em->getRepository('PRVitrineBundle:Article');

    $queryListArticles = $articlesRepository->createQueryBuilder('a')->orderBy('a.date','DESC');
    $query = $queryListArticles->getQuery();
    $listArticles = $query->getResult();
    return $this->render('PRVitrineBundle:Vitrine:actualites.html.twig', array(
              'listArticles' => $listArticles,
            )
    );

  }

  public function galleriesAction()
  {

    $em = $this->getDoctrine()->getManager();
    $articlesRepository = $em->getRepository('PRVitrineBundle:Gallery');

    $queryListArticles = $articlesRepository->createQueryBuilder('a')->orderBy('a.title','DESC');
    $query = $queryListArticles->getQuery();
    $listGalleries = $query->getResult();

    return $this->render('PRVitrineBundle:Vitrine:galleries.html.twig', array(
              'listGalleries' => $listGalleries,
            )
    );

  }

  public function galleryDetailAction(Request $request)
  {

    $galleryName=$request->attributes->get('gallery');

    $galleryDirectory=$this->get('kernel')->getRootDir().'/../web/data/galleries/'.$galleryName;
    $galleryDirectoryWeb='./data/galleries/'.$galleryName.'/';
    $listImg = array_diff(scandir($galleryDirectory),array('..','.'));
    return $this->render('PRVitrineBundle:Vitrine:gallery_detail.html.twig',array(
              'galleryName' => $galleryName,
              'galleryDirectory' => $galleryDirectoryWeb,
              'galleryList' => $listImg
            ));

  }

  public function prestationsAction()
  {

    $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:prestations.html.twig');

    return new Response($content);
  }


  public function reportagesAction()
    {

      $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:reportages.html.twig');

      return new Response($content);
  }


  public function contactsAction()
  {
    $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:contacts.html.twig');

    return new Response($content);
  }


}
