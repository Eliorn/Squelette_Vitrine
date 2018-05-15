<?php
namespace PR\VitrineBundle\Uploader;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\EventDispatcher\Event;
use Oneup\UploaderBundle\Event\PostUploadEvent;



class UploadListener
{

  
    public function onUpload(PostUploadEvent $event)
    {
        $session= new Session();
        $file=$event->getFile()->getFilename();
        $size=$event->getFile()->getSize();
        $pathToFile=$event->getFile()->getPathname();
        $extension=$event->getFile()->getExtension();
        $session->getFlashBag()->add('success', "Transmission du fichier \" $file \" : OK");
        $response = $event->getResponse();
        $response['success'] = true;
        $output = [[
            'url'  => $pathToFile,
            'thumbnail_url' => $pathToFile,
            'name' => $file,
            'type' => $extension,
            'size' => $size,
            'delete_url'   => "",
            'delete_type' => 'DELETE' // method for destroy action
        ]];
        $response = $event->getResponse();
        $response["files"] = $output;

        return $response;

    }
}

?>
