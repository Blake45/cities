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
}