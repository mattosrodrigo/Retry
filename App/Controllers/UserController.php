<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Controller\Base;
use MF\Model\Container;

class UserController extends Action{

	//Registra o usuario no model
	public function registrar(){
		if(Base::checkAuthToken()){
			header('Location: /');
		}

		//Instancia um usuário para tratar os dados recebidos do fomulário
		$user = Container::getModel('Usuario');
		$user->__set('login', $_POST['login']);
		$user->__set('senha', password_hash(md5($_POST['senha']), PASSWORD_ARGON2I));
		$user->__set('email', $_POST['email']);

		//Verifica se os dados do usuario são válidos
		if($user->validarCadastro()){
			//verifica se existe um usuario com o mesmo login desejado
			if(count($user->getUsuarioPorLogin()) == 0){
				//verifica se existe um usuario com o mesmo email desejado
				if(count($user->getUsuarioPorEmail()) == 0){
					//Realiza o cadastro do usuario no bd e carrga a view de login
					$user->salvar();
					$this->view->cadastroRealizado = true;
					$this->view->dados = Array(
						'login' => '',
						'senha' => ''	
						);
					$this->view->erroLogin = '';
					$this->view->erroCadastro = '';
					$this->render('login');
				}else{ //erro "email ja cadastrado"
					$this->view->dados = array(
						'login' => $_POST['login'],
						'email' => $_POST['email'],
						'senha' => $_POST['senha'],
					);

					$this->view->cadastroRealizado = false;
					$this->view->erroCadastro = 'email_existente';
					$this->view->erroLogin = '';
					$this->render('login');
				}
			}else{ // erro "login ja cadastrado"
				$this->view->dados = array(
					'login' => $_POST['login'],
					'email' => $_POST['email'],
					'senha' => $_POST['senha'],
				);

				$this->view->cadastroRealizado = false;
				$this->view->erroCadastro = 'login_existente';
				$this->view->erroLogin = '';
				$this->render('login');
			}
			
		}else{ // erro "dados do formulario não sao válidos"

			$this->view->dados = array(
				'login' => $_POST['login'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha'],
			);

			$this->view->cadastroRealizado = false;
			$this->view->erroCadastro = $user->__get('erro');
			$this->view->erroLogin = '';
			$this->render('login');
		}
	}

	//Carrega pagina de login
	public function login() {

		if(Base::checkAuthToken()){
			header('Location: /');
		}

		$this->view->dados = Array(
			'login' => '',
			'senha' => ''	
			);

		$this->view->cadastroRealizado = false;

		$this->view->erroLogin = isset($_GET['erro']) ? $_GET['erro'] : '';

		$this->view->erroCadastro = isset($_GET['erro']) ? $_GET['erro'] : '';

		$this->render('login');
	}

	

}


?>