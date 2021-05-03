<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'AppController',
			'action' => 'index'
		);

		$routes['jogo'] = array(
			'route' => '/jogo',
			'controller' => 'AppController',
			'action' => 'jogo'
		);

		$routes['like'] = array(
			'route' => '/like',
			'controller' => 'AppController',
			'action' => 'like'
		);

		$routes['comentar'] = array(
			'route' => '/comentar',
			'controller' => 'AppController',
			'action' => 'comentar'
		);

		$routes['games'] = array(
			'route' => '/games',
			'controller' => 'AppController',
			'action' => 'games'
		);

		$routes['search'] = array(
			'route' => '/search',
			'controller' => 'AppController',
			'action' => 'search'
		);

		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'UserController',
			'action' => 'registrar'
		);

		$routes['login'] = array(
			'route' => '/login',
			'controller' => 'UserController',
			'action' => 'login'
		);

		$routes['auth'] = array(
			'route' => '/auth',
			'controller' => 'AuthController',
			'action' => 'auth'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$routes['master'] = array(
			'route' => '/master',
			'controller' => 'AdminController',
			'action' => 'indexAdmin'
		);

		$routes['admin_auth'] = array(
			'route' => '/admin_auth',
			'controller' => 'AdminController',
			'action' => 'authAdmin'
		);

		$routes['admin_sair'] = array(
			'route' => '/admin_sair',
			'controller' => 'AdminController',
			'action' => 'sair'
		);

		$routes['sys'] = array(
			'route' => '/sys',
			'controller' => 'AdminController',
			'action' => 'sys'
		);

		$routes['jogos'] = array(
			'route' => '/jogos',
			'controller' => 'AdminController',
			'action' => 'jogos'
		);

		$routes['selJogo'] = array(
			'route' => '/selJogo',
			'controller' => 'AdminController',
			'action' => 'selJogo'
		);
		
		$routes['altJogo'] = array(
			'route' => '/altJogo',
			'controller' => 'AdminController',
			'action' => 'selJogo'
		);

		$routes['alterar'] = array(
			'route' => '/alterar',
			'controller' => 'AdminController',
			'action' => 'alterar'
		);

		$routes['deletar'] = array(
			'route' => '/delJogo',
			'controller' => 'AdminController',
			'action' => 'deletar'
		);

		$routes['cadastrar'] = array(
			'route' => '/cadJogo',
			'controller' => 'AdminController',
			'action' => 'cadastrar'
		);

		$this->setRoutes($routes);
	}

}

?>