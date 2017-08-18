<?php

namespace DHLGSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Allocation
 *
 * @ORM\Table(name="allocations")
 * @ORM\Entity(repositoryClass="DHLGSVBundle\Repository\AllocationRepository")
 */
class Allocation
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
     * @ORM\ManyToOne(targetEntity="Tenant", inversedBy="apartments")
     * @ORM\JoinColumn(name="mieter_id", referencedColumnName="id")
     */
    private $tenant;

    /**
     * @ORM\ManyToOne(targetEntity="Apartment", inversedBy="tenants")
     * @ORM\JoinColumn(name="tenant_id", referencedColumnName="id")
     */
    private $apartment;

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
     * Get mieter id
     *
     * @return integer 
     */
    public function getTenant()
    {
        return $this->tenant;
    }

    /**
     * Set mieter
     *
     * @param mieterId
     * @return mieter
     */
    public function setTenant($tenant)
    {
        $this->tenant = $tenant;

        return $this;
    }

    /**
     * Get wohnung id
     *
     * @return integer 
     */
    public function getApartment()
    {
        return $this->apartment;
    }

    /**
     * Set mieter
     *
     * @param wohnungId
     * @return wohnung
     */
    public function setApartment($apartment)
    {
        $this->apartment = $apartment;

        return $this;
    }
}
