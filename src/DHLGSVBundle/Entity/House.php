<?php

namespace DHLGSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * House
 *
 * @ORM\Table(name="house")
 * @ORM\Entity(repositoryClass="DHLGSVBundle\Repository\HouseRepository")
 */
class House
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
     * @var string
     *
     * @ORM\Column(name="strasse", type="string", length=255)
     */
    private $strasse;

    /**
     * @var int
     *
     * @ORM\Column(name="plz", type="integer")
     */
    private $plz;

    /**
     * @var string
     *
     * @ORM\Column(name="ort", type="string", length=255)
     */
    private $ort;

    // ...
    /**
     * One Product has Many Features.
     * @OneToMany(targetEntity="Apartment", mappedBy="house")
     */
    private $apartments;
    // ...

    public function __construct() {
        $this->apartments = new ArrayCollection();
    }

    /**
    * Get wohnungen
    * @return arrayCollection
    */
    public function getApartments()
    {
        return $this->apartments;
    }

     public function setApartments($apartment)
    {
        $this->apartments = $apartment;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return House
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
     * Set strasse
     *
     * @param string $strasse
     * @return House
     */
    public function setStrasse($strasse)
    {
        $this->strasse = $strasse;

        return $this;
    }

    /**
     * Get strasse
     *
     * @return string 
     */
    public function getStrasse()
    {
        return $this->strasse;
    }

    /**
     * Set plz
     *
     * @param integer $plz
     * @return House
     */
    public function setPlz($plz)
    {
        $this->plz = $plz;

        return $this;
    }

    /**
     * Get plz
     *
     * @return integer 
     */
    public function getPlz()
    {
        return $this->plz;
    }

    /**
     * Set ort
     *
     * @param string $ort
     * @return House
     */
    public function setOrt($ort)
    {
        $this->ort = $ort;

        return $this;
    }

    /**
     * Get ort
     *
     * @return string 
     */
    public function getOrt()
    {
        return $this->ort;
    }
}
