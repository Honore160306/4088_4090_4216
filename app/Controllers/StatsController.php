<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\StatsModel;

class StatsController extends Controller
{
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return redirect()->to('/login');
        }

        $statsModel = new StatsModel();
        $userId = session()->get('user_id');

        // Get user stats
        $userStats = $statsModel->getUserStats($userId);
        
        // Get stats summary
        $summary = $statsModel->getUserStatsSummary($userId);

        // Group stats by type for display
        $likedFoods = array_filter($userStats, function($stat) {
            return $stat['type'] === 'like';
        });

        $skippedFoods = array_filter($userStats, function($stat) {
            return $stat['type'] === 'skip';
        });

        $superLikedFoods = array_filter($userStats, function($stat) {
            return $stat['type'] === 'super';
        });

        $data = [
            'user_name' => session()->get('user_name'),
            'summary' => $summary,
            'liked_foods' => $likedFoods,
            'skipped_foods' => $skippedFoods,
            'super_liked_foods' => $superLikedFoods
        ];

        return view('stats', $data);
    }

    public function getStats()
    {
        // Check if user is logged in
        if (!session()->get('user_id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Non autorisé']);
        }

        $statsModel = new StatsModel();
        $userId = session()->get('user_id');

        $summary = $statsModel->getUserStatsSummary($userId);

        return $this->response->setJSON(['success' => true, 'stats' => $summary]);
    }
}
