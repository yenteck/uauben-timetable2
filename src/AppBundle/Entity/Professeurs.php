<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;


/**
 * Professeurs
 *
 * @ORM\Table(name="p_todelete")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfesseursRepository")
 * @GRID\Source(columns="id, nom,prenom,phone,dateenreg")
 */
class Professeurs
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
     *@GRID\Column(operators={"eq","like"},defaultOperator="like")
     * @ORM\Column(name="nom", type="string", length=45)
     */
    private $nom;

    /**
     * @var string
     *@GRID\Column(operators={"eq","like"},defaultOperator="like")
     * @ORM\Column(name="prenom", type="string", length=45)
     */
    private $prenom;

    /**
     * @var string
     *@GRID\Column(operators={"eq"},defaultOperator="eq")
     * @ORM\Column(name="phone", type="string", length=45)
     */
    private $phone;

    /**
     * @var string
     * @GRID\Column(operators={"eq","btw"},defaultOperator="eq")
     * @ORM\Column(name="email", type="string", length=45)
     */
    private $email;

    /**
     * @var \DateTime
     *@GRID\Column(format="d/m/Y" ,filterable=true,type="datetime",inputType="date",operators={"eq","btw"},defaultOperator="eq")
     * @ORM\Column(name="dateenreg", type="datetime")
     */
    private $dateenreg;


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
     * @return Professeurs
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Professeurs
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Professeurs
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

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Professeurs
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
     * Set dateenreg
     *
     * @param \DateTime $dateenreg
     *
     * @return Professeurs
     */
    public function setDateenreg($dateenreg)
    {
        $this->dateenreg = $dateenreg;

        return $this;
    }

    /**
     * Get dateenreg
     *
     * @return \DateTime
     */
    public function getDateenreg()
    {
        return $this->dateenreg;
    }
}

