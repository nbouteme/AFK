<?php

class MainController
{
    public function home()
    {
        if(Auth::isLoggedIn())
                  Url::redirectTo('/profile/' . $_SESSION['user']);
        View::render('home', array('name' => 'lel'));
    }

    public function fallback()
    {
        header("HTTP/1.0 404 Not Found");
    }
}
