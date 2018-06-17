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
use PR\VitrineBundle\Entity\Contact;

class ContactsController extends Controller
{



    public function contactAction()
    {
      $em = $this->getDoctrine()->getManager();
      $contactRepository = $em->getRepository('PRVitrineBundle:Contact');

      $listContacts = $contactRepository->findAll();
      return $this->render('PRAdminBundle:Admin:contact.html.twig', array(
                'listContacts' => $listContacts,
              )
      );

    }


        public function contactNewAction(Request $request)
        {
          $em = $this->getDoctrine()->getManager();
          $contactsRepository = $em->getRepository('PRVitrineBundle:Contact');
          $contact= new Contact();

          if ($request->request->get('action')== 'Valider'){
            $email = $request->request->get('form')['email'];
            $type = $request->request->get('form')['type'];
            $contact->setEmail($email);
            $contact->setType($type);
            $em->persist($contact);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "La création du contact a été effectuée");
          }else if ($request->request->get('action')== 'Annuler'){
            $request->getSession()->getFlashBag()->add('warn', "Retour au début !");
          }

          $formBuilder = $this->createFormBuilder($contact)
                              ->add('email', TextType::Class)
                              ->add('type',  TextType::Class);

          $form= $formBuilder->getForm();

          return $this->render('PRAdminBundle:Admin:contact_new.html.twig', array(
                    'form' => $form->createView(),
                )
          );

        }

        public function contactEditAction($id, Request $request )
        {
          $em = $this->getDoctrine()->getManager();
          $contactsRepository = $em->getRepository('PRVitrineBundle:Contact');
          $contact= $contactsRepository->find($id);

          if ($request->request->get('action')== 'Valider'){
            $email = $request->request->get('form')['email'];
            $type = $request->request->get('form')['type'];
            $contact->setEmail($email);
            $contact->setType($type);
            $em->persist($contact);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "La mise a jour de l'contact a été effectuée");
          }else if ($request->request->get('action')== 'Annuler'){
            $request->getSession()->getFlashBag()->add('warn', "Retour au début !");
          }

          $formBuilder = $this->createFormBuilder($contact)
                              ->add('email', TextType::Class)
                              ->add('type',  TextType::Class);

          $form= $formBuilder->getForm();

          return $this->render('PRAdminBundle:Admin:contact_edit.html.twig', array(
                    'form' => $form->createView(),
                    'contact_id' => $id
                  )
          );

        }

        public function contactDeleteAction($id , Request $request)
        {
          $em = $this->getDoctrine()->getManager();
          $contactsRepository = $em->getRepository('PRVitrineBundle:Contact');
          $contact= $contactsRepository->find($id);
          if (!$contact){
            $request->getSession()->getFlashBag()->add('error', "Le contact n'a pas pu être supprimé. Id $id non trouvé");
          }else{
            $em->remove($contact);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', "Le contact a été supprimé.");

          }

          $listContacts = $contactsRepository->findAll();
          return $this->render('PRAdminBundle:Admin:contact.html.twig', array(
                    'listContacts' => $listContacts,
                  )
          );

        }




}
