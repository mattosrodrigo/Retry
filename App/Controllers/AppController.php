<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

	//Carrega a pagina principal
	public function index() {
		session_start();

		$this->view->auth_token = isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : '';
		$this->view->user = isset($_SESSION['login']) ? $_SESSION['login'] : '';

		$jogos = Container::getModel('Jogos');

		$this->view->populares = $jogos->getPopulares();
		$this->view->lancamentos = $jogos->getLancamentos();
		$this->view->melhoresAvaliados = $jogos->getAvaliados();

		$this->render('index');
	}

	public function jogo(){
		session_start();

		$this->view->auth_token = isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : '';
		$this->view->user = isset($_SESSION['login']) ? $_SESSION['login'] : '';
		$id_user = isset($_SESSION['id']) ? $_SESSION['id'] : '';

		$id = isset($_GET['id']) ? $_GET['id'] : header('Location: /');

		$jogos = Container::getModel('Jogos');

		$jogos->__set('id', $id);
		$jogos->__set('id_usuario', $id_user);

		

		$this->view->jogo = $jogos->getJogo();
		$this->view->qtdLikes = $jogos->getLikes();
		$this->view->isLiked = $jogos->isLiked();
		$this->view->comentarios = $jogos->getComentarios();
		

		$this->render('jogo');
	}

	public function like(){
		session_start();

		$id = isset($_GET['id']) ? $_GET['id'] : header('Location: /');
		if(!isset($_SESSION['id'])){
			header('Location: /');
		}

		$jogos = Container::getModel('Jogos');

		$jogos->__set('id', $id);
		$jogos->__set('id_usuario', $_SESSION['id']);

		if($jogos->isLiked()){
			$jogos->unlike();
		}else{
			$jogos->like();
		}

		header("Location: /jogo?id={$id}");
	}

	public function comentar(){
		session_start();

		$id_jogo = isset($_POST['id']) ? $_POST['id'] : header('Location: /');
		$comentario = isset($_POST['comentario']) ? $_POST['comentario'] : header('Location: /');
		if(!isset($_SESSION['id'])){
			header('Location: /');
		}

		$user = Container::getModel('Usuario');

		$user->__set('id', $_SESSION['id']);
		$user->__set('id_jogo', $id_jogo);
		$user->__set('comentario', $comentario);

		$user->comentar();

		header("Location: /jogo?id={$id_jogo}");

	}
	
	//Carrega a página de exibição do jogo
	public function games(){
		session_start();

		$this->view->auth_token = isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : '';
		$this->view->user = isset($_SESSION['login']) ? $_SESSION['login'] : '';

		$jogos = Container::getModel('Jogos');

		$this->view->jogos = $jogos->getAll();

		$this->render('games');
	}

	//Carrega a pesquisa de jogos
	public function search(){
		session_start();

		$this->view->auth_token = isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : '';
		$this->view->user = isset($_SESSION['login']) ? $_SESSION['login'] : '';

		$search = isset($_POST['search']) ? $_POST['search'] : header('Location: /');

		$jogos = Container::getModel('Jogos');

		$jogos->__set('titulo', $search);

		$this->view->jogos = $jogos->search();

		$this->render('games');
	}
    
}

?>