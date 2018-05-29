<?php

// src/PR/VitrineBundle/Controller/VitrineController.php

namespace PR\VitrineBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use PR\VitrineBundle\Form\Type\ContactType;

class GalleryController extends Controller
{


  public function galleriesAction()
  {

    $em = $this->getDoctrine()->getManager();
    $galleriesRepository = $em->getRepository('PRVitrineBundle:Gallery');

    $queryListGalleries = $galleriesRepository->createQueryBuilder('a')->orderBy('a.title','DESC');
    $query = $queryListGalleries->getQuery();
    $listGalleries = $query->getResult();

    return $this->render('PRVitrineBundle:Gallery:galleries.html.twig', array(
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
    return $this->render('PRVitrineBundle:Gallery:gallery_detail.html.twig',array(
              'galleryName' => $galleryName,
              'galleryDirectory' => $galleryDirectoryWeb,
              'galleryList' => $listImg
            ));

  }






}
