<?php

namespace DHLGSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * MieterToWohnung
 *
 * @ORM\Table(name="mieter_to_wohnung")
 * @ORM\Entity(repositoryClass="DHLGSVBundle\Repository\MieterToWohnungRepository")
 */
class MieterToWohnung
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
     * @ORM\ManyToOne(targetEntity="Mieter", inversedBy="wohnungen")
     * @ORM\JoinColumn(name="mieter_id", referencedColumnName="id")
     */
    private $mieter;

    /**
     * @ORM\ManyToOne(targetEntity="Wohnung", inversedBy="mieters")
     * @ORM\JoinColumn(name="wohnung_id", referencedColumnName="id")
     */
    private $wohnung;

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
    public function getMieter()
    {
        return $this->mieter;
    }

    /**
     * Set mieter
     *
     * @param mieterId
     * @return mieter
     */
    public function setMieter($mieterId)
    {
        $this->mieter = $mieter;

        return $this;
    }

    /**
     * Get wohnung id
     *
     * @return integer 
     */
    public function getWohnung()
    {
        return $this->wohnung;
    }

    /**
     * Set mieter
     *
     * @param wohnungId
     * @return wohnung
     */
    public function setWohnung($wohnungId)
    {
        $this->wohnung = $wohnung;

        return $this;
    }
}
