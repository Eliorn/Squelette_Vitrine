<?php

namespace PR\AdminBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;

use PR\VitrineBundle\Entity\Gallery;
use PR\VitrineBundle\Entity\Image;




class UploadListener
{
    /**
     * @var ObjectManager
     */
    private $om;

    private $container;

    public function __construct(ObjectManager $om , ContainerInterface $container , RouterInterface $router)
    {
        $this->om = $om;
        $this->container = $container;
        $this->router = $router;
    }
    
    public function onUpload(PostPersistEvent $event)
    {
        //...Doctrine todo
        $request = $event->getRequest();
     
        $url= $request->server->get("HTTP_REFERER");
       
        if(preg_match("/\/(\w+)$/",$url,$matches))
        {
            $dirId=$matches[1];
        }
        else
        {
            $dirId="default";
        }
        $this->gallerySynchronise($dirId);

        //if everything went fine

        $route ='admin_gallery_edit';
        if ($route === $event->getRequest()->get('_route')) {
            return;
        }
        $url = $this->router->generate($route, array('gallery' => $dirId));
        $response = new RedirectResponse($url);
 
        return $response;
        
    }


    private function gallerySynchronise($directory){
        $em = $this->om;
        $galleryRepository = $em->getRepository('PRVitrineBundle:Gallery');
        $imageRepository = $em->getRepository('PRVitrineBundle:Image');
        $listGalleries = $galleryRepository->findBy(["directory" => $directory]);

   
        foreach ($listGalleries as $gallery) {
            $pictureOrder=0;
            $galleryDirectory=$this->container->get('kernel')->getRootDir().'/../web/data/galleries/'.$gallery->getDirectory();
            $galleryDirectoryWeb='./data/galleries/'.$gallery->getDirectory().'/';
            $lastOrder = $imageRepository->getMaxOrder($galleryDirectoryWeb) ?? 0;
            $pictureOrder=$lastOrder[0]['max_order']??0;
            $listImg = array_diff(scandir($galleryDirectory),array('..','.'));
            foreach ($listImg as $img){
              $image = $imageRepository->findBy(["name"=> $img]);
              if (!$image){
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
}

?>