<?php

// src/PR/VitrineBundle/Controller/VitrineController.php

namespace PR\VitrineBundle\Controller;

use PR\VitrineBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ContactController extends Controller
{

  public function contactsAction()
  {

    $contact = new Contact();

    $formBuilder = $this->get('form.factory')->createBuilder();

    $formBuilder
      ->add('email',      TextType::class)
      ->add('type',       ChoiceType::class, array('choices'=> array('Technique' => 'tech' , 'Administrateur du site' =>'admin' )  ))
      ->add('subject',    TextType::class)
      ->add('content',    CKEditor::class);

    $form= $formBuilder->getForm();

    return $this->render('PRVitrineBundle:Contact:contacts.html.twig', array(
              'form' => $form->createView(),
            )
    );
  }

  public function contactsEnvoiAction(Request $request )
  {

    $em = $this->getDoctrine()->getManager();
    $contactRepository = $em->getRepository('PRVitrineBundle:Contact');

    $queryContact = $contactRepository->createQueryBuilder('c')
                                                ->where('c.type=?1')
                                                ->orderBy('c.type','DESC');

    $queryContact->setParameters(array(1 => $request->request->get('form')['type']));
    $query = $queryContact->getQuery();
    $contact = $query->getSingleResult();

    $message= (new \Swift_Message($request->request->get('form')['subject']))
              ->setFrom($request->request->get('form')['email'])
              ->setTo($contact->getEmail())
              ->setBody("Adresse email de l'expéditeur : ".$request->request->get('form')['email']."<br/><br/>Contenu :".$request->request->get('form')['content'],'text/html')
              ;

    $this->get('mailer')->send($message);

    $formBuilder = $this->get('form.factory')->createBuilder();

    $formBuilder
    ->add('email',      TextType::class)
    ->add('type',       ChoiceType::class, array('choices'=> array('Technique' => 'tech' , 'Administrateur du site' =>'admin' )  ))
    ->add('subject',    TextType::class)
    ->add('content',    TextareaType::class);

    $form= $formBuilder->getForm();
    $request->getSession()->getFlashBag()->add('info', "Votre email a bien été envoyé");
    return $this->render('PRVitrineBundle:Contact:contacts.html.twig', array(
              'form' => $form->createView(),
            )
    );
  }

}
