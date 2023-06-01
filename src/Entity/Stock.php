<?php

namespace App\Entity;

class Stock implements EntityInterface
{
    public function __construct(
        private ?int $id = null,
        private ?int $quantity = null,
        private ?int $id_product = null,
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
     * @return Stock
     */
    public function setId(?int $id): Stock
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     * @return Stock
     */
    public function setQuantity(?int $quantity): Stock
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIdProduct(): ?int
    {
        return $this->id_product;
    }

    /**
     * @param int|null $id_product
     * @return Stock
     */
    public function setIdProduct(?int $id_product): Stock
    {
        $this->id_product = $id_product;
        return $this;
    }

}