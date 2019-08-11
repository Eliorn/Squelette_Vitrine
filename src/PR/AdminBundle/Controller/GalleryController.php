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
    //  $this->gallerySynchronise();
      $listGalleries = $galleryRepository->findAll();
      return $this->render('PRAdminBundle:Admin:gallery.html.twig', array(
                'listGalleries' => $listGalleries,
              )
      );
    }


    private function gallerySynchronise(){
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


    public function galleryNewAction(Request $request){
      $em = $this->getDoctrine()->getManager();
      $galleryRepository = $em->getRepository('PRVitrineBundle:Gallery');
      $gallery= new Gallery();

      if ($request->request->get('action')== 'Valider'){

        if (is_dir($this->get('kernel')->getRootDir().'/../web/data/galleries/'.strtolower($request->request->get('form')['Title']))){

              $request->getSession()->getFlashBag()->add('error', "Une galerie avec le même nom existe déjà ! ");
        }else{
          mkdir($this->get('kernel')->getRootDir().'/../web/data/galleries/'.strtolower($request->request->get('form')['Title']));

          $gallery->setTitle($request->request->get('form')['Title']);
          $gallery->setDescription($request->request->get('form')['Description']);
          $gallery->setCaption($request->request->get('form')['Caption']);
          $gallery->setDirectory(strtolower($request->request->get('form')['Title']));
          $em->persist($gallery);
          $em->flush();
          $request->getSession()->getFlashBag()->add('success', "La création de la galerie a été effectuée");

        }
      }else if ($request->request->get('action')== 'Réinitialiser'){
        $request->getSession()->getFlashBag()->add('warn', "Retour au début !");
      }

      $formBuilder = $this->createFormBuilder($gallery)
                          ->add('Title',    TextType::Class , array('empty_data' => 'Votre titre ici'))
                          ->add('Description',  TextType::Class , array('empty_data' => 'La description de la galerie'))
                          ->add('Caption', TextType::Class);

      $form= $formBuilder->getForm();

      return $this->render('PRAdminBundle:Admin:gallery_new.html.twig', array(
                'form' => $form->createView(),
            )
      );
    }

    public function galleryDeleteAction(Request $request){



      return $this->render('PRAdminBundle:Admin:gallery_populate.html.twig', array(

            )
      );
    }


    public function galleryEditAction(Request $request){

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

      return $this->render('PRAdminBundle:Admin:gallery_populate.html.twig',array(
                'galleryName' => $galleryName,
                'galleryDirectory' => $galleryDirectoryWeb,
                'listPictures' => $listImg
              ));

    }


    public function deleteImageFromGalleryAction(Request $request){

      $galleryName=$request->attributes->get('galleryName');
      $imageName=$request->attributes->get('image');
      $em = $this->getDoctrine()->getManager();
      $imageRepository = $em->getRepository('PRVitrineBundle:Image');

      $galleriesRepository = $em->getRepository('PRVitrineBundle:Gallery');
      $galleryDirectory=$this->get('kernel')->getRootDir().'/../web/data/galleries/'.$galleryName;
      $galleryDirectoryWeb='./data/galleries/'.$galleryName.'/';

      $imageToDel = $imageRepository->findOneBy(array('name' => $imageName, 'galleryPath' => $galleryDirectoryWeb));
      $em->remove($imageToDel);
      $em->flush();
      @unlink($galleryDirectory.'/'.$imageName);


      $queryListImg = $imageRepository->createQueryBuilder('a')
                                      ->where('a.galleryPath=?1 ')
                                      ->orderBy('a.pictureOrder','ASC');
      $queryListImg->setParameters(array(1 => $galleryDirectoryWeb));
      $query = $queryListImg->getQuery();
      $listImg = $query->getResult();

      return $this->render('PRAdminBundle:Admin:gallery_populate.html.twig',array(
                'galleryName' => $galleryName,
                'galleryDirectory' => $galleryDirectoryWeb,
                'listPictures' => $listImg
              ));


    }

    public function addImageToGallery(Request $request){


    }


}
