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
      $accueil = $accueilRepository->findBy(array('id'=>1));

      $formBuilder = $this->createFormBuilder($accueil[0])
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
      $accueil = $accueilRepository->findBy(array('id'=>1));
      $acceuil = $accueil[0];
      $contenu = $request->request->get('form')['Contenu'];

      if ($request->request->get('action')== 'Valider'){
        $acceuil->setContenu($contenu);
        $em->persist($acceuil);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "La mise a jour de l'accueil a été effectuée");
      }else{
        $request->getSession()->getFlashBag()->add('warn', "Retour au début !");
      }



      $formBuilder = $this->createFormBuilder($acceuil)
                          ->add('Contenu',  CKEditorType::Class);

      $form= $formBuilder->getForm();



      return $this->render('PRAdminBundle:Admin:accueil.html.twig', array(
                'form' => $form->createView(),

              )
      );

    }
}
