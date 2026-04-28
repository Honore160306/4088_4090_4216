<?php

namespace App\Models;

use CodeIgniter\Model;

class EmojiModel extends Model
{
    protected $table = 'emojis';
    protected $primaryKey = 'id_emoji';

    protected $allowedFields = [
        'img'
    ];

    // Get all emojis
    public function getAllEmojis()
    {
        return $this->findAll();
    }

    // Get emoji by symbol
    public function getBySymbol($symbol)
    {
        return $this->where('img', $symbol)->first();
    }
}
