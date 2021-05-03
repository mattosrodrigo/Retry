<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Controller\Base;
use MF\Model\Container;

class AdminController extends Action {

    public function indexAdmin(){
        if(Base::checkAdminToken()){
            header('Location: /sys');
        }

        $this->view->erroLogin = isset($_GET['erro']) ? $_GET['erro'] : '';

        $this->render('admin');
    }

    //login como administrador
    public function authAdmin(){
        if(Base::checkAdminToken()){
            header('Location: /sys');
        }

        if(!isset($_POST['login']) || !isset($_POST['senha']) || !isset($_POST['token'])){
            header('Location: /master?erro=form_null');
        }

        $admin = Container::getModel('Admin');
        $admin->__set('login', $_POST['login']);
        $admin->__set('senha', md5($_POST['senha']));
        $admin->__set('access_token', md5($_POST['token']));
        //executa a tentativa de logar como administrador
        $admin->login();
        
        if($admin->__get('id') != '' && $admin->__get('login') != '' && $admin->__get('access_token') != ''){
            $_SESSION['id'] = $admin->__get('id');
            $_SESSION['login'] = $admin->__get('login');
            $_SESSION['access_token'] = $admin->__get('access_token');
            header('Location: /sys'); 
        }else{
            header('Location: /master?erro=none_user');
        }
    }

    public function sys(){
        if(!Base::checkAdminToken()){
            header('Location: /');
        }
        $this->view->admin = $_SESSION['login'];
        $this->render('menu');
    }

    public function jogos(){
        if(!Base::checkAdminToken()){
            header('Location: /');
        }
        $this->view->admin = $_SESSION['login'];
        
        $jogos = Container::getModel('Jogos');
        
        $this->view->jogos = $jogos->getAll();

        if(isset($_GET['id'])){
            $jogos->__set("id", $_GET['id']);
            $this->view->jogo = $jogos->getJogo();
        }
        
        $this->view->sel = isset($_GET['acao']) ? $_GET['acao'] : '';
        

        $this->render('jogos');
    }

    public function selJogo(){
        $this->jogos();
    }

    public function alterar(){
        if(!Base::checkAdminToken()){
            header('Location: /');
        }

        if(!isset($_GET['id']) || !isset($_GET['acao']) || $_GET['acao'] != 'alt'){
            header('Location: /master');
        }

        $jogo = Container::getModel('Jogos');  

        $jogo->__set('id', $_GET['id']);
        $jogo->__set('titulo', $_POST['titulo']);
        $jogo->__set('categoria', $_POST['categoria']);
        $jogo->__set('criador', $_POST['criador']);
        $jogo->__set('data_lancamento', $_POST['data_lancamento']);
        $jogo->__set('plataformas', $_POST['plataformas']);
        if($_FILES['imagem']['name'] != '' && $_FILES['imagem']['name'] != $_POST['imagemAnt']){
            $jogo->__set('imagem', $_FILES['imagem']['name']);
            $jogo->__set('tmp_img', $_FILES['imagem']['tmp_name']);
            $jogo->__set('diretorio', 'imagens/' . $_GET['id'] . '/');
        }else{
            $jogo->__set('imagem', $_POST['imagemAnt']);
        }
        if($_FILES['imagemRet']['name'] != '' && $_FILES['imagemRet']['name'] != $_POST['imagemRetAnt']){
            $jogo->__set('imgRetrato', $_FILES['imagemRet']['name']);
            $jogo->__set('tmp_retrato', $_FILES['imagemRet']['tmp_name']);
            $jogo->__set('diretorio', 'imagens/' . $_GET['id'] . '/');
        }else{
            $jogo->__set('imgRetrato', $_POST['imagemRetAnt']);
        }
        $jogo->__set('link_video', $_POST['link_video']);
        $jogo->__set('resumo', $_POST['resumo']);
        $jogo->__set('avaliacao', $_POST['avaliacao']);
        $jogo->__set('nota', $_POST['nota']);
        $jogo->__set('reqMin', $_POST['reqMin']);
        $jogo->__set('reqRecomendados', $_POST['reqRecomendados']);
        $jogo->__set('sinopseResumida', $_POST['sinopseResumida']);

        $jogo->editar();

        $this->view->admin = $_SESSION['login'];
        
        $this->view->jogos = $jogo->getAll();

        if(isset($_GET['id'])){
            $jogo->__set("id", $_GET['id']);
            $this->view->jogo = $jogo->getJogo();
        }
        $this->view->sel = isset($_GET['acao']) ? $_GET['acao'] : '';

        $this->render('jogos');
    }

    public function deletar(){
        if(!Base::checkAdminToken()){
            header('Location: /');
        }

        if(!isset($_GET['id']) || !isset($_GET['acao']) || $_GET['acao'] != 'del'){
            header('Location: /master');
        } 

        $jogo = Container::getModel('Jogos');  

        $jogo->__set('id', $_GET['id']);

        $jogo->excluir();

        header('Location: /jogos');
    }

    public function cadastrar(){
        if(!Base::checkAdminToken()){
            header('Location: /');
        }

        if(!isset($_GET['acao']) || $_GET['acao'] != 'cad'){
            header('Location: /jogos');
        }

        $jogo = Container::getModel('Jogos');  

        $jogo->__set('titulo', $_POST['titulo']);
        $jogo->__set('categoria', $_POST['categoria']);
        $jogo->__set('criador', $_POST['criador']);
        $jogo->__set('data_lancamento', $_POST['data_lancamento']);
        $jogo->__set('plataformas', $_POST['plataformas']);
        $jogo->__set('imagem', $_FILES['imagem']['name']);
        $jogo->__set('imgRetrato', $_FILES['imagemRet']['name']);
        $jogo->__set('link_video', $_POST['link_video']);
        $jogo->__set('resumo', $_POST['resumo']);
        $jogo->__set('avaliacao', $_POST['avaliacao']);
        $jogo->__set('nota', $_POST['nota']);
        $jogo->__set('reqMin', $_POST['reqMin']);
        $jogo->__set('reqRecomendados', $_POST['reqRecomendados']);
        $jogo->__set('sinopseResumida', $_POST['sinopseResumida']);

        $jogo->salvar();

        $jogo->__set('tmp_img', $_FILES['imagem']['tmp_name']);
        $jogo->__set('tmp_retrato', $_FILES['imagemRet']['tmp_name']);
        //var_dump($_FILES);
        $jogo->__set('diretorio', 'imagens/');
        $jogo->uploadImg();


        header('Location: /jogos');
    }

    public function sair(){
        if(Base::checkAdminToken()){
            session_start();
            session_destroy();
            header('location: /');
        }
    }

}

?>