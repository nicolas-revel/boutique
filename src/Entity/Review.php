<?php

namespace App\Entity;

class Review implements EntityInterface
{

    public function __construct(
        private ?int $id = null,
        private ?int $rating = null,
        private ?string $comment = null,
        private ?\DateTime $created_at = null,
        private ?int $product_id = null,
        private ?int $user_id = null,
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
     * @return Review
     */
    public function setId(?int $id): Review
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * @param int|null $rating
     * @return Review
     */
    public function setRating(?int $rating): Review
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string|null $comment
     * @return Review
     */
    public function setComment(?string $comment): Review
    {
        $this->comment = $comment;
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
     * @return Review
     */
    public function setCreatedAt(?\DateTime $created_at): Review
    {
        $this->created_at = $created_at;
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
     * @return Review
     */
    public function setProductId(?int $product_id): Review
    {
        $this->product_id = $product_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int|null $user_id
     * @return Review
     */
    public function setUserId(?int $user_id): Review
    {
        $this->user_id = $user_id;
        return $this;
    }
    
}