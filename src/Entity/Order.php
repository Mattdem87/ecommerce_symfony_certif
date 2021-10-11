<?php

namespace App\Entity;
use App\Repository\OrderRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $carriereName;

    /**
     * @ORM\Column(type="float")
     */
    private $carrierePrice;

    /**
     * @ORM\Column(type="text")
     */
    private $delivery;

    /**
     * @ORM\OneToMany(targetEntity=Orderdetails::class, mappedBy="myOrder")
     */
    private $orderdetails;

    /**
     * @ORM\Column(type="boolean")
     */
    private $IsPaid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stripeSessionId;


    public function __construct()
    {
        $this->orderdetails = new ArrayCollection();
    }

    public function getTotal()
    {
        $total = null;

        foreach ($this->getOrderdetails()->getValues() as $product) {
            $total = $total + ($product->getPrice() * $product->getQuantity());
        }
        return $total;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCarriereName(): ?string
    {
        return $this->carriereName;
    }

    public function setCarriereName(string $carriereName): self
    {
        $this->carriereName = $carriereName;

        return $this;
    }

    public function getCarrierePrice(): ?float
    {
        return $this->carrierePrice;
    }

    public function setCarrierePrice(float $carrierePrice): self
    {
        $this->carrierePrice = $carrierePrice;

        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(string $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * @return Collection|Orderdetails[]
     */
    public function getOrderdetails(): Collection
    {
        return $this->orderdetails;
    }

    public function addOrderdetail(Orderdetails $orderdetails): self
    {
        if (!$this->orderdetails->contains($orderdetails)) {
            $this->orderdetails[] = $orderdetails;
            $orderdetails->setMyOrder($this);
        }

        return $this;
    }

    public function removeOrderdetail(Orderdetails $orderdetails): self
    {
        if ($this->orderdetails->removeElement($orderdetails)) {
            // set the owning side to null (unless already changed)
            if ($orderdetails->getMyOrder() === $this) {
                $orderdetails->setMyOrder(null);
            }
        }

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->IsPaid;
    }

    public function setIsPaid(bool $IsPaid): self
    {
        $this->IsPaid = $IsPaid;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getStripeSessionId(): ?string
    {
        return $this->stripeSessionId;
    }

    public function setStripeSessionId(?string $stripeSessionId): self
    {
        $this->stripeSessionId = $stripeSessionId;

        return $this;
    }
}
