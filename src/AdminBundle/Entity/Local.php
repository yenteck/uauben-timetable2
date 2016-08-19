<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;
/**
 * Local
 *
 * @ORM\Table(name="local")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\LocalRepository")
 * @GRID\Source(columns="id,nom , salles.id:count",groupBy={"id"})
 *
 */
class Local
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
     * @ORM\Column(name="nom", type="string", length=45)
     *
     */
    private $nom;


    /**
     * @ORM\OneToMany(targetEntity="Salle",mappedBy="local")
     * @GRID\Column(field="salles.code:GroupConcat",title="Salles")
     * @GRID\Column(field="salles.id:count",title="NB SALLES",filterable=false)
     */
    private $salles;
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Local
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->salles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add salle
     *
     * @param \AdminBundle\Entity\Salle $salle
     *
     * @return Local
     */
    public function addSalle(\AdminBundle\Entity\Salle $salle)
    {
        $this->salles[] = $salle;

        return $this;
    }

    /**
     * Remove salle
     *
     * @param \AdminBundle\Entity\Salle $salle
     */
    public function removeSalle(\AdminBundle\Entity\Salle $salle)
    {
        $this->salles->removeElement($salle);
    }

    /**
     * Get salles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSalles()
    {
        return $this->salles;
    }

    public function __toString() {
        return $this->nom;
    }
}
