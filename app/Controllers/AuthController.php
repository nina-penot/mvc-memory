<?php

namespace App\Controllers;

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
        $this->render("auth/profile");
    }

    /**
     * Page inscription, n'est pas obligatoire pour jouer
     */
    function register()
    {
        //username must be unique
        //must confirm password
        $this->render("auth/register");
    }

    /**
     * Page connexion
     */
    function login()
    {
        //check if info correct
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
    }
}
