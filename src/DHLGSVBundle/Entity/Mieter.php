<?php

namespace DHLGSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * Mieter
 *
 * @ORM\Table(name="mieter")
 * @ORM\Entity(repositoryClass="DHLGSVBundle\Repository\MieterRepository")
 */
class Mieter
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
     * @ORM\Column(name="vorname", type="string", length=255)
     */
    private $vorname;

    /**
     * @var string
     *
     * @ORM\Column(name="nachname", type="string", length=255)
     */
    private $nachname;

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

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telefon", type="string", length=255)
     */
    private $telefon;

    // ...
    /**
     * One Product has Many Features.
     * @OneToMany(targetEntity="MieterToWohnung", mappedBy="mieter")
     */
    private $wohnungen;
    // ...

    public function __construct() {
        $this->wohnungen = new ArrayCollection();
    }

    /**
    * Get wohnungen
    * @return arrayCollection
    */
    public function getWohnungen()
    {
        return $this->wohnungen;
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
     * Set vorname
     *
     * @param string $vorname
     * @return Mieter
     */
    public function setVorname($vorname)
    {
        $this->vorname = $vorname;

        return $this;
    }

    /**
     * Get vorname
     *
     * @return string 
     */
    public function getVorname()
    {
        return $this->vorname;
    }

    /**
     * Set nachname
     *
     * @param string $nachname
     * @return Mieter
     */
    public function setNachname($nachname)
    {
        $this->nachname = $nachname;

        return $this;
    }

    /**
     * Get nachname
     *
     * @return string 
     */
    public function getNachname()
    {
        return $this->nachname;
    }

    /**
     * Get nachname vorname
     *
     * @return string 
     */
    public function getIdNachnameVorname()
    {
        return "ID:".$this->id."  ".$this->nachname.", ".$this->vorname;
    }

    /**
     * Set strasse
     *
     * @param string $strasse
     * @return Mieter
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
     * @return Mieter
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
     * @return Mieter
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

    /**
     * Set email
     *
     * @param string $email
     * @return Mieter
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
     * Set telefon
     *
     * @param string $telefon
     * @return Mieter
     */
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;

        return $this;
    }

    /**
     * Get telefon
     *
     * @return string 
     */
    public function getTelefon()
    {
        return $this->telefon;
    }
}
