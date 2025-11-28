<?php

namespace App\Models;

use Core\Database;

class ScoreboardModel
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

    /**
     * Donne tous les scores d'un utilisateur
     */
    function score_by_user($username)
    {
        $stmt = Database::getPdo()->prepare(
            'SELECT *, DATE_FORMAT(date, "%d/%m/%Y") as "cleandate" FROM scoreboard WHERE scoreboard.username = ?  ORDER BY score DESC'
        );

        $stmt->execute([$username]);

        $score = $stmt->fetchAll();

        return $score;
    }

    /**
     * Donne le top 10 du scoreboard
     */
    function top_ten()
    {
        $stmt = Database::getPdo()->query(
            'SELECT *, DATE_FORMAT(date, "%d/%m/%Y") as "cleandate" FROM scoreboard ORDER BY score DESC LIMIT 10'
        );

        return $stmt->fetchAll();
    }

    function save_score($username, $strikes, $pairs, $time, $score)
    {
        $stmt = Database::getPdo()->prepare(
            'INSERT INTO scoreboard (username, strikes, pairs, time, score, date)
            VALUES (?, ?, ?, ?, ?, NOW())'
        );

        $stmt->execute([$username, $strikes, $pairs, $time, $score]);
    }

    /**
     * Donne le rang général dans le scoreboard d'un utilisateur
     */
    function get_rank($username)
    {
        //example:
        //WITH BigRanks AS 
        //( SELECT *, ROW_NUMBER() OVER( ORDER BY cards.type_id DESC) AS Ranks FROM cards ) 
        //SELECT name , type_id, Ranks FROM BigRanks WHERE name = 'PIKACHU' ORDER BY Ranks; 
        //--->or SELECT MAX(type_id) as bestrank, name
        $stmt = Database::getPdo()->prepare(
            'WITH BigRanks AS 
            ( SELECT *, ROW_NUMBER() OVER( ORDER BY scoreboard.score DESC) 
            AS Ranks FROM scoreboard ) 
            SELECT Ranks FROM BigRanks 
            WHERE username = ? 
            ORDER BY Ranks;'
        );

        $stmt->execute([$username]);

        $rank = $stmt->fetch();

        $rank = $rank["Ranks"];

        return $rank;
    }
}
