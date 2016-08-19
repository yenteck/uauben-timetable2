<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Emploi
 *
 * @ORM\Table(name="emploi")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\EmploiRepository")
 * @GRID\Source(columns="id,titre,classe.code,expired,datemodification")
 */
class Emploi
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @GRID\Column(title="#",visible=false)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datemodification", type="datetime")
     * @GRID\Column(title="Derniere Modification",filterable=false)
     */
    private $datemodification;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebut", type="date")
     * @GRID\Column(title="Date Debut",type="date",inputType="date")
     */
    private $datedebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefin", type="date")
     * @GRID\Column(title="Date Fin",type="date",inputType="date")
     */
    private $datefin;

    /**
     * @var bool
     *
     * @ORM\Column(name="expired", type="boolean", nullable=true)
     * @GRID\Column(title="Expire ",field="expired",type="boolean",filter="select")
     */
    private $expired;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", nullable=false,length=45)
     * @GRID\Column(title="Titre")
     */
    private $titre;



    /**
     * @ORM\ManyToOne(targetEntity="Classe",inversedBy="emplois")
     * @ORM\JoinColumn(name="classe_id",referencedColumnName="id")
     * @GRID\Column(field="classe.code",title="Classe",filter="select",operators={"eq"},defaultOperator="eq")
     */
    private $classe;


    /**
     * @ORM\OneToMany(targetEntity="Cours",mappedBy="emploi")
     */
    private $cours;



    public function __construct()
    {
        $this->datemodification=new \DateTime();
        $this->expired=true;
    }

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
     * Set datemodification
     *
     * @param \DateTime $datemodification
     *
     * @return Emploi
     */
    public function setDatemodification($datemodification)
    {
        $this->datemodification = $datemodification;

        return $this;
    }

    /**
     * Get datemodification
     *
     * @return \DateTime
     */
    public function getDatemodification()
    {
        return $this->datemodification;
    }

    /**
     * Set datedebut
     *
     * @param \DateTime $datedebut
     *
     * @return Emploi
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return \DateTime
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datefin
     *
     * @param \DateTime $datefin
     *
     * @return Emploi
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * Get datefin
     *
     * @return \DateTime
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set expired
     *
     * @param boolean $expired
     *
     * @return Emploi
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }


    /**
     * Get expired
     *
     * @return bool
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Emploi
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set classe
     *
     * @param \AdminBundle\Entity\Classe $classe
     *
     * @return Emploi
     */
    public function setClasse(\AdminBundle\Entity\Classe $classe = null)
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * Get classe
     *
     * @return \AdminBundle\Entity\Classe
     */
    public function getClasse()
    {
        return $this->classe;
    }

    public function __clone() {
        $this->id = null;
    }

    /**
     * Add cour
     *
     * @param \AdminBundle\Entity\Cours $cour
     *
     * @return Emploi
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
}
