<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table(name="cours")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\CoursRepository")
 */
class Cours
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
     * @ORM\ManyToOne(targetEntity="Matiere",inversedBy="cours")
     * @ORM\JoinColumn(name="matiere_id",referencedColumnName="id")
     */
    private $matiere;


    /**
     * @ORM\ManyToOne(targetEntity="Emploi",inversedBy="cours")
     * @ORM\JoinColumn(name="emploi_id",referencedColumnName="id")
     */
    private $emploi;


    /**
     * @ORM\ManyToOne(targetEntity="Salle",inversedBy="cours")
     * @ORM\JoinColumn(name="salle_id",referencedColumnName="id")
     */
    private $salle;


    /**
     * @ORM\ManyToOne(targetEntity="Professeurs",inversedBy="cours")
     * @ORM\JoinColumn(name="professeur_id",referencedColumnName="id")
     */
    private $professeur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heuredebut", type="time")
     */
    private $heuredebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heurefin", type="time")
     */
    private $heurefin;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="jour", type="date", nullable=false)
     */
    private $jour;

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
     * Set heuredebut
     *
     * @param \DateTime $heuredebut
     *
     * @return Cours
     */
    public function setHeuredebut($heuredebut)
    {
        $this->heuredebut = $heuredebut;

        return $this;
    }

    /**
     * Get heuredebut
     *
     * @return \DateTime
     */
    public function getHeuredebut()
    {
        return $this->heuredebut;
    }

    /**
     * Set heurefin
     *
     * @param \DateTime $heurefin
     *
     * @return Cours
     */
    public function setHeurefin($heurefin)
    {
        $this->heurefin = $heurefin;

        return $this;
    }

    /**
     * Get heurefin
     *
     * @return \DateTime
     */
    public function getHeurefin()
    {
        return $this->heurefin;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Cours
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set jour
     *
     * @param \DateTime $jour
     *
     * @return Cours
     */
    public function setJour($jour)
    {
        $this->jour = $jour;

        return $this;
    }

    /**
     * Get jour
     *
     * @return \DateTime
     */
    public function getJour()
    {
        return $this->jour;
    }

    /**
     * Set matiere
     *
     * @param \AdminBundle\Entity\Matiere $matiere
     *
     * @return Cours
     */
    public function setMatiere(\AdminBundle\Entity\Matiere $matiere = null)
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return \AdminBundle\Entity\Matiere
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * Set emploi
     *
     * @param \AdminBundle\Entity\Emploi $emploi
     *
     * @return Cours
     */
    public function setEmploi(\AdminBundle\Entity\Emploi $emploi = null)
    {
        $this->emploi = $emploi;

        return $this;
    }

    /**
     * Get emploi
     *
     * @return \AdminBundle\Entity\Emploi
     */
    public function getEmploi()
    {
        return $this->emploi;
    }

    /**
     * Set salle
     *
     * @param \AdminBundle\Entity\Salle $salle
     *
     * @return Cours
     */
    public function setSalle(\AdminBundle\Entity\Salle $salle = null)
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * Get salle
     *
     * @return \AdminBundle\Entity\Salle
     */
    public function getSalle()
    {
        return $this->salle;
    }

    /**
     * Set professeur
     *
     * @param \AdminBundle\Entity\Professeurs $professeur
     *
     * @return Cours
     */
    public function setProfesseur(\AdminBundle\Entity\Professeurs $professeur = null)
    {
        $this->professeur = $professeur;

        return $this;
    }

    /**
     * Get professeur
     *
     * @return \AdminBundle\Entity\Professeurs
     */
    public function getProfesseur()
    {
        return $this->professeur;
    }
}
