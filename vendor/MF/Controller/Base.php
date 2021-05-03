<?php

namespace MF\Controller;

abstract class Base {

	//Essa função verifica se o usuário esta logado no sistema, caso não, redireciona para a pagina princial
	public static function checkAuthToken(){
		session_start();

		if(isset($_SESSION['auth_token']) && $_SESSION['auth_token'] != ''){
			return true;
		}else{
			return false;
		}
	}
	
	public static function checkAdminToken(){
		session_start();

		if(isset($_SESSION['access_token']) && $_SESSION['access_token'] != ''){
			return true;
		}else{
			return false;
		}		
	}
    
}

?>