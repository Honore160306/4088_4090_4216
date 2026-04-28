<?php

namespace App\Models;

use CodeIgniter\Model;

class RegisterModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $allowedFields = [
        'name',
        'email',
        'pwd'
    ];

    // Hash password before inserting
    public function createUser($data)
    {
        $data['pwd'] = password_hash($data['pwd'], PASSWORD_DEFAULT);
        return $this->insert($data);
    }

    // Verify user login
    public function verifyUser($email, $password)
    {
        $user = $this->where('email', $email)->first();
        
        if ($user && password_verify($password, $user['pwd'])) {
            return $user;
        }
        
        return false;
    }
}