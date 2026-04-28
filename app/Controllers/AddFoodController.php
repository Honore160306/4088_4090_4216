<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\FoodModel;
use App\Models\CategoryModel;
use App\Models\EmojiModel;

class AddFoodController extends Controller
{
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $categoryModel = new CategoryModel();
        $emojiModel = new EmojiModel();

        $data = [
            'categories' => $categoryModel->getAllCategories(),
            'emojis' => $emojiModel->getAllEmojis(),
            'user_name' => session()->get('user_name')
        ];

        return view('add-food', $data);
    }

    public function add()
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non autorisé']);
        }

        $foodModel = new FoodModel();
        $userId = session()->get('user_id');

        // Handle file upload
        $imageFile = $this->request->getFile('food_image');
        $imageName = '';

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Generate unique name
            $imageName = $imageFile->getRandomName();
            
            // Move to uploads directory
            $imageFile->move(WRITEPATH . 'uploads', $imageName);
            
            // Store relative path for database
            $imageName = 'uploads/' . $imageName;
        }

        $data = [
            'id_user' => $userId,
            'name' => $this->request->getPost('name'),
            'id_emoji' => $this->request->getPost('emoji'),
            'img' => $imageName ?: 'images/default-food.jpg',
            'id_category' => $this->request->getPost('category'),
            'time' => $this->request->getPost('time'),
            'cal' => $this->request->getPost('calories'),
            'rating' => $this->request->getPost('rating'),
            'description' => $this->request->getPost('description')
        ];

        // Validate required fields
        if (empty($data['name']) || empty($data['id_emoji']) || empty($data['id_category']) || 
            empty($data['time']) || empty($data['cal']) || empty($data['rating']) || empty($data['description'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Veuillez remplir tous les champs obligatoires']);
        }

        try {
            $foodId = $foodModel->insert($data);
            
            if ($foodId) {
                return $this->response->setJSON(['success' => true, 'message' => 'Plat ajouté avec succès']);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de l\'ajout du plat']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
        }
    }
}
