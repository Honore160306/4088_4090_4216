<?php

namespace App\Models;

use CodeIgniter\Model;

class FoodModel extends Model
{
    protected $table = 'foods';
    protected $primaryKey = 'id_food';

    protected $allowedFields = [
        'id_user',
        'name',
        'id_emoji',
        'img',
        'id_category',
        'time',
        'cal',
        'rating',
        'description'
    ];

    // Get foods with joins to categories and emojis
    public function getFoodsWithDetails()
    {
        return $this->select('foods.*, categories.name as category_name, emojis.img as emoji')
                    ->join('categories', 'categories.id_category = foods.id_category')
                    ->join('emojis', 'emojis.id_emoji = foods.id_emoji')
                    ->findAll();
    }

    // Get food with details by ID
    public function getFoodWithDetails($id)
    {
        return $this->select('foods.*, categories.name as category_name, emojis.img as emoji')
                    ->join('categories', 'categories.id_category = foods.id_category')
                    ->join('emojis', 'emojis.id_emoji = foods.id_emoji')
                    ->where('foods.id_food', $id)
                    ->first();
    }

    // Get foods not yet interacted with by user
    public function getFoodsForUser($userId)
    {
        return $this->select('foods.*, categories.name as category_name, emojis.img as emoji')
                    ->join('categories', 'categories.id_category = foods.id_category')
                    ->join('emojis', 'emojis.id_emoji = foods.id_emoji')
                    ->where("foods.id_food NOT IN (SELECT id_food FROM stats WHERE id_user = {$userId})")
                    ->findAll();
    }
}
