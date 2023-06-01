<?php

namespace App\Entity;

class Right implements EntityInterface
{

    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
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
     * @return Right
     */
    public function setId(?int $id): Right
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
     * @return Right
     */
    public function setName(?string $name): Right
    {
        $this->name = $name;
        return $this;
    }
    
}