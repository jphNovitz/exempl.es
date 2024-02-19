<?php

namespace App\Dto;

use App\Repository\CategoryRepository;

class Categories
{
    public array $categories;

    public function __construct(private readonly CategoryRepository $repository)
    {
        if (!empty($all = $this->repository->findAllWithSites())) $this->categories = $all;
        else $this->categories = [];
    }

    public function getAll(): array
    {
        return $this->categories;
    }
}