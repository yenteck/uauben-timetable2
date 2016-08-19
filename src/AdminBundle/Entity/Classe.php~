<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Classe
 *
 * @ORM\Table(name="classe")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\ClasseRepository")
 * @GRID\Source(columns="id,code , filiere.code")
 *
 */
class Classe
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
     * @ORM\ManyToOne(targetEntity="Filiere",inversedBy="classes")
     * @ORM\JoinColumn(name="filiere_id",referencedColumnName="id")
     * @GRID\Column(field="filiere.code", title="Filiere",filter="select",operators={"eq"},defaultOperator="eq")
     */
    private $filiere;


    /**
     * @ORM\OneToMany(targetEntity="Emploi",mappedBy="classe")
     */
    private $emplois;
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
     * @return Classe
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
     * Set filiere
     *
     * @param \AdminBundle\Entity\Filiere $filiere
     *
     * @return Classe
     */
    public function setFiliere(\AdminBundle\Entity\Filiere $filiere = null)
    {
        $this->filiere = $filiere;

        return $this;
    }

    /**
     * Get filiere
     *
     * @return \AdminBundle\Entity\Filiere
     */
    public function getFiliere()
    {
        return $this->filiere;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->emplois = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add emplois
     *
     * @param \AdminBundle\Entity\Emploi $emplois
     *
     * @return Classe
     */
    public function addEmplois(\AdminBundle\Entity\Emploi $emplois)
    {
        $this->emplois[] = $emplois;

        return $this;
    }

    /**
     * Remove emplois
     *
     * @param \AdminBundle\Entity\Emploi $emplois
     */
    public function removeEmplois(\AdminBundle\Entity\Emploi $emplois)
    {
        $this->emplois->removeElement($emplois);
    }

    /**
     * Get emplois
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmplois()
    {
        return $this->emplois;
    }

    public function __toString() {
        return $this->code;
    }
}
