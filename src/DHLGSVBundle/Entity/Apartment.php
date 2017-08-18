<?php

namespace DHLGSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Apartment
 *
 * @ORM\Table(name="apartments")
 * @ORM\Entity(repositoryClass="DHLGSVBundle\Repository\ApartmentRepository")
 */
class Apartment
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
     * @ORM\ManyToOne(targetEntity="House", inversedBy="wohnungen")
     * @ORM\JoinColumn(name="house_id", referencedColumnName="id")
     */
    private $house;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="rent", type="string", length=255)
     */
    private $rent;

    /**
     * One Product has Many Features.
     * @OneToMany(targetEntity="Allocation", mappedBy="apartment")
     */
    private $tenants;
    // ...

    public function __construct() {
        $this->tenants = new ArrayCollection();
    }

    /**
    * Get Apartments
    * @return arrayCollection
    */
    public function getTenants()
    {
        return $this->tenants;
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
     * Set houseId
     *
     * @param integer $houseId
     * @return Apartment
     */
    public function setHouse($house)
    {
        $this->house = $house;

        return $this;
    }

    /**
     * Get houseId
     *
     * @return integer 
     */
    public function getHouse()
    {
        return $this->house;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Apartment
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
     * Set rent
     *
     * @param string $rent
     * @return Apartment
     */
    public function setRent($rent)
    {
        $this->rent = $rent;

        return $this;
    }

    /**
     * Get rent
     *
     * @return string 
     */
    public function getRent()
    {
        return $this->rent;
    }
}
