<?php

namespace CitiesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegionController extends Controller
{
    public function listeAction()
    {
        $repository = $this->getDoctrine()->getEntityManager()->getRepository("CitiesBundle:Region");
        $regions = $repository->getAll("ASC");

        return $this->render('CitiesBundle:Region:regions.html.twig',
            array(
                'regions' => $regions,
                'title' => "Liste des regions"
            )
        );
    }

    public function viewAction(Request $request)
    {
        //todo
    }
}
