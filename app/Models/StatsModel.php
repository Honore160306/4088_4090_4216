<?php

namespace App\Models;

use CodeIgniter\Model;

class StatsModel extends Model
{
    protected $table = 'stats';
    protected $primaryKey = 'id_stat';

    protected $allowedFields = [
        'id_user',
        'id_food',
        'type'
    ];

    // Add or update a stat
    public function addOrUpdateStat($userId, $foodId, $type)
    {
        // Check if stat already exists
        $existing = $this->where('id_user', $userId)
                        ->where('id_food', $foodId)
                        ->first();

        if ($existing) {
            // Update existing stat
            return $this->update($existing['id_stat'], ['type' => $type]);
        } else {
            // Insert new stat
            return $this->insert([
                'id_user' => $userId,
                'id_food' => $foodId,
                'type' => $type
            ]);
        }
    }

    // Get user stats
    public function getUserStats($userId)
    {
        return $this->select('stats.*, foods.name as food_name, foods.img as food_image, categories.name as category_name')
                    ->join('foods', 'foods.id_food = stats.id_food')
                    ->join('categories', 'categories.id_category = foods.id_category')
                    ->where('stats.id_user', $userId)
                    ->findAll();
    }

    // Get user stats summary
    public function getUserStatsSummary($userId)
    {
        $likes = $this->where('id_user', $userId)->where('type', 'like')->countAllResults();
        $skips = $this->where('id_user', $userId)->where('type', 'skip')->countAllResults();
        $supers = $this->where('id_user', $userId)->where('type', 'super')->countAllResults();
        
        return [
            'likes' => $likes,
            'skips' => $skips,
            'supers' => $supers,
            'total' => $likes + $skips + $supers
        ];
    }

    // Check if user has interacted with food
    public function hasUserInteractedWithFood($userId, $foodId)
    {
        return $this->where('id_user', $userId)
                    ->where('id_food', $foodId)
                    ->first() !== null;
    }
}
