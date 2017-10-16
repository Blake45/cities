<?php
/**
 * Created by PhpStorm.
 * User: Thibaut
 * Date: 13/10/2017
 * Time: 11:16
 */

namespace CitiesBundle\Services;


use Doctrine\ORM\EntityManagerInterface;

class Stats
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    private function getRepository($type)
    {
        switch ($type) {
            case 'region':
                $sEntity = "CitiesBundle:Region";
                break;
            case 'departement':
                $sEntity = "CitiesBundle:Departement";
                break;
            case 'ville':
                $sEntity = "CitiesBundle:Ville";
                break;
            default:
                throw new \Exception("Le type d'entité est inconnu ".$type.", il doit être region, departement ou ville");
                break;
        }
        return $this->em->getRepository($sEntity);
    }

    public function addStatsChomage($type, $data)
    {
        $code = $type == 'ville' ? 'codeInsee' : 'code';
        $repository = $this->getRepository($type);
        $statsRepo = $this->em->getRepository('CitiesBundle:Stats');
        $entity = $repository->findOneBy(array($code => $data['code']));

        if (!is_null($entity)) {
            $stats = $statsRepo->findOneBy(array('entityId' => $entity->getId()));
            if (is_null($stats)) {
                $stats = new \CitiesBundle\Entity\Stats();
                $stats->setType($type);
                $stats->setEntityId($entity->getId());
            }
            $stats->setTauxChomage($data['current_chomage']);
            $this->em->persist($stats);
            $this->em->flush();
        }

    }


    public function addStatsPolitique($type, $data)
    {
        $repository = $this->getRepository($type);
        $statsRepo = $this->em->getRepository('CitiesBundle:Stats');
        $entity = $repository->findOneBy(array('name' => $data['ville']));

        if (!is_null($entity)) {
            $stats = $statsRepo->findOneBy(array('entityId' => $entity->getId()));
            if (is_null($stats)) {
                $stats = new \CitiesBundle\Entity\Stats();
                $stats->setType($type);
                $stats->setEntityId($entity->getId());
            }

            $array = array(
              'code_ville' => $data['code_ville'],
              'abstention' => $data['abs_ins'],
              'le_pen' => $data['voix_ins'],
              'macron' => $data['voix_ins_2'],
              'fillon' => $data['voix_ins_3'],
              'melenchon' => $data['voix_ins_4'],
              'dupont_aignant' => $data['voix_ins_5'],
              'hamon' => $data['voix_ins_6'],
              'arthaud' => $data['voix_ins_7'],
              'poutou' => $data['voix_ins_8'],
              'cheminade' => $data['voix_ins_10'],
              'lassale' => $data['voix_ins_9'],
            );
            $stats->setArrayPolitics(json_encode($array));

            $this->em->persist($stats);
            $this->em->flush();
        }
    }

    public function addDataStatsRegion($data)
    {
        $statsRepo = $this->em->getRepository('CitiesBundle:Stats');
        $regionRepo = $this->em->getRepository('CitiesBundle:Region');

        $stats = new \CitiesBundle\Entity\Stats();

        foreach ($data as $key => $array) {
            switch ($array[0]) {
                case "Entity_Region":
                    $region = $regionRepo->findOneBy(array('code' => $array[1]));
                    $stats = $statsRepo->findOneBy(array('entityId' => $region->getId()));
                    break;
                case "Population en 2014":
                    $stats->setPopulation($array[1]);
                    break;
                case "Taux de pauvreté en 2014, en %":
                    $stats->setTauxPauvrete($array[1]);
                    break;
                case "Médiane du revenu disponible par unité de consommation en 2014, en euros";
                    $stats->setRevenuMoyen($array[1]);
                    break;
                case "Densité de la population (nombre d'habitants au km²) en 2014":
                    $stats->setDensite($array[1]);
                break;
                case "Part de l'agriculture, en %":
                    $economie['agriculture'] = $array[1];
                    break;
                case "Part de l'industrie, en %":
                    $economie['industrie'] = $array[1];
                case "Part de la construction, en %":
                    $economie['construction'] = $array[1];
                case "Part du commerce, transports et services divers, en %":
                    $economie['commerce_transports'] = $array[1];
                case "Part de l'administration publique, enseignement, santé et action sociale, en %":
                    $economie['services'] = $array[1];
                    break;
            }
        }
        $stats->setArrayEconomie(json_encode($economie));

        $this->em->persist($stats);
        $this->em->flush();
    }
}