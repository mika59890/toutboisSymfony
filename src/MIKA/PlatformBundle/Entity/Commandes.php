<?php

namespace MIKA\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Commandes
 *
 * @ORM\Table(name="commandes")
 * @ORM\Entity(repositoryClass="MIKA\PlatformBundle\Repository\CommandesRepository")
 */
class Commandes
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
     * @ORM\ManyToOne(targetEntity="MIKA\UserBundle\Entity\User",inversedBy="commandes")
     * @Assert\Valid()
     */
    private $user;

    /**
     * @var bool
     *
     * @ORM\Column(name="validate", type="boolean")
     */
    private $validate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

    /**
     * @var array
     *
     * @ORM\Column(name="products", type="array")
     */
    private $products;

    /**
     * @var array
     *
     * @ORM\Column(name="commande", type="array")
     */
    private $commande;


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
     * Set validate
     *
     * @param boolean $validate
     *
     * @return Commandes
     */
    public function setValidate($validate)
    {
        $this->validate = $validate;

        return $this;
    }

    /**
     * Get validate
     *
     * @return bool
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commandes
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set products
     *
     * @param array $products
     *
     * @return Commandes
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set commande
     *
     * @param array $products
     *
     * @return Commandes
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get products
     *
     * @return array
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * Set user
     *
     * @param \MIKA\UserBundle\Entity\User $user
     *
     * @return Commandes
     */
    public function setUser(\MIKA\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MIKA\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
