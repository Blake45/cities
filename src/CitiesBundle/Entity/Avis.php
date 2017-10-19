<?php

namespace CitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avis
 *
 * @ORM\Table(name="avis")
 * @ORM\Entity(repositoryClass="CitiesBundle\Repository\AvisRepository")
 */
class Avis
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
     * @ORM\Column(name="securite", type="float", nullable=true)
     */
    private $securite;

    /**
     * @var float
     *
     * @ORM\Column(name="loisir", type="float", nullable=true)
     */
    private $loisir;

    /**
     * @var float
     *
     * @ORM\Column(name="culture", type="float", nullable=true)
     */
    private $culture;

    /**
     * @var float
     *
     * @ORM\Column(name="emploi", type="float", nullable=true)
     */
    private $emploi;

    /**
     * @var float
     *
     * @ORM\Column(name="environnement", type="float", nullable=true)
     */
    private $environnement;

    /**
     * @var float
     *
     * @ORM\Column(name="sante", type="float", nullable=true)
     */
    private $sante;

    /**
     * @var
     *
     * @ORM\Column(name="commerce", type="float", nullable=true)
     */
    private $commerce;

    /**
     * @var
     *
     * @ORM\Column(name="enseignement", type="float", nullable=true)
     */
    private $enseignement;

    /**
     * @var
     *
     * @ORM\Column(name="transport", type="float", nullable=true)
     */
    private $transport;

    /**
     * @var string
     *
     * @ORM\Column(name="comment_positif", type="text", nullable=true)
     */
    private $commentPositif;

    /**
     * @var string
     *
     * @ORM\Column(name="comment_negatif", type="text", nullable=true)
     */
    private $commentNegatif;


    /**
     * @var string
     *
     * @ORM\Column(name="comment_general", type="text", nullable=true)
     */
    private $commentGeneral;

    /**
     * @var float
     * Note général , elle est calculé aprés poste de l'avis et sa validation
     * @ORM\Column(name="qualite_vie", type="float", nullable=true)
     */
    private $qualiteVie;


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
     * Set securite
     *
     * @param float $securite
     *
     * @return Avis
     */
    public function setSecurite($securite)
    {
        $this->securite = $securite;

        return $this;
    }

    /**
     * Get securite
     *
     * @return float
     */
    public function getSecurite()
    {
        return $this->securite;
    }

    /**
     * Set loisir
     *
     * @param float $loisir
     *
     * @return Avis
     */
    public function setLoisir($loisir)
    {
        $this->loisir = $loisir;

        return $this;
    }

    /**
     * Get loisir
     *
     * @return float
     */
    public function getLoisir()
    {
        return $this->loisir;
    }

    /**
     * Set culture
     *
     * @param float $culture
     *
     * @return Avis
     */
    public function setCulture($culture)
    {
        $this->culture = $culture;

        return $this;
    }

    /**
     * Get culture
     *
     * @return float
     */
    public function getCulture()
    {
        return $this->culture;
    }

    /**
     * Set emploi
     *
     * @param float $emploi
     *
     * @return Avis
     */
    public function setEmploi($emploi)
    {
        $this->emploi = $emploi;

        return $this;
    }

    /**
     * Get emploi
     *
     * @return float
     */
    public function getEmploi()
    {
        return $this->emploi;
    }

    /**
     * Set environnement
     *
     * @param float $environnement
     *
     * @return Avis
     */
    public function setEnvironnement($environnement)
    {
        $this->environnement = $environnement;

        return $this;
    }

    /**
     * Get environnement
     *
     * @return float
     */
    public function getEnvironnement()
    {
        return $this->environnement;
    }

    /**
     * Set commentPositif
     *
     * @param string $commentPositif
     *
     * @return Avis
     */
    public function setCommentPositif($commentPositif)
    {
        $this->commentPositif = $commentPositif;

        return $this;
    }

    /**
     * Get commentPositif
     *
     * @return string
     */
    public function getCommentPositif()
    {
        return $this->commentPositif;
    }

    /**
     * Set commentNegatif
     *
     * @param string $commentNegatif
     *
     * @return Avis
     */
    public function setCommentNegatif($commentNegatif)
    {
        $this->commentNegatif = $commentNegatif;

        return $this;
    }

    /**
     * Get commentNegatif
     *
     * @return string
     */
    public function getCommentNegatif()
    {
        return $this->commentNegatif;
    }

    /**
     * Set sante
     *
     * @param float $sante
     *
     * @return Avis
     */
    public function setSante($sante)
    {
        $this->sante = $sante;

        return $this;
    }

    /**
     * Get sante
     *
     * @return float
     */
    public function getSante()
    {
        return $this->sante;
    }

    /**
     * Set commerce
     *
     * @param float $commerce
     *
     * @return Avis
     */
    public function setCommerce($commerce)
    {
        $this->commerce = $commerce;

        return $this;
    }

    /**
     * Get commerce
     *
     * @return float
     */
    public function getCommerce()
    {
        return $this->commerce;
    }

    /**
     * Set enseignement
     *
     * @param float $enseignement
     *
     * @return Avis
     */
    public function setEnseignement($enseignement)
    {
        $this->enseignement = $enseignement;

        return $this;
    }

    /**
     * Get enseignement
     *
     * @return float
     */
    public function getEnseignement()
    {
        return $this->enseignement;
    }

    /**
     * Set transport
     *
     * @param float $transport
     *
     * @return Avis
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * Get transport
     *
     * @return float
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * Set commentGeneral
     *
     * @param string $commentGeneral
     *
     * @return Avis
     */
    public function setCommentGeneral($commentGeneral)
    {
        $this->commentGeneral = $commentGeneral;

        return $this;
    }

    /**
     * Get commentGeneral
     *
     * @return string
     */
    public function getCommentGeneral()
    {
        return $this->commentGeneral;
    }

    /**
     * Set qualiteVie
     *
     * @param float $qualiteVie
     *
     * @return Avis
     */
    public function setQualiteVie($qualiteVie)
    {
        $this->qualiteVie = $qualiteVie;

        return $this;
    }

    /**
     * Get qualiteVie
     *
     * @return float
     */
    public function getQualiteVie()
    {
        return $this->qualiteVie;
    }

    /**
     * Generique function
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }
}
