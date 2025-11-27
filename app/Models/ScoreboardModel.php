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

    function score_by_user($username)
    {
        $stmt = Database::getPdo()->prepare(
            'SELECT * FROM scoreboard WHERE scoreboard.username = ?'
        );

        $stmt->execute([$username]);

        $score = $stmt->fetchAll();

        return $score;
    }

    function top_ten()
    {
        $stmt = Database::getPdo()->query(
            'SELECT * FROM scoreboard ORDER BY score ASC LIMIT 10'
        );
    }

    function save_score($username, $strikes, $pairs, $time, $score) {}
}
