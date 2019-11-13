<?php

namespace PR\AdminBundle\Uploader;

use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpFoundation\RequestStack;

class ImageNamer implements NamerInterface
{
    private $tokenStorage;
    protected $requestStack;
    
    public function __construct(TokenStorage $tokenStorage, RequestStack $requestStack ){
        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
    }
    
    /**
     * Creates a user directory name for the file being uploaded.
     *
     * @param FileInterface $file
     * @return string The directory name.
     */
    public function name(FileInterface $file)
    {
        $request=$this->requestStack->getCurrentRequest();
        
        $url= $request->server->get("HTTP_REFERER");
        if(preg_match("/\/(\w+)$/",$url,$matches))
        {
            $dirId=$matches[1];
        }
        else
        {
           $dirId="default";
        }
       
        return sprintf('%s/%s.%s',
            $dirId,
            uniqid(),
            $file->getExtension()
        );
    }
}