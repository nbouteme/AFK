<?php

class App
{
    static function run()
    {
        session_start();
        require_once 'app/core/Request.php';
        require_once 'app/core/Url.php';
        require_once 'app/core/Router.php';
        require_once 'app/core/View.php';
        require_once 'app/core/Config.php';

        spl_autoload_register(
            function($class)
            {
                require 'app/models/' . $class . 'Model.php';
            });
        Config::load();
        Router::load();
        Router::dispatch();
    }
}
?>
