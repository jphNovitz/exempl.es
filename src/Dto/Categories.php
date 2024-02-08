<?php

namespace App\Dto;


use App\Entity\Category;
use App\Repository\CategoryRepository;

class Categories
{
    public $categories;

    public function __construct(private CategoryRepository $repository)
    {
        if (!empty($all = $this->repository->findAllWithSites())) $this->categories = $all;
        else $this->categories = [];
    }

    public function getAll(){
        return $this->categories;
    }
//    public function getSites(){
//        if(!empty($this->categories)){
//            return $this->
//        }
//    }



}