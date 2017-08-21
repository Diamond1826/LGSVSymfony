<?php

namespace DHLGSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message = "Bitte Mieter auswählen")
     * @ORM\ManyToOne(targetEntity="Tenant", inversedBy="apartments")
     * @ORM\JoinColumn(name="tenant_id", referencedColumnName="id")
     */
    private $tenant;

    /**
     * @Assert\NotBlank(message = "Bitte Wohnung auswählen")
     * @ORM\ManyToOne(targetEntity="Apartment", inversedBy="tenants")
     * @ORM\JoinColumn(name="apartment_id", referencedColumnName="id")
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
     * Get tenant
     *
     * @return integer 
     */
    public function getTenant()
    {
        return $this->tenant;
    }

    /**
     * Set tenant
     *
     * @param tenant
     * @return tenant
     */
    public function setTenant($tenant)
    {
        $this->tenant = $tenant;

        return $this;
    }

    /**
     * Get apartment id
     *
     * @return integer 
     */
    public function getApartment()
    {
        return $this->apartment;
    }

    /**
     * Set apartment
     *
     * @param apartment
     * @return apartment
     */
    public function setApartment($apartment)
    {
        $this->apartment = $apartment;

        return $this;
    }
}
