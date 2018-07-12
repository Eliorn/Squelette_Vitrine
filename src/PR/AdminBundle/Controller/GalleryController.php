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
use PR\VitrineBundle\Entity\Gallery;
use PR\VitrineBundle\Entity\Image;

class GalleryController extends Controller
{


    public function galleryAction()
    {
      $em = $this->getDoctrine()->getManager();
      $galleryRepository = $em->getRepository('PRVitrineBundle:Gallery');
      $this->gallerySynchronise();
      $listGalleries = $galleryRepository->findAll();
      return $this->render('PRAdminBundle:Admin:gallery.html.twig', array(
                'listGalleries' => $listGalleries,
              )
      );
    }


    public function gallerySynchronise(){
      $em = $this->getDoctrine()->getManager();
      $galleryRepository = $em->getRepository('PRVitrineBundle:Gallery');
      $imageRepository = $em->getRepository('PRVitrineBundle:Image');
      $listGalleries = $galleryRepository->findAll();

      foreach ($listGalleries as $gallery) {
        $pictureOrder=0;
        $galleryDirectory=$this->get('kernel')->getRootDir().'/../web/data/galleries/'.$gallery->getDirectory();
        $galleryDirectoryWeb='./data/galleries/'.$gallery->getDirectory().'/';
        $listImg = array_diff(scandir($galleryDirectory),array('..','.'));
        foreach ($listImg as $img){
          $pictureOrder++;
          $image = new Image();
          $image->setFullPath($galleryDirectory.'/'.$img);
          $image->setGalleryPath($galleryDirectoryWeb);
          $image->setName($img);
          $image->setPictureOrder($pictureOrder);
          $image->addGallery($gallery);

          $em->persist($image);
          $em->flush();
        }
      }

    }



}
