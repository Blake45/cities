<?php
/**
 * Created by PhpStorm.
 * User: Thibaut
 * Date: 09/10/2017
 * Time: 09:19
 */

namespace CitiesBundle\Controller;

use CitiesBundle\Form\VilleRechercheType;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VilleController extends Controller
{

    public function listeAction($page, $limit, Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $villeRepo = $em->getRepository('CitiesBundle:Ville');
        $regionRepo = $em->getRepository('CitiesBundle:Region');
        $departementRepo = $em->getRepository('CitiesBundle:Departement');

        $regionSelected = $regionRepo->findOneBy(array('name'=>$request->get('region')));
        $departementSelected = $departementRepo->findOneBy(array('name'=>$request->get('departement')));
        $search = $this->getSearchCriteres($regionSelected, $departementSelected);

        $villes = $villeRepo->getVillePaginated(($page*$limit), $limit, $search);
        $pagination = $this->get('cities_pagination')->build($page, ceil($villeRepo->getCountVillePaginated()/$limit), 'cities_villes', array(), $request->query->all());

        return $this->render(
            "CitiesBundle:Ville:liste.html.twig",
            array(
                'title' => "Listes de villes",
                'villes' => $villes,
                'pagination' => $pagination->getPagination(),
                'regions' => $regionRepo->findAll(),
                'departements' => $departementRepo->findAll(),
                'regionSelected' => $regionSelected,
                'departementSelected' => $departementSelected
            )
        );
    }

    private function getSearchCriteres($regionSelected, $departementSelected)
    {
        if (!is_null($departementSelected)) {
            return array('departement' => $departementSelected);
        } elseif (!is_null($regionSelected)) {
            return array('region' => $regionSelected);
        }
        return array();
    }

    public function searchAction(Request $request)
    {

    }

    public function viewAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $villeRepo = $em->getRepository('CitiesBundle:Ville');

        try {
            $ville = $villeRepo->getBySlug($request->get('city_slug'), $request->get('departement_slug'), $request->get('region_slug'));

            return $this->render(
                "CitiesBundle:Ville:view.html.twig",
                array(
                    'ville' => $ville,
                    'title' => $ville->getName(),
                    'datafrancecall' => $ville->getSlug()."-".$ville->getMainCodePostal()
                )
            );
        } catch (\Exception $e) {
            $this->get('session')->getFlashBag()->add('error', $e->getMessage());
            var_dump($e->getMessage());die();
            //return $this->redirect($this->generateUrl('route_404'));
        }
    }
}