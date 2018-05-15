<?php

namespace PR\VitrineBundle\Uploader;


use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use Symfony\Component\HttpFoundation\Session\Session;




class NamingInterface implements NamerInterface
{
    public function name(FileInterface $file)
    {
        $session=new Session();
        return sprintf('files/%s',
              $file->getClientOriginalName()
        );

    }
    /*
    public function name(FileInterface $file)
    {
        $session=new Session();
        $annee= $session->get('annee');
        $nameComposante= $session->get('lib_composante');

        return sprintf('%s/%s/files/fiches/%s',
            $nameComposante,
            $annee,
            $file->getClientOriginalName()
        );

    }*/
}
