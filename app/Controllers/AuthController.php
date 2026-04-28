<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RegisterModel;

class AuthController extends Controller
{
    public function login()
    {
        // If user is already logged in, redirect to home
        if (session()->get('user_id')) {
            return redirect()->to('/home');
        }
        
        return view('login');
    }

    public function doLogin()
    {
        $model = new RegisterModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('pwd');

        $user = $model->verifyUser($email, $password);

        if ($user) {
            // Set session
            session()->set([
                'user_id' => $user['id_user'],
                'user_name' => $user['name'],
                'user_email' => $user['email'],
                'logged_in' => true
            ]);
            
            return $this->response->setJSON(['success' => true, 'message' => 'Connexion réussie']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
        }
    }

    public function register()
    {
        // If user is already logged in, redirect to home
        if (session()->get('user_id')) {
            return redirect()->to('/home');
        }
        
        return view('register');
    }

    public function doRegister()
    {
        $model = new RegisterModel();
        
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'pwd' => $this->request->getPost('pwd')
        ];

        // Validate input
        if (empty($data['name']) || empty($data['email']) || empty($data['pwd'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Veuillez remplir tous les champs']);
        }

        // Check if email already exists
        if ($model->where('email', $data['email'])->first()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Cet email est déjà utilisé']);
        }

        try {
            $userId = $model->createUser($data);
            
            if ($userId) {
                return $this->response->setJSON(['success' => true, 'message' => 'Inscription réussie']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de l\'inscription']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
