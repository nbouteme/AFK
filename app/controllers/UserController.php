<?php

class UserController
{
    // Affiche la page de login
    public function login()
    {
        View::addTemplate('base');
        View::render('profile/login');
    }

    public function register()
    {
        View::addTemplate('base');
        if(!Auth::isLoggedIn())
            View::render('profile/register');
        else
            Url::redirectTo('/');
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
        Database::disconnect();
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        Url::redirectTo('/');
    }
}
