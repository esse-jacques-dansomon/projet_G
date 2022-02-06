<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\InheritanceType("JOINED")
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\DiscriminatorMap({"product" = "Product", "burger" = "Burger", "menu" = "Menu", "complement" = "Complement"})
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=DetailsOrder::class, mappedBy="product")
     */
    private $detailsOrders;

    public function __construct()
    {
        $this->detailsOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|DetailsOrder[]
     */
    public function getDetailsOrders(): Collection
    {
        return $this->detailsOrders;
    }

    public function addDetailsOrder(DetailsOrder $detailsOrder): self
    {
        if (!$this->detailsOrders->contains($detailsOrder)) {
            $this->detailsOrders[] = $detailsOrder;
            $detailsOrder->setProduct($this);
        }

        return $this;
    }

    public function removeDetailsOrder(DetailsOrder $detailsOrder): self
    {
        if ($this->detailsOrders->removeElement($detailsOrder)) {
            // set the owning side to null (unless already changed)
            if ($detailsOrder->getProduct() === $this) {
                $detailsOrder->setProduct(null);
            }
        }

        return $this;
    }
}
