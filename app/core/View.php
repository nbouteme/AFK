<?php

class View
{
	static private $template;

    // data est un tableau associatif, la fonction extract permet d'avoir les clés du tableau accessible comme des variable, dans le code de la vue.
    static public function render($view, $data = array())
    {
        extract($data);
        ob_start();
        include 'app/views/' . $view . '.php';
		$content = ob_get_clean();

		if (!empty(self::$template))
		{
            self::$template = str_replace('@Content@', $content, self::$template);
            echo self::$template;
        }
		else
            echo $content;
    }

	// permet de mettre en cache le template
	static public function addTemplate($templateName, array $data = array())
    {
        extract($data);
        ob_start();
            include 'app/views/' . $templateName . '.php';
        self::$template = ob_get_clean();
    }
}
