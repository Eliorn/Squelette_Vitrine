<?php

namespace PR\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use PR\VitrineBundle\Entity\Prestation;

class PrestationsController extends Controller
{


    public function prestationAction()
    {
      $em = $this->getDoctrine()->getManager();
      $prestationsRepository = $em->getRepository('PRVitrineBundle:Prestation');
      $listPrestations = $prestationsRepository->findAll();
      return $this->render('PRAdminBundle:Admin:prestation.html.twig', array(
                'listPrestations' => $listPrestations,
              )
      );

    }

    public function prestationNewAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $prestationsRepository = $em->getRepository('PRVitrineBundle:Prestation');
      $prestation= new Prestation();

      if ($request->request->get('action')== 'Valider'){
        $description = $request->request->get('form')['Description'];
        $title = $request->request->get('form')['Title'];
        $type = $request->request->get('form')['Type'];
        $price=null;
        if (isset($request->request->get('form')['Price'])){
          $price=$request->request->get('form')['Price'];
        }

        $prestation->setDescription($description);
        $prestation->setTitle($title);
        $prestation->setType($type);
        $prestation->setPrice($price);


        $em->persist($prestation);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "La création de la prestation a été effectuée");
      }else if ($request->request->get('action')== 'Annuler'){
        $request->getSession()->getFlashBag()->add('warn', "Retour au début !");
      }

      $formBuilder = $this->createFormBuilder($prestation)
                          ->add('Title',        TextType::Class , array('empty_data' => 'Votre titre ici'))
                          ->add('Type',         TextType::Class , array('empty_data' => 'Votre type ici'))
                          ->add('Description',  CKEditorType::Class , array('empty_data' => 'Contenu de la prestation'))
                          ->add('Price',        TextType::Class, array('required' => false));

      $form= $formBuilder->getForm();

      return $this->render('PRAdminBundle:Admin:prestation_new.html.twig', array(
                'form' => $form->createView(),
            )
      );

    }

    public function prestationEditAction($id, Request $request )
    {
      $em = $this->getDoctrine()->getManager();
      $prestationsRepository = $em->getRepository('PRVitrineBundle:Prestation');
      $prestation= $prestationsRepository->find($id);

      if ($request->request->get('action')== 'Valider'){
        $description = $request->request->get('form')['Description'];
        $title = $request->request->get('form')['Title'];
        $type = $request->request->get('form')['Type'];
        $price=null;
        if (isset($request->request->get('form')['Price'])){
          $price=$request->request->get('form')['Price'];
        }

        $prestation->setDescription($description);
        $prestation->setTitle($title);
        $prestation->setType($type);
        $prestation->setPrice($price);

        $em->persist($prestation);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "La mise a jour de la prestation a été effectuée");
      }else if ($request->request->get('action')== 'Annuler'){
        $request->getSession()->getFlashBag()->add('warn', "Retour au début !");
      }

      $formBuilder = $this->createFormBuilder($prestation)
                          ->add('Title',        TextType::Class , array('empty_data' => 'Votre titre ici'))
                          ->add('Type',         TextType::Class , array('empty_data' => 'Votre type ici'))
                          ->add('Description',  CKEditorType::Class , array('empty_data' => 'Contenu de la prestation'))
                          ->add('Price',        TextType::Class, array('required' => false));

      $form= $formBuilder->getForm();

      return $this->render('PRAdminBundle:Admin:prestation_edit.html.twig', array(
                'form' => $form->createView(),
                'prestation_id' => $id
              )
      );

    }

    public function prestationDeleteAction($id , Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $prestationsRepository = $em->getRepository('PRVitrineBundle:Prestation');
      $prestation= $prestationsRepository->find($id);
      if (!$prestation){
        $request->getSession()->getFlashBag()->add('error', "La prestation n'a pas pu être supprimée. Id $id non trouvé");
      }else{
        $em->remove($prestation);
        $em->flush();
        $request->getSession()->getFlashBag()->add('success', "La prestation a été supprimée.");

      }

      $listPrestations = $prestationsRepository->findAll();
      return $this->render('PRAdminBundle:Admin:prestation.html.twig', array(
                'listPrestations' => $listPrestations,
              )
      );

    }


}
