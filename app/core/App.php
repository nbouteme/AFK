<?php

class App
{
    static function run()
    {
        session_start();
	// charger les classes avec require once

        spl_autoload_register(function($class)
			      {
				  require 'app/models/' . $classModel . 'Model.php';
			      });
        Config::load();
    }

}
