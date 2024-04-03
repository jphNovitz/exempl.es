<?php

namespace App\Dto;

use App\Repository\CategoryRepository;

class Categories
{
    public array $categories;

    public function __construct(private readonly CategoryRepository $repository)
    {
    }

    public function getAll(): ?array
    {
        return $this->repository->findAllWithSites();
    }

    public function all(): ?array
    {
        return $this->getAll();
    }

}