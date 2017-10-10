<?php

namespace CitiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DepartementController extends Controller
{
    public function listeAction()
    {
        $repository = $this->getDoctrine()->getEntityManager()->getRepository("CitiesBundle:Departement");
        $departements = $repository->getAll("ASC");

        return $this->render('CitiesBundle:Departement:departements.html.twig',
            array(
                'departements' => $departements,
                'title' => "Liste des départements"
            )
        );
    }
}
