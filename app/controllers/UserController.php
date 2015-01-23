<?php

class UserController
{
    // Affiche la page de login
    public function login()
    {
        if(isset($_SESSION['user']))
            Url::redirectTo('/profile/' . $_SESSION['user']);

        View::render('profile/login');
    }

    public function register()
    {
        if(!Auth::isLoggedIn())
            View::render('profile/register');
        else
            Url::redirectTo('/profile/' . $_SESSION['user']);
    }

    // Authentifie l'utilisateur
    public function checkLogin()
    {
        Database::connect();
        if(Auth::validate($_POST['pseudo'], $_POST['password']))
            Url::redirectTo('/');
        else
            Url::redirectTo('/login');
    }

    public function store()
    {
        $data = array();
        $data['nom']      = $_POST['nom'];
        $data['email']    = $_POST['email'];
        $data['prenom']   = $_POST['prenom'];
        $data['pseudo']   = $_POST['pseudo'];
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $data['civilite'] = $_POST['civilite'];
        Database::connect();
        Users::create($data);
        if(Auth::validate($_POST['pseudo'], $_POST['password']))
            Url::redirectTo('/profile/' . $_SESSION['user'] . '/edit');
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        Url::redirectTo('/');
    }
}
