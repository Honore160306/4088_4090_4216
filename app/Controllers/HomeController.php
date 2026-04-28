<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\FoodModel;
use App\Models\StatsModel;

class HomeController extends Controller
{
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $foodModel = new FoodModel();
        $statsModel = new StatsModel();
        $userId = session()->get('user_id');

        // Get foods not yet interacted with by user
        $foods = $foodModel->getFoodsForUser($userId);

        // Get user stats summary
        $stats = $statsModel->getUserStatsSummary($userId);

        $data = [
            'foods' => $foods,
            'stats' => $stats,
            'user_name' => session()->get('user_name')
        ];

        return view('home', $data);
    }

    public function swipe()
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non autorisé']);
        }

        $statsModel = new StatsModel();
        $foodModel = new FoodModel();
        $userId = session()->get('user_id');
        $foodId = $this->request->getPost('food_id');
        $type = $this->request->getPost('type'); // 'like', 'skip', 'super'

        // Validate type
        if (!in_array($type, ['like', 'skip', 'super'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Type invalide']);
        }

        // Add or update stat
        $result = $statsModel->addOrUpdateStat($userId, $foodId, $type);

        if ($result) {
            // Get next food
            $nextFood = $foodModel->getFoodsForUser($userId);
            
            // Get updated stats
            $stats = $statsModel->getUserStatsSummary($userId);

            return $this->response->setJSON([
                'success' => true,
                'next_foods' => $nextFood,
                'stats' => $stats
            ]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Erreur lors de l\'enregistrement']);
        }
    }

    public function getFoods()
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non autorisé']);
        }

        $foodModel = new FoodModel();
        $userId = session()->get('user_id');

        $foods = $foodModel->getFoodsForUser($userId);

        return $this->response->setJSON(['success' => true, 'foods' => $foods]);
    }
}
