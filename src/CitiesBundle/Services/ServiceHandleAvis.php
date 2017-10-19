<?php

namespace CitiesBundle\Services;


use CitiesBundle\Entity\Avis;
use CitiesBundle\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ServiceHandleAvis
{

    private $em;
    private $container;
    private $fields;

    public function __construct(EntityManagerInterface $em, ContainerInterface $container) {
        $this->em = $em;
        $this->container = $container;
        $this->fields = array(
            "securite",
            "loisir",
            "culture",
            "emploi",
            "environnement",
            "sante",
            "commerce",
            "enseignement",
            "transport"
        );
    }

    /**
     * @param Avis $avis
     * @param null $minValue
     * @param null $maxValue
     * @return array
     */
    public function checkNotes(Avis $avis, $minValue=null, $maxValue=null)
    {
        $errors = array();

        foreach ($this->fields as $field) {
            $note = $avis->__get($field);
            if (!is_null($note) && !is_null($minValue) && !is_null($maxValue)) {
                if ($note < $minValue) {
                    $errors [] = "La valeur minimale d'une note est de ".$minValue;
                }
                if ($note > $maxValue) {
                    $errors [] = "La valeur maximale d'une note est de ".$maxValue;
                }
                if (!is_numeric($note)) {
                    $errors [] = "La note doit être de type numerique";
                }
                if (!is_numeric($minValue) || !is_numeric($maxValue)) {
                    $errors [] = "Soyez un peu logique, la valeur minimale et maximale d'une note sont forcément numérique, c'est quoi votre problème sérieux";
                }
            }
        }

        return $errors;
    }

    /**
     * Update et save d'un avis
     * @param Avis $avis
     * @param Ville $ville
     * @throws \Exception
     */
    public function saveAvis(Avis $avis, Ville $ville)
    {
        $errors = $this->checkNotes($avis);
        if ($errors) {
            $errors = implode("</br>", $errors);
            throw new \Exception($errors);
        } else {
            $qualite_vie = 0.0;
            foreach($this->fields as $field) {
                $note = $avis->__get($field);
                $qualite_vie += $note;
            }
            $qualite_vie = $qualite_vie / count($this->fields);
            $avis->setQualiteVie($qualite_vie);
            $this->em->persist($avis);
            $this->em->flush();
            $this->container->get('session')->getFlashBag()->add('success', "Avis sur la ville ".$ville->getName()." a été déposé");
        }
    }

    /**
     * Efface les avis
     * @param $ids
     * @param bool|false $all
     */
    public function deleteAvis($ids, $all = false)
    {
        $avisRepo = $this->em->getRepository("CitiesBundle:Avis");
        $avis = $avisRepo->findById($ids);

        if ($all) {
            $avisRepo->deleteAllAvis();
        } else {
            foreach ($avis as $element) {
                $this->em->remove($element);
            }
            $this->em->flush();
        }
    }

}