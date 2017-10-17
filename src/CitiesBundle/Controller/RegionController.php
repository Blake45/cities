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
        $jsencodeService = $this->get('cities.general.jsencode');
        $repository = $this->getDoctrine()->getEntityManager()->getRepository("CitiesBundle:Region");
        $statsRepository = $this->getDoctrine()->getEntityManager()->getRepository("CitiesBundle:Stats");
        $region_slug = $request->get('region_slug');

        $region = $repository->findOneBy(array("slug" => $region_slug));
        $stats = $statsRepository->findOneBy(array('entityId' => $region->getId()));

        $zone = array(
            'name' => $jsencodeService->encode($region->getName()),
            'coordinates' => $jsencodeService->buildZoneCoordinates($region)
        );


        return $this->render('CitiesBundle:Region:view.html.twig',
            array(
                'region' => $region,
                'title' => "Page sur la région ".$region->getName(),
                'stats' => $stats,
                'API_KEY' => $this->get('cities.ville')->getGmapsAPI_KEY(),
                'zone' => $zone,
                'dataSet' => $jsencodeService->buildDataSetForGraphZone($stats)
            )
        );
    }
}
