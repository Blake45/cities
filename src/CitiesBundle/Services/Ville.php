<?php

namespace CitiesBundle\Services;


use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use CitiesBundle\Entity\Ville as ObjectVille;

class Ville
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function addVilleDataBase($data, $departement) {

        $ville = $this->em->getRepository('CitiesBundle:Ville')->findOneBy(array('name' => $data->nom, 'departement' => $departement));
        $cSlugify = new Slugify();
        if(is_null($ville)) {
            $ville = new ObjectVille();
            $ville->setName($data->nom);
            if (!is_null($data->population)) {
                $ville->setNumberPopulation($data->population);
            }
            $ville->setSlug($cSlugify->slugify($data->nom));
            if (is_array($data->codesPostaux)) {
                $ville->setCodePostaux(json_encode($data->codesPostaux));
            } else {
                $ville->setCodePostaux($data->codesPostaux);
            }
            $ville->setRegion($departement->getRegion());
            $ville->setDepartement($departement);

            $this->em->persist($ville);
            $this->em->flush();
        }
    }
}