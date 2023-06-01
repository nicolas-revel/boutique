<?php

namespace App\Model;

use App\Entity\EntityInterface;

interface ModelInterface
{
    public function findAll(): EntityInterface;

    public function find(int $id): EntityInterface;

    public function create(EntityInterface $entity): EntityInterface;

    public function update(EntityInterface $entity): EntityInterface;

    public function delete(EntityInterface $entity): EntityInterface;

    public function save(EntityInterface $entity): EntityInterface;
}