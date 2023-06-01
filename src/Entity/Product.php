<?php

namespace App\Entity;

class Product implements EntityInterface
{

    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?string $description = null,
        private ?int $price = null,
        private ?string $image = null,
        private ?\DateTime $created_at = null,
        private ?\DateTime $updated_at = null,
        private ?int $idCategory = null,
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
     * @return Product
     */
    public function setId(?int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Product
     */
    public function setName(?string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Product
     */
    public function setDescription(?string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param int|null $price
     * @return Product
     */
    public function setPrice(?int $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return Product
     */
    public function setImage(?string $image): Product
    {
        $this->image = $image;
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
     * @return Product
     */
    public function setCreatedAt(?\DateTime $created_at): Product
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
     * @return Product
     */
    public function setUpdatedAt(?\DateTime $updated_at): Product
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIdCategory(): ?int
    {
        return $this->idCategory;
    }

    /**
     * @param int|null $idCategory
     * @return Product
     */
    public function setIdCategory(?int $idCategory): Product
    {
        $this->idCategory = $idCategory;
        return $this;
    }

}