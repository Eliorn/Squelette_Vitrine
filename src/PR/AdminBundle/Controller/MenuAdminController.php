<?php

// src/OC/PlatformBundle/Controller/VitrineController.php

namespace PR\AdminBundle\Controller;

// N'oubliez pas ce use :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class MenuAdminController extends Controller
{
  public function listAction()
  {
    $em = $this->getDoctrine()->getManager();
    $menuRepository = $em->getRepository('PRAdminBundle:MenuAdmin');

    $listMenu = $menuRepository->findBy(array(),array('order'=> 'ASC'));

    return $this->render('PRAdminBundle:Menu:menuAdmin.html.twig', array(
              'listMenu' => $listMenu,
            )
          );

  }



}
