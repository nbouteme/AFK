<?php
Router::register('GET', ['url'        => '/'              ,
                         'controller' => 'MainController' ,
                         'action'     => 'home']);
Router::register('POST', ['url'       => '/register'      ,
                         'controller' => 'UserController' ,
                         'action'     => 'store']);
Router::register('GET', ['url'        => '/register'      ,
                         'controller' => 'UserController' ,
                         'action'     => 'register']);
Router::register('GET', ['url'        => '/login'         ,
                         'controller' => 'UserController' ,
                         'action'     => 'login']);
Router::register('POST', ['url'       => '/login'         ,
                         'controller' => 'UserController' ,
                         'action'     => 'checkLogin']);
Router::register('GET', ['url'        => '/logout'        ,
                         'controller' => 'UserController' ,
                         'action'     => 'logout']);
?>
