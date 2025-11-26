<?php

namespace App\Models;

use Core\Database;

class Scoreboard
{
    /**
     * Renvoie tout le scoreboard
     */
    public function all()
    {
        // Exécute une requête SQL directe pour récupérer toutes les cartes
        $stmt = Database::getPdo()->query(
            'SELECT * FROM scoreboard ORDER BY id ASC'
        );

        // Retourne tous les résultats sous forme de tableau associatif
        return $stmt->fetchAll();
    }
}
