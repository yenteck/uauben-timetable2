<?php

namespace AdminBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\OneToMany(targetEntity="Filiere",mappedBy="user")
     */
    private $filieres;

    /**
     * @ORM\OneToMany(targetEntity="Article",mappedBy="user")
     */
    private $articles;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add filiere
     *
     * @param \AdminBundle\Entity\Filiere $filiere
     *
     * @return User
     */
    public function addFiliere(\AdminBundle\Entity\Filiere $filiere)
    {
        $this->filieres[] = $filiere;

        return $this;
    }

    /**
     * Remove filiere
     *
     * @param \AdminBundle\Entity\Filiere $filiere
     */
    public function removeFiliere(\AdminBundle\Entity\Filiere $filiere)
    {
        $this->filieres->removeElement($filiere);
    }

    /**
     * Get filieres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFilieres()
    {
        return $this->filieres;
    }

    /**
     * Add article
     *
     * @param \AdminBundle\Entity\Article $article
     *
     * @return User
     */
    public function addArticle(\AdminBundle\Entity\Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \AdminBundle\Entity\Article $article
     */
    public function removeArticle(\AdminBundle\Entity\Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
