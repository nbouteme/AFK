<?php
Router::register('GET', ['url'        => '/'              ,
                         'controller' => 'MainController' ,
                         'action'     => 'home']);

////////////////////////////////////////////////////
//        _   _ _ _           _                   //
//  _   _| |_(_) (_)___  __ _| |_ ___ _   _ _ __  //
// | | | | __| | | / __|/ _` | __/ _ \ | | | '__| //
// | |_| | |_| | | \__ \ (_| | ||  __/ |_| | |    //
//  \__,_|\__|_|_|_|___/\__,_|\__\___|\__,_|_|    //
////////////////////////////////////////////////////

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

///////////////////////////////////
//                   __ _ _      //
//  _ __  _ __ ___  / _(_) |___  //
// | '_ \| '__/ _ \| |_| | / __| //
// | |_) | | | (_) |  _| | \__ \ //
// | .__/|_|  \___/|_| |_|_|___/ //
// |_|                           //
///////////////////////////////////

Router::register('GET', ['url'        => '/profile/{user}'      ,
                         'controller' => 'ProfileController'    ,
                         'action'     => 'profile']);
Router::register('GET', ['url'        => '/profile/{user}/edit' ,
                         'controller' => 'ProfileController'    ,
                         'action'     => 'showEdit']);
Router::register('POST', ['url'       => '/profile/{user}/edit' ,
                          'controller' => 'ProfileController'   ,
                          'action'     => 'saveEdit']);
Router::register('GET', ['url'        => '/profile/{user}/ppic' ,
                         'controller' => 'ProfileController'    ,
                         'action'     => 'getPpicture']);
Router::register('GET', ['url'        => '/profile/{user}/bpic' ,
                         'controller' => 'ProfileController'    ,
                         'action'     => 'getBpicture']);
Router::register('GET', ['url'        => '/profile/{user}/style' ,
                         'controller' => 'ProfileController'     ,
                         'action'     => 'generateStyle']);
Router::register('GET', ['url'        => '/self/ppic' ,
                         'controller' => 'ProfileController'     ,
                         'action'     => 'getSelfPpicture']);
?>
