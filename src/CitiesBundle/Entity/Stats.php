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
     * @ORM\Column(name="politique", type="string", length=2000, nullable=false)
     */
    private $arrayPolitics;

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
}
