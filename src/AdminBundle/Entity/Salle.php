<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Salle
 *
 * @ORM\Table(name="salle")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\SalleRepository")
 * @GRID\Source(columns="id,code,libelle,local.nom")
 */
class Salle
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
     * @ORM\Column(name="code", type="string", length=10)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=45, nullable=true)
     */
    private $libelle;


    /**
     * @ORM\ManyToOne(targetEntity="Local",inversedBy="salles")
     * @ORM\JoinColumn(name="local_id",referencedColumnName="id")
     * @GRID\Column(field="local.nom",filter="select",operators={"eq"},defaultOperator="eq",title="Local")
     */

    private $local;


    /**
     * @ORM\OneToMany(targetEntity="Cours",mappedBy="salle")
     */
    private $cours;

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
     * Set code
     *
     * @param string $code
     *
     * @return Salle
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Salle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set local
     *
     * @param \AdminBundle\Entity\Local $local
     *
     * @return Salle
     */
    public function setLocal(\AdminBundle\Entity\Local $local = null)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get local
     *
     * @return \AdminBundle\Entity\Local
     */
    public function getLocal()
    {
        return $this->local;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cours = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cour
     *
     * @param \AdminBundle\Entity\Cours $cour
     *
     * @return Salle
     */
    public function addCour(\AdminBundle\Entity\Cours $cour)
    {
        $this->cours[] = $cour;

        return $this;
    }

    /**
     * Remove cour
     *
     * @param \AdminBundle\Entity\Cours $cour
     */
    public function removeCour(\AdminBundle\Entity\Cours $cour)
    {
        $this->cours->removeElement($cour);
    }

    /**
     * Get cours
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCours()
    {
        return $this->cours;
    }
    function __toString()
    {
        return $this->code;
    }
}
