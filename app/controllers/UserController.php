<?php

class UserController
{
    // Affiche la page de login
    public function login()
    {
        if(isset($_SESSION['user']))
            Url::redirectTo('/profile/' . $_SESSION['user']);

        $data = array();
        if(isset($_SESSION['error']) && $_SESSION['error']['errored'])
        {
                $data['errored'] = $_SESSION['error']['errored'];
                $data['emessage'] = $_SESSION['emessage'];
                $_SESSION['error']['errored'] = false;
        }

        View::render('profile/login', $data);
    }

    public function register()
    {
        if(!Auth::isLoggedIn())
        {
            $data = array();
            if(isset($_SESSION['error']) && $_SESSION['error']['errored'])
            {
                $data['errored'] = $_SESSION['error']['errored'];
                $data['emessage'] = $_SESSION['emessage'];
                $_SESSION['error']['errored'] = false;
            }
            View::render('register', $data);
        }
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
        {
            $_SESSION['error']['errored'] = true;
            $_SESSION['emessage'] = 'L\'identification a échoué, vérifiez vos identifiants';

            Url::redirectTo('/login');
        }
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

        if(filter_var($data['email'], FILTER_VALIDATE_EMAIL))
        {
            $_SESSION['error']['errored'] = true;
            $_SESSION['emessage'] = 'Cet email est invalide';
        }
        else if(Users::exists($data['email']))
        {
            $_SESSION['error']['errored'] = true;
            $_SESSION['emessage'] = 'Cet email est déjà utilisée';
        }
        else if(Users::exists($data['pseudo']))
        {
            $_SESSION['error']['errored'] = true;
            $_SESSION['emessage'] = 'Cet identifiant est déjà utilisé';
        }
        else if(strlen($_POST['password']) < 6)
        {
            $_SESSION['error']['errored'] = true;
            $_SESSION['emessage'] = 'Ce mot de passe est trop court';
        }
        else if(strlen($_POST['password']) > 64)
        {
            $_SESSION['error']['errored'] = true;
            $_SESSION['emessage'] = 'Ce mot de passe est trop long';
        }
        else if(strlen($_POST['email']) > 64)
        {
            $_SESSION['error']['errored'] = true;
            $_SESSION['emessage'] = 'Cette email est trop longue';
        }
        else if(strlen($_POST['pseudo']) > 14)
        {
            $_SESSION['error']['errored'] = true;
            $_SESSION['emessage'] = 'Cet identifiant est trop long';
        }
        
        if($_SESSION['error']['errored'])
            Url::redirectTo('/register');

        Users::create($data);
        Users::sendValidation($data['email']);
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
