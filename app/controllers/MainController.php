<?php

class MainController
{
    public function home()
    {
        View::render('base');
    }

    public function fallback()
    {
        header("HTTP/1.0 404 Not Found");
    }
}
