<?php

namespace App\Models;

use CodeIgniter\Model;

class LivreModel extends Model
{
    protected $table = 'livres';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'titre',
        'auteur',
        'ISBN',
        'annee_publication',
        'categorie',
        'resume',
        'nom_fichier_couverture',
        'statut',
        'date_creation',
        'date_modification'
    ];
}