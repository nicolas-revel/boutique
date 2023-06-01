<?php

namespace App\Entity;

class Cart implements EntityInterface
{

    public function __construct(
        private ?int $id = null,
        private ?\DateTime $created_at = null,
        private ?\DateTime $updated_at = null,
        private ?int $id_user = null,
        private ?int $id_product = null
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
     * @return Cart
     */
    public function setId(?int $id): Cart
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime|null $created_at
     * @return Cart
     */
    public function setCreatedAt(?\DateTime $created_at): Cart
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTime|null $updated_at
     * @return Cart
     */
    public function setUpdatedAt(?\DateTime $updated_at): Cart
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    /**
     * @param int|null $id_user
     * @return Cart
     */
    public function setIdUser(?int $id_user): Cart
    {
        $this->id_user = $id_user;
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
     * @return Cart
     */
    public function setIdProduct(?int $id_product): Cart
    {
        $this->id_product = $id_product;
        return $this;
    }

}