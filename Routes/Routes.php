<?php
namespace Routes;

class Routes{

    public static function getRoutes(){

        return  [
            '/' => 'HomeController@index',
            '/home' => 'HomeController@index',

            '/login' => 'UserController@login',
            '/loginAction' => 'UserController@loginAction',
            
            '/cadastro' => 'UserController@cadastro',
            '/cadastroAction' => 'UserController@cadastroAction',

            '/verify-account' => 'UserController@verifyAccount',

            '/block-account' => 'UserController@blockAccount',

            '/logout' => 'UserController@logout',

        ];
    }

}

?>
