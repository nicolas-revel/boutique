<?php

namespace App\Entity;

class Cart_Product implements EntityInterface
{
    public function __construct(
        private ?int $id = null,
        private ?int $quantity = null,
        private ?int $amount = null,
        private ?int $cart_id = null,
        private ?int $product_id = null,
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
     * @return Cart_Product
     */
    public function setId(?int $id): Cart_Product
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
     * @return Cart_Product
     */
    public function setQuantity(?int $quantity): Cart_Product
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int|null $amount
     * @return Cart_Product
     */
    public function setAmount(?int $amount): Cart_Product
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCartId(): ?int
    {
        return $this->cart_id;
    }

    /**
     * @param int|null $cart_id
     * @return Cart_Product
     */
    public function setCartId(?int $cart_id): Cart_Product
    {
        $this->cart_id = $cart_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->product_id;
    }

    /**
     * @param int|null $product_id
     * @return Cart_Product
     */
    public function setProductId(?int $product_id): Cart_Product
    {
        $this->product_id = $product_id;
        return $this;
    }

}