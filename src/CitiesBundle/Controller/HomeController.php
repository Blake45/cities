<?php

namespace CitiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $villeRepo = $this->getDoctrine()->getManager()->getRepository('CitiesBundle:Ville');

        return $this->render('CitiesBundle:Home:index.html.twig', array(
            'title' => 'Project Cities WIP',
            'villes' => $villeRepo->getVillesImportantes()
        ));
    }

}
