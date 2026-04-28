<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LivreModel;

class AcceuilController extends Controller
{
    public function liste_livres()
    {
        $livreModel = new LivreModel();

        $data['livres'] = $livreModel->findAll();

        return view('login', $data);
    }

public function fiche_livre($id)
{
    $livreModel = new LivreModel();

    $data['livre'] = $livreModel->find($id);

    return view('fiche_livre', $data);
}
}