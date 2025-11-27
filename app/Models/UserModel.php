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
            $user = all_uppercase($user["username"]);
            if (all_uppercase($username) == $user) {
                return true;
            } else {
                return false;
            }
        }
    }

    function is_password_correct($username, $password)
    {
        $stmt = Database::getPdo()->prepare(
            'SELECT user.username, user.password FROM user WHERE user.username = ?'
        );

        $stmt->execute([$username]);

        $userinfo = $stmt->fetch();

        if ($userinfo["password"] == $password) {
            return true;
        } else {
            return false;
        }
    }

    function get_user_by_id($id)
    {
        $stmt = Database::getPdo()->prepare(
            'SELECT * FROM user WHERE user.id = ?'
        );

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    function get_user_by_username($username)
    {
        $stmt = Database::getPdo()->prepare(
            'SELECT * FROM user WHERE user.username = ?'
        );

        $stmt->execute([$username]);

        return $stmt->fetch();
    }
}
