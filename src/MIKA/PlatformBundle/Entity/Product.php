<?php

namespace MIKA\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="MIKA\PlatformBundle\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(name="nameproduct", type="string", length=255, unique=true)
     */
    private $nameproduct;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="text")
     */
    private $designation;

    /**
     * @ORM\OneToOne(targetEntity="MIKA\PlatformBundle\Entity\Picture", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="unitprice", type="decimal", precision=10, scale=2)
     */
    private $unitprice;

    /**
     * @ORM\ManyToOne(targetEntity="MIKA\PlatformBundle\Entity\Tva")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tva;

    /**
     * @ORM\ManyToMany(targetEntity="MIKA\PlatformBundle\Entity\Category")
     */
    private $categories;

    /**
     * @var string
     *
     * @ORM\Column(name="discount", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $discount;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
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
     * Set nameproduct
     *
     * @param string $nameproduct
     *
     * @return Product
     */
    public function setNameproduct($nameproduct)
    {
        $this->nameproduct = $nameproduct;

        return $this;
    }

    /**
     * Get nameproduct
     *
     * @return string
     */
    public function getNameproduct()
    {
        return $this->nameproduct;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return Product
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    public function setPicture($picture)
    {
        $this->picture = $picture;
        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set unitprice
     *
     * @param string $unitprice
     *
     * @return Product
     */
    public function setUnitprice($unitprice)
    {
        $this->unitprice = $unitprice;

        return $this;
    }

    /**
     * Get unitprice
     *
     * @return string
     */
    public function getUnitprice()
    {
        return $this->unitprice;
    }

    /**
     * Set discount
     *
     * @param string $discount
     *
     * @return Product
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set tva
     *
     * @param \MIKA\PlatformBundle\Entity\Tva $tva
     *
     * @return Product
     */
    public function setTva(\MIKA\PlatformBundle\Entity\Tva $tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return \MIKA\PlatformBundle\Entity\Tva
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
