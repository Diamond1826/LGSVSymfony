<?php

namespace DHLGSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message = "Dieses Feld sollte nicht leer sein")
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank(message = "Dieses Feld sollte nicht leer sein")
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Die Strasse muss mind. {{ limit }} Zeichen lang sein",
     *      maxMessage = "Die Strasse darf nicht länger als {{ limit }} Zeichen lang sein"
     * )
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var int
     * @Assert\NotBlank(message = "Dieses Feld sollte nicht leer sein")
     * @Assert\Range(
     *      min = 1000,
     *      max = 9999,
     *      invalidMessage = "Das Feld darf nur Zahlen beinhalten",
     *      minMessage = "Die PLZ muss min. {{ limit }} betragen",
     *      maxMessage = "Die PLZ darf max. {{ limit }} betragen")
     * @ORM\Column(name="zipcode", type="integer")
     */
    private $zipcode;

    /**
     * @var string
     * @Assert\NotBlank(message = "Dieses Feld sollte nicht leer sein")
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Der Ort muss mind. {{ limit }} Zeichen lang sein",
     *      maxMessage = "Der Ort darf nicht länger als {{ limit }} Zeichen lang sein"
     * )
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

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
    * Get apartments
    * @return arrayCollection
    */
    public function getApartments()
    {
        return $this->apartments;
    }

    /**
    * Set apartments
    * @param apartment
    * @return House
    */
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
     * @return string name 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return House
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set zipcode
     *
     * @param integer $zipcode
     * @return House
     */
    public function setZipCode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return integer 
     */
    public function getZipCode()
    {
        return $this->zipcode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return House
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }
}
