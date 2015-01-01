<?php

class MainController
{
    public function home()
    {
	// Appel a la vue qui affiche la page d'acceuil
    }

    public function fallback()
    {
        header("HTTP/1.0 404 Not Found");
	// Appel a la vue qui affiche une erreur 404
    }
}
