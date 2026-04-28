<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id_category';

    protected $allowedFields = [
        'name'
    ];

    // Get all categories
    public function getAllCategories()
    {
        return $this->findAll();
    }

    // Get category by name
    public function getByName($name)
    {
        return $this->where('name', $name)->first();
    }
}
