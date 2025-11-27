<?php

namespace App\Models;

use Core\Database;

class UserModel
{
    /**
     * Enregistre un utilisateur dans la base de données
     */
    function create_user($username, $password)
    {
        $stmt = Database::getPdo()->prepare(
            'INSERT INTO user (username, password)
            VALUES (?, ?)'
        );

        $stmt->execute([$username, $password]);
    }

    /**
     * Vérifie si un utilisateur existe déjà
     */
    function does_user_exists($username)
    {
        $stmt = Database::getPdo()->prepare(
            'SELECT user.username FROM user WHERE user.username = ?'
        );

        $stmt->execute([$username]);

        $user = $stmt->fetch();

        if (empty($user)) {
            return false;
        } else {
            return true;
        }
    }
}
