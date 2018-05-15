<?php

// src/OC/PlatformBundle/Controller/VitrineController.php

namespace PR\VitrineBundle\Controller;

// N'oubliez pas ce use :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class VitrineController extends Controller
{
  public function indexAction()
  {
    $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:accueil.html.twig');

    return new Response($content);
  }

  public function carouselAction()
  {
    $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:carrousel.html.twig');

    return new Response($content);
  }

  public function gallerieAction()
  {

    $dir=$_SERVER['DOCUMENT_ROOT']."/web_vitrine/web/uploads";
      // echo '<pre>';

      //on parcour le dossier pour les titres des fichiers
      if($dossier = @opendir($dir)){
        while(($fichier = readdir($dossier))!==false ){
          if($fichier != '.' && $fichier != '..'){

          }
        }
      }
      // echo '</pre>';
      //on parcour le dossier pour récupérer le contenu des fichiers

      $htmlToShow='<table id="table" class="table table-striped table-bordered table-hover">
        <caption> Fichiers déposés </caption>
        <thead>
          <tr>
          <th colspan="1" rowspan="1"  tabindex="1">Fichier</th>
          <th colspan="1" rowspan="1"  tabindex="2">Lien vers le fichier </th>
          <th colspan="1" rowspan="1"  tabindex="3">Date de dépot </th>
          </tr>
        </thead>
        <tbody>	';
      if($dossier = @opendir($dir)){

        while(false !== ($fichier = readdir($dossier))){


          if($fichier != '.' && $fichier != '..'){
            $dirComplet=$_SERVER['DOCUMENT_ROOT']."/web_vitrine/web/uploads/files/";


            if($dossier2 = @opendir($dirComplet)){

              while(($fichier2 = readdir($dossier2))!==false ){
                if (!is_dir($dirComplet.$fichier2)){
                  if($fichier2 != '.' && $fichier2 != '..'){

                    $htmlToShow.="<tr>
                        <td> $fichier</td>
                        <td> <a target='_blank' href='.".($this->getParameter('dir_uploads')."files/$fichier2")."'>$fichier2</a> </td>
                        <td> ".date ('d/m/Y H:m:s', filemtime($dirComplet.$fichier2))."</td>
                      </tr>";

                    clearstatcache();
                  }
                }
              }
            }
          }

        }
      }
      $htmlToShow.='</table>';
      return $this->render('PRVitrineBundle:Vitrine:gallerie.html.twig', array(
              'tabResult' => $htmlToShow
      ));
  }

  public function contactsAction()
  {
    $content = $this->get('templating')->render('PRVitrineBundle:Vitrine:contacts.html.twig');

    return new Response($content);
  }

  public function uploadAction()
  {
    $content = $this->get('templating')->render('PRVitrineBundle:Upload:presentation.html.twig');

    return new Response($content);
  }
}
