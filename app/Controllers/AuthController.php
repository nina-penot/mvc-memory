<?php

namespace App\Controllers;

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
        //get user info
        //get user scores
        $data = [];
        $this->render("auth/profile", $data);
    }

    /**
     * Page inscription, n'est pas obligatoire pour jouer
     */
    function register()
    {
        $errors = [];

        $usermodel = new UserModel;
        //username must be unique
        if (isset($_POST["register"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $verify = $_POST["verify_pass"];

            if (is_username_allowed($username)) {
                if ($usermodel->does_user_exists($username)) {
                    if ($password == $verify) {
                        $usermodel->create_user($username, $password);
                        redirect("/auth/login");
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

        $data = [];

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
        //check if info/pass correct
        //redirect to profile
        $this->render("auth/login");
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
