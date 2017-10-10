<?php

namespace CitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ville
 *
 * @ORM\Table(name="ville")
 * @ORM\Entity(repositoryClass="CitiesBundle\Repository\VilleRepository")
 */
class Ville
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=true)
     */
    private $longitude;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=true)
     */
    private $latitude;

    /**
     * @var int
     *
     * @ORM\Column(name="number_population", type="bigint", nullable=true)
     */
    private $numberPopulation;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;


    /**
     * @var array
     *
     * @ORM\Column(name="codePostaux", type="string", length=1000, nullable=false)
     */
    private $codePostaux;


    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="villes", fetch="EAGER")
     * @ORM\JoinColumn(name="region_id", referencedColumnName="id")
     */
    private $region;


    /**
     * @var Departement
     *
     * @ORM\ManyToOne(targetEntity="Departement", fetch="EAGER")
     * @ORM\JoinColumn(name="departement_id", referencedColumnName="id")
     */
    private $departement;


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
     * Set name
     *
     * @param string $name
     *
     * @return Ville
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Ville
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Ville
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set numberPopulation
     *
     * @param integer $numberPopulation
     *
     * @return Ville
     */
    public function setNumberPopulation($numberPopulation)
    {
        $this->numberPopulation = $numberPopulation;

        return $this;
    }

    /**
     * Get numberPopulation
     *
     * @return int
     */
    public function getNumberPopulation()
    {
        return $this->numberPopulation;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Ville
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set codePostaux
     *
     * @param array $codePostaux
     *
     * @return Ville
     */
    public function setCodePostaux($codePostaux)
    {
        $this->codePostaux = $codePostaux;

        return $this;
    }

    /**
     * Get codePostaux
     *
     * @return array
     */
    public function getCodePostaux()
    {
        return $this->codePostaux;
    }

    /**
     * Set region
     *
     * @param \CitiesBundle\Entity\Region $region
     *
     * @return Ville
     */
    public function setRegion(\CitiesBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \CitiesBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set departement
     *
     * @param \CitiesBundle\Entity\Departement $departement
     *
     * @return Ville
     */
    public function setDepartement(\CitiesBundle\Entity\Departement $departement = null)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return \CitiesBundle\Entity\Departement
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Retourne le premier codePostal d'une ville
     * @return mixed
     */
    public function getMainCodePostal()
    {
        $codePostaux = json_decode($this->getCodePostaux());
        return array_shift($codePostaux);
    }
}
