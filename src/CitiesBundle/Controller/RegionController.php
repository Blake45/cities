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
        $repository = $this->getDoctrine()->getEntityManager()->getRepository("CitiesBundle:Region");
        $statsRepository = $this->getDoctrine()->getEntityManager()->getRepository("CitiesBundle:Stats");
        $region_slug = $request->get('region_slug');

        $region = $repository->findOneBy(array("slug" => $region_slug));
        $stats = $statsRepository->findOneBy(array('entityId' => $region->getId()));
        $zone = array('name' => $this->encode($region->getName()));


        return $this->render('CitiesBundle:Region:view.html.twig',
            array(
                'region' => $region,
                'title' => "Page sur la région ".$region->getName(),
                'stats' => $stats,
                'API_KEY' => $this->get('cities.ville')->getGmapsAPI_KEY(),
                'zone' => $zone
            )
        );
    }

    private function encode($str)
    {
        $unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
        return strtr( $str, $unwanted_array );
    }
}
