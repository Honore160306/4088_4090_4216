<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LivreModel;
use App\Models\RegisterModel;

class AcceuilController extends Controller
{
    public function liste_livres()
    {
        $livreModel = new LivreModel();

        $data['livres'] = $livreModel->findAll();

        return view('login', $data);
    }

        public function register()
    {
        return view('register');
    }

            public function createUser()
    {
        $model = new RegisterModel();
        $data = $this->request->getPost();

        if (!$model->insert($data)) {
        return view('form', [
        'validation' => $model->errors()
        ]); 
}
        $model->save($data);

        return view('login');
    }

public function fiche_livre($id)
{
    $livreModel = new LivreModel();

    $data['livre'] = $livreModel->find($id);

    return view('fiche_livre', $data);
}
}