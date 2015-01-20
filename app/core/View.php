<?php

class View
{
    static private $twig;
    static private $loader;
    static public function render($view, $data = array())
    {
        echo self::$twig->render($view . '.twig.html', $data);
    }

    static public function load()
    {
        self::$loader = new Twig_Loader_Filesystem('/www/app/views');
        self::$twig = new Twig_Environment(self::$loader);
        $functions = array();

        $functions[] = new Twig_SimpleFunction('url', function($rel)
        {
            return Url::to($rel);
        });

        $functions[] = new Twig_SimpleFunction('loggedIn', function()
        {
            return Auth::isLoggedIn();
        });

        $functions[] = new Twig_SimpleFunction('loggedUser', function()
        {
            return $_SESSION['user'];
        });

        foreach($functions as $f)
        self::$twig->addFunction($f);
    }
}
View::load();
