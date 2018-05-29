<?php

// src/PR/VitrineBundle/Controller/VitrineController.php

namespace PR\VitrineBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use PR\VitrineBundle\Form\Type\ContactType;

class BusinessController extends Controller
{

  public function prestationsAction()
  {

    $em = $this->getDoctrine()->getManager();
    $prestationRepository = $em->getRepository('PRVitrineBundle:Prestation');

    $queryListPrestation = $prestationRepository->createQueryBuilder('a')->orderBy('a.type','DESC');
    $query = $queryListPrestation->getQuery();
    $listPrestation = $query->getResult();

    return $this->render('PRVitrineBundle:Business:prestations.html.twig', array(
              'listPrestations' => $listPrestation,
            )
    );
  }





}
