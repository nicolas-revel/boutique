<?php

namespace App\Entity;

class Status implements EntityInterface
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
     * @return Status
     */
    public function setId(?int $id): Status
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
     * @return Status
     */
    public function setName(?string $name): Status
    {
        $this->name = $name;
        return $this;
    }

}