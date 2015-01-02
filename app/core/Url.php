<?php

class Url
{
    static public function getURI()
    {
        return explode('?', $_SERVER['REQUEST_URI'])[0] . '/';
    }
}