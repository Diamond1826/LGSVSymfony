<?php

namespace DHLGSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tenant
 *
 * @ORM\Table(name="tenants")
 * @ORM\Entity(repositoryClass="DHLGSVBundle\Repository\TenantRepository")
 */
class Tenant
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
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Der Vorname muss mind. {{ limit }} Zeichen lang sein",
     *      maxMessage = "Der Vorname darf nicht länger als {{ limit }} Zeichen lang sein"
     * )
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     * @Assert\NotBlank(message = "Dieses Feld sollte nicht leer sein")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Der Nachname muss mind. {{ limit }} Zeichen lang sein",
     *      maxMessage = "Der Nachname darf nicht länger als {{ limit }} Zeichen lang sein"
     * )
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

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

    /**
     * @var string
     * @Assert\NotBlank(message = "Dieses Feld sollte nicht leer sein")
     * @Assert\Email(
     *     message = "Die E-Mail Adresse '{{ value }}' ist nicht gültig.",
     *     checkMX = true)
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * @Assert\NotBlank(message = "Dieses Feld sollte nicht leer sein")
     * @Assert\Regex(
     *     pattern="/^(\+41|0041|0){1}(\(0\))?[0-9]{9}$/",
     *     match=true,
     *     message="Diese Nummer ist ungültig, Beispiel: 0041795557788 oder +41795557788"
     * )
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    // ...
    /**
     * @Assert\NotBlank(message = "Dieses Feld sollte nicht leer sein")
     * @OneToMany(targetEntity="Allocation", mappedBy="tenant")
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Tenant
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Tenant
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get lastname fistname
     *
     * @return string 
     */
    public function getIdLastnameFirstname()
    {
        return "ID:".$this->id."  ".$this->lastname.", ".$this->firstname;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Tenant
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
     * @return Tenant
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
     * @return Tenant
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

    /**
     * Set email
     *
     * @param string $email
     * @return Tenant
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Tenant
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }
}
