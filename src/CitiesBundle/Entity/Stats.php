<?php

namespace CitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stats
 *
 * @ORM\Table(name="stats")
 * @ORM\Entity(repositoryClass="CitiesBundle\Repository\StatsRepository")
 */
class Stats
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="taux_chomage", type="float", nullable=true)
     */
    private $tauxChomage;

    /**
     * @var
     *
     * @ORM\Column(name="politique", type="string", length=2000, nullable=true)
     */
    private $arrayPolitics;


    /**
     * @var
     * @ORM\Column(name="population", type="integer", nullable=true)
     */
    private $population;

    /**
     * @var
     * @ORM\Column(name="taux_pauvrete", type="float", nullable=true)
     */
    private $tauxPauvrete;

    /**
     * @var
     * @ORM\Column(name="revenu_moyen", type="float", nullable=true)
     */
    private $revenuMoyen;

    /**
     * @var
     * @ORM\Column(name="densite", type="float", nullable=true)
     */
    private $densite;

    /**
     * @var
     * @ORM\Column(name="economie", type="string", length=2000, nullable=true)
     */
    private $arrayEconomie;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="entity_id", type="integer", unique=true)
     */
    private $entityId;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tauxChomage
     *
     * @param float $tauxChomage
     *
     * @return Stats
     */
    public function setTauxChomage($tauxChomage)
    {
        $this->tauxChomage = $tauxChomage;

        return $this;
    }

    /**
     * Get tauxChomage
     *
     * @return float
     */
    public function getTauxChomage()
    {
        return $this->tauxChomage;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Stats
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set entityId
     *
     * @param integer $entityId
     *
     * @return Stats
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get entityId
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Set arrayPolitics
     *
     * @param string $arrayPolitics
     *
     * @return Stats
     */
    public function setArrayPolitics($arrayPolitics)
    {
        $this->arrayPolitics = $arrayPolitics;

        return $this;
    }

    /**
     * Get arrayPolitics
     *
     * @return string
     */
    public function getArrayPolitics()
    {
        return json_decode($this->arrayPolitics);
    }

    /**
     * Set population
     *
     * @param integer $population
     *
     * @return Stats
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return integer
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * Set tauxPauvrete
     *
     * @param float $tauxPauvrete
     *
     * @return Stats
     */
    public function setTauxPauvrete($tauxPauvrete)
    {
        $this->tauxPauvrete = $tauxPauvrete;

        return $this;
    }

    /**
     * Get tauxPauvrete
     *
     * @return float
     */
    public function getTauxPauvrete()
    {
        return $this->tauxPauvrete;
    }

    /**
     * Set revenuMoyen
     *
     * @param float $revenuMoyen
     *
     * @return Stats
     */
    public function setRevenuMoyen($revenuMoyen)
    {
        $this->revenuMoyen = $revenuMoyen;

        return $this;
    }

    /**
     * Get revenuMoyen
     *
     * @return float
     */
    public function getRevenuMoyen()
    {
        return $this->revenuMoyen;
    }

    /**
     * Set densite
     *
     * @param float $densite
     *
     * @return Stats
     */
    public function setDensite($densite)
    {
        $this->densite = $densite;

        return $this;
    }

    /**
     * Get densite
     *
     * @return float
     */
    public function getDensite()
    {
        return $this->densite;
    }

    /**
     * Set arrayEconomie
     *
     * @param string $arrayEconomie
     *
     * @return Stats
     */
    public function setArrayEconomie($arrayEconomie)
    {
        $this->arrayEconomie = $arrayEconomie;

        return $this;
    }

    /**
     * Get arrayEconomie
     *
     * @return string
     */
    public function getArrayEconomie()
    {
        return $this->arrayEconomie;
    }
}
