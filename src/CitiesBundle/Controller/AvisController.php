<?php

namespace CitiesBundle\Controller;

use CitiesBundle\Entity\Avis;
use CitiesBundle\Form\AvisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AvisController extends Controller
{
    public function postAction($departementSlug, $villeSlug, $idville)
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);
        $villeRepo = $this->getDoctrine()->getManager()->getRepository('CitiesBundle:Ville');
        $ville = $villeRepo->find($idville);

        return $this->render('CitiesBundle:Avis:post.html.twig', array(
            'title' => "Formulaire de dépôt d'avis sur la ville ".$ville->getName(),
            'form' => $form->createView(),
            'ville' => $ville
        ));
    }

    public function listeAction($regionSlug, $departementSlug, $villeSlug)
    {
        return $this->render('CitiesBundle:Avis:liste.html.twig', array(
            // ...
        ));
    }

    public function postSaveAction()
    {
        return $this->render('CitiesBundle:Avis:post_save.html.twig', array(
            // ...
        ));
    }

}
