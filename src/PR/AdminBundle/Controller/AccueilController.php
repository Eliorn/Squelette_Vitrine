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

class AccueilController extends Controller
{

    public function accueilAction()
    {

      $em = $this->getDoctrine()->getManager();
      $accueilRepository = $em->getRepository('PRVitrineBundle:Accueil');
      $accueil = $accueilRepository->find(1);

      $formBuilder = $this->createFormBuilder($accueil)
                          ->add('Contenu',  CKEditorType::Class);

      $form= $formBuilder->getForm();



      return $this->render('PRAdminBundle:Admin:accueil.html.twig', array(
                'form' => $form->createView(),

              )
      );
    }

    public function accueilValidateAction(Request $request){
      $em = $this->getDoctrine()->getManager();
      $accueilRepository = $em->getRepository('PRVitrineBundle:Accueil');
      $accueil = $accueilRepository->find(1);
      $contenu = $request->request->get('form')['Contenu'];

      if ($request->request->get('action')== 'Valider'){
        $accueil->setContenu($contenu);
        $em->persist($accueil);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "La mise a jour de l'accueil a été effectuée");
      }else{
        $request->getSession()->getFlashBag()->add('warn', "Retour au début !");
      }



      $formBuilder = $this->createFormBuilder($accueil)
                          ->add('Contenu',  CKEditorType::Class);

      $form= $formBuilder->getForm();



      return $this->render('PRAdminBundle:Admin:accueil.html.twig', array(
                'form' => $form->createView(),

              )
      );

    }
}
