<?php

namespace CitiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function indexAction()
    {
        $villeRepo = $this->getDoctrine()->getManager()->getRepository('CitiesBundle:Ville');

        return $this->render('CitiesBundle:Home:index.html.twig', array(
            'title' => 'Project Cities WIP',
            'villes' => $villeRepo->getVillesImportantes(),
            'API_KEY' => $this->get('cities.ville')->getGmapsAPI_KEY()
        ));
    }

    public function searchAction(Request $request)
    {
        //todo liste resultat, ville region departement
    }

}
