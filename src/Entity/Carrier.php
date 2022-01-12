<?php

namespace App\Entity;

use App\Repository\CarrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarrierRepository::class)
 */
class Carrier
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="carrier")
     */
    private $commande;

    public function __construct()
    {
        $this->commande = new ArrayCollection();
    }


    public function __toString()
    {
        return $this->getName().'[br]'.$this->getDescription().'[br]'.number_format($this->getPrice(), 2,',',','). '€';
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     * @return Collection|Order[]
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Order $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande[] = $commande;
            $commande->setCarrier($this);
        }

        return $this;
    }

    public function removeCommande(Order $commande): self
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getCarrier() === $this) {
                $commande->setCarrier(null);
            }
        }

        return $this;
    }
}
