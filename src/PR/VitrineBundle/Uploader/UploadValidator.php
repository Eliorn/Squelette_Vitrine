<?php
namespace PR\VitrineBundle\Uploader;

use Oneup\UploaderBundle\Event\ValidationEvent;
use Oneup\UploaderBundle\Uploader\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Session\Session;

class UploadValidator
{
    public function onValidate(ValidationEvent $event)
    {
        $config  = $event->getConfig();
        $file    = $event->getFile();
        $type    = $event->getType();
        $request = $event->getRequest();
        $response = $event->getResponse();
        $session = new Session();
        $filename=$file->getClientOriginalName();
        if ($file->getError()==1){
          $response['success'] = 'exception';
          $session->getFlashBag()->add('error', "Transmission du fichier \" $filename \" : KO ! Raison : ");
          throw new ValidationException("Une erreur s\'est produite lors du téléchargement du fichier <br/> Contactez l'assistance.");

        }

    }
}


 ?>
