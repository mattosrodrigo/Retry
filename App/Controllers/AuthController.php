<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Controller\Base;
use MF\Model\Container;

class AuthController extends Action {

    public function auth(){
        if(Base::checkAuthToken()){
            header('Location: /');
        }

        if(!isset($_POST['login']) || !isset($_POST['senha'])){
            header('Location: /login?erro=form_null');
        }

        $usuario = Container::getModel('Usuario');
        $usuario->__set('login', $_POST['login']);
        $usuario->__set('senha', md5($_POST['senha']));

        $usuario->login();

        if($usuario->__get('id') != '' && $usuario->__get('login') != ''){
            $_SESSION['id'] = $usuario->__get('id');
            $_SESSION['login'] = $usuario->__get('login');
            $_SESSION['email'] = $usuario->__get('email');
            $_SESSION['auth_token'] = $usuario->__get('auth_token'); 
            header('Location: /');
        }else{
            header('Location: /login?erro=none_user');
        }
    }

    public function sair(){
        if(Base::checkAuthToken()){
            session_destroy();
            header('Location: /');
        }
        header('Location: /');
    }

}

?>