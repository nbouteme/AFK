<?php

class View
{
    // data est un tableau associatif, la fonction extract permet d'avoir les clés du tableau accessible comme des variable, dans le code de la vue.
    static public function render($view, $data = array())
    {
        extract($data);
        ob_start();
        include 'app/views/' . $view . '.php';
        echo ob_get_clean();
    }
}
