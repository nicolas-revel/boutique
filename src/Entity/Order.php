<?php

namespace App\Entity;

class Order implements EntityInterface
{

    public function __construct(
        private ?int $id = null,
        private ?int $totalAmount = null,
        private ?\DateTime $createdAt = null,
        private ?int $idStatus = null,
        private ?int $idCart = null,
        private ?int $idAdress = null,
    ) {
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Order
     */
    public function setId(?int $id): Order
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTotalAmount(): ?int
    {
        return $this->totalAmount;
    }

    /**
     * @param int|null $totalAmount
     * @return Order
     */
    public function setTotalAmount(?int $totalAmount): Order
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     * @return Order
     */
    public function setCreatedAt(?\DateTime $createdAt): Order
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIdStatus(): ?int
    {
        return $this->idStatus;
    }

    /**
     * @param int|null $idStatus
     * @return Order
     */
    public function setIdStatus(?int $idStatus): Order
    {
        $this->idStatus = $idStatus;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIdCart(): ?int
    {
        return $this->idCart;
    }

    /**
     * @param int|null $idCart
     * @return Order
     */
    public function setIdCart(?int $idCart): Order
    {
        $this->idCart = $idCart;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIdAdress(): ?int
    {
        return $this->idAdress;
    }

    /**
     * @param int|null $idAdress
     * @return Order
     */
    public function setIdAdress(?int $idAdress): Order
    {
        $this->idAdress = $idAdress;
        return $this;
    }

}