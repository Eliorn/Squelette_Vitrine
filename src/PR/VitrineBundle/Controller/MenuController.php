<?php

// src/OC/PlatformBundle/Controller/VitrineController.php

namespace PR\VitrineBundle\Controller;

// N'oubliez pas ce use :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class MenuController extends Controller
{
  public function listAction()
  {
    $em = $this->getDoctrine()->getManager();
    $menuRepository = $em->getRepository('PRVitrineBundle:Menu');
    $queryListMenu = $menuRepository->createQueryBuilder('m')
                                    ->where('m.showMenu=1')
                                    ->orderBy('m.order','ASC');
    $query = $queryListMenu->getQuery();
    $listMenu = $query->getResult();

    return $this->render('PRVitrineBundle:Menu:menu.html.twig', array(
              'listMenu' => $listMenu,
            )
          );

  }



}
