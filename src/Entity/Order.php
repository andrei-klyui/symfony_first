<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $total;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shipping_total;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $create_time;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $timezone;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(?string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getShippingTotal(): ?string
    {
        return $this->shipping_total;
    }

    public function setShippingTotal(?string $shipping_total): self
    {
        $this->shipping_total = $shipping_total;

        return $this;
    }

    public function getCreateTime(): ?string
    {
        return $this->create_time;
    }

    public function setCreateTime(?string $create_time): self
    {
        $this->create_time = $create_time;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }
}
