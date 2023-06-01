<?php

namespace App\Entity;

class Adress implements EntityInterface
{
    public function __construct(
        private ?string $id = null,
        private ?string $title = null,
        private ?string $country = null,
        private ?string $town = null,
        private ?string $zip_code = null,
        private ?string $street = null,
        private ?string $infos = null,
        private ?int $number = null,
        private ?int $id_user = null,
    ) {
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return Adress
     */
    public function setId(?string $id): Adress
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     * @return Adress
     */
    public function setTitle(?string $title): Adress
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     * @return Adress
     */
    public function setCountry(?string $country): Adress
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTown(): ?string
    {
        return $this->town;
    }

    /**
     * @param string|null $town
     * @return Adress
     */
    public function setTown(?string $town): Adress
    {
        $this->town = $town;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getZipCode(): ?string
    {
        return $this->zip_code;
    }

    /**
     * @param string|null $zip_code
     * @return Adress
     */
    public function setZipCode(?string $zip_code): Adress
    {
        $this->zip_code = $zip_code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     * @return Adress
     */
    public function setStreet(?string $street): Adress
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInfos(): ?string
    {
        return $this->infos;
    }

    /**
     * @param string|null $infos
     * @return Adress
     */
    public function setInfos(?string $infos): Adress
    {
        $this->infos = $infos;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @param int|null $number
     * @return Adress
     */
    public function setNumber(?int $number): Adress
    {
        $this->number = $number;
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
     * @return Adress
     */
    public function setIdUser(?int $id_user): Adress
    {
        $this->id_user = $id_user;
        return $this;
    }
}
