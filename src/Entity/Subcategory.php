<?php

namespace App\Entity;

class Subcategory implements EntityInterface
{

    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?int $id_category = null,
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
     * @return Subcategory
     */
    public function setId(?int $id): Subcategory
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
     * @return Subcategory
     */
    public function setName(?string $name): Subcategory
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getIdCategory(): ?int
    {
        return $this->id_category;
    }

    /**
     * @param int|null $id_category
     * @return Subcategory
     */
    public function setIdCategory(?int $id_category): Subcategory
    {
        $this->id_category = $id_category;
        return $this;
    }

}