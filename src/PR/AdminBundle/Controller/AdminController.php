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

class AdminController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('PRAdminBundle:Admin:admin.html.twig');
    }



}
