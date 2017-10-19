<?php

namespace CitiesBundle\Controller;

use CitiesBundle\Entity\Avis;
use CitiesBundle\Form\AvisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AvisController extends Controller
{
    public function postAction($departementSlug, $villeSlug, $idville, Request $request)
    {
        $avis = new Avis();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(AvisType::class, $avis);
        $villeRepo = $em->getRepository('CitiesBundle:Ville');
        $ville = $villeRepo->find($idville);

        if ($request->isMethod('POST')) {
            //todo traitement du formulaire
            $service_avis = $this->get('cities.handle.avis');
            try {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $service_avis->saveAvis($avis, $ville);
                } else {
                    $message_error = "";
                    foreach ($form->getErrors() as $error) {
                        $message_error .= "<strong>Erreur</strong> ".$error->getMessageTemplate()."</br>";
                    }
                    throw new \Exception($message_error);
                }

            } catch (\Exception $e) {
                return $this->redirectToRoute("route_503", array("message" => $e->getMessage()), 302);
            }
        }

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
