<?php
/**
 * Created by PhpStorm.
 * User: Thibaut
 * Date: 04/10/2017
 * Time: 16:09
 */

namespace CitiesBundle\Services;

use CitiesBundle\Entity\Departement as ObjetDepartement;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;

class Departement
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function addDepartementDataBase($data) {

        $region = $this->em->getRepository('CitiesBundle:Region')->findOneBy(array('code' => $data->codeRegion));
        $departement = $this->em->getRepository('CitiesBundle:Departement')->findOneBy(array('code' => $data->code));
        if (!is_null($region) && is_null($departement)) {
            $departement = new ObjetDepartement();
            $departement->setName($data->nom);
            $departement->setCode($data->code);
            $departement->setRegion($region);

            $this->em->persist($departement);
            $this->em->flush();
        }
    }


    public function buildSlugsDepartements()
    {
        $departements = $this->em->getRepository('CitiesBundle:Departement')->findAll();
        $cSlug = new Slugify();
        foreach($departements as $departement) {
            $slug = $cSlug->slugify($departement->getName());
            $departement->setSlug($slug);
            $this->em->persist($departement);
        }
        $this->em->flush();
    }
}