<?php

namespace App\Controllers;

use App\Models\ScoreboardModel;
use App\Models\UserModel;
use Core\BaseController;

class AuthController extends BaseController
{
    //Pages qui ont besoin de la méthode post
    public $post_needed = [
        "register",
        "login",
        "profile"
    ];

    /**
     * Page profile
     */
    function profile()
    {
        $username = $_SESSION["user"]["username"];
        $user_id = $_SESSION["user"]["id"];
        $usermodel = new UserModel;
        $scoremodel = new ScoreboardModel;

        $success = [];
        $errors = [];

        //get user scores
        $scores = $scoremodel->score_by_user($username);
        $rank = $scoremodel->get_rank($username);

        if (is_post_set("update")) {
            $new_name = post("updt_name");
            $new_password = post("updt_password");

            if (!empty($new_password)) {
                $usermodel->update_password($user_id, $new_password);
                $success[] = "Mot de passe mis à jou avec succès.";
            }

            if (!empty($new_name) or $new_name != $username) {
                if (is_username_allowed($new_name)) {
                    $usermodel->update_username($user_id, $new_name);
                    $success[] = "Votre nom est mis à jour, vous êtes maintenant : " . $new_name . ".";
                    $_SESSION["user"]["username"] = $new_name;
                } else {
                    $errors[] = "Votre nouveau nom contient des caractères non autorisés. Réessayez.";
                }
            }
        }

        $data = [
            'scores' => $scores,
            'rank' => $rank,
            'username' => $username
        ];

        if (!empty($success)) {
            $data["success"] = $success;
        }
        if (!empty($errors)) {
            $data["errors"] = $errors;
        }
        $this->render("auth/profile", $data);
    }

    /**
     * Page inscription, n'est pas obligatoire pour jouer
     */
    function register()
    {
        $errors = [];
        $data = [];

        $usermodel = new UserModel;
        //username must be unique
        if (isset($_POST["register"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $verify = $_POST["verify_pass"];

            if (is_username_allowed($username)) {
                if (!$usermodel->does_user_exists($username)) {
                    if ($password == $verify) {
                        $usermodel->create_user($username, $password);
                        redirect("/login");
                    } else {
                        $errors[] = "Les mots de passe ne correspondent pas. Veuillez 
                        réessayer.";
                    }
                } else {
                    $errors[] = "Ce nom, " . $username . ", est déjà pris.";
                }
            } else {
                $errors[] = "Votre nom ne doit pas contenir de caractères spéciaux. 
                (Autorisés : chiffres, lettres, tirets, espaces)";
            }
        }

        if (!empty($errors)) {
            $data["errors"] = $errors;
        }

        //must confirm password
        $this->render("auth/register", $data);
    }

    /**
     * Page connexion
     */
    function login()
    {
        $errors = [];

        $usermodel = new UserModel();

        if (isset($_POST["login"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $errors[] = $username . $password;

            //check if the user exists
            if ($usermodel->does_user_exists($username)) {
                if ($usermodel->is_password_correct($username, $password)) {
                    $user_info = $usermodel->get_user_by_username($username);
                    $_SESSION["user"] = [
                        "id" => $user_info["id"],
                        "username" => $user_info["username"],
                        "is_admin" => $user_info["is_admin"]
                    ];
                    redirect("/profile");
                } else {
                    $errors[] = "Mot de passe incorrecte.";
                }
            } else {
                $errors[] = "Vous n'êtes pas inscrit. Inscrivez-vous.";
            }
        }

        $data = [];

        if (!empty($errors)) {
            $data['errors'] = $errors;
        }

        $this->render("auth/login", $data);
    }

    /**
     * Déconnexion
     */
    function logout()
    {
        //logs out user
        logout();
        redirect("/");
    }
}
