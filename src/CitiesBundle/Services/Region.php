<?php


namespace CitiesBundle\Services;

use CitiesBundle\Entity\Region as ObjetRegion;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;

class Region
{

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function addRegionDataBase($data) {

        $region = $this->em->getRepository('CitiesBundle:Region')->findOneBy(array('code' => $data->code));
        if(is_null($region)) {
            $region = new ObjetRegion();
            $region->setName($data->nom);
            $region->setCode($data->code);

            $this->em->persist($region);
            $this->em->flush();
        }
    }

    public function buildSlugsRegions()
    {
        $regions = $this->em->getRepository('CitiesBundle:Region')->findAll();
        $cSlug = new Slugify();
        foreach($regions as $region) {
            $slug = $cSlug->slugify($region->getName());
            $region->setSlug($slug);
            $this->em->persist($region);
        }
        $this->em->flush();
    }

}