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

    $queryListGalleries = $galleriesRepository->createQueryBuilder('a')
                          ->where('a.id > -1')
                          ->orderBy('a.galleryorder','ASC');
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

    $em = $this->getDoctrine()->getManager();
    $imageRepository = $em->getRepository('PRVitrineBundle:Image');
    $galleriesRepository = $em->getRepository('PRVitrineBundle:Gallery');
    $galleryDirectory=$this->get('kernel')->getRootDir().'/../web/data/galleries/'.$galleryName;
    $galleryDirectoryWeb='./data/galleries/'.$galleryName.'/';
    $queryListImg = $imageRepository->createQueryBuilder('a')
                                    ->where('a.galleryPath=?1 ')
                                    ->orderBy('a.pictureOrder','ASC');
    $queryListImg->setParameters(array(1 => $galleryDirectoryWeb));
    $query = $queryListImg->getQuery();
    $listImg = $query->getResult();
        $galleryTitle= $galleriesRepository->findOneBy(['directory' => $galleryName])->getTitle();
    return $this->render('PRVitrineBundle:Gallery:gallery_detail.html.twig',array(

              'galleryName' => $galleryName,
              'galleryTitle' => $galleryTitle,
              'galleryDirectory' => $galleryDirectoryWeb,
              'galleryList' => $listImg
            ));

  }






}
