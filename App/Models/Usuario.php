<?php

namespace App\Models;

use MF\Model\Model;
use MF\Libs\Crypt\Crypt;

class Usuario extends Model {

    private $id;
    private $login;
    private $senha;
    private $email;
    private $data_inscricao;
    private $auth_token;
    private $erro;
    private $id_jogo;
    private $comentario;

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($attr, $value){
        $this->$attr = $value;
    }

    //Registra um novo usuario
    public function salvar(){
        $query = "insert into tb_usuarios (login, senha, email) values(:login, :senha, :email)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':login', $this->__get('login'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $this;
    }

    //Validar cadastro
    public function validarCadastro(){
        $valido = true;

        if(strlen($this->__get('login')) < 6){
            $valido = false;
            $this->erro = 'login_curto';
        }

        if(strlen($this->__get('senha')) < 6){
            $valido = false;
            $this->erro = 'senha_curta';
        }

        return $valido;
    }
    
    //Recuperar usuario por e-mail
    public function getUsuarioPorEmail(){
        $query = "select email from tb_usuarios where email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //recuperar usuario por login
    public function getUsuarioPorLogin(){
        $query = "select login from tb_usuarios where login = :login";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':login', $this->__get('login'));
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //Metodo usado no login
    public function login(){
        $query = "select id, login, email, senha from tb_usuarios where login = :login";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':login', $this->__get('login'));
        $stmt->execute();
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(password_verify($this->__get('senha'), $usuario['senha'])){
            if($usuario['id'] != '' && $usuario['login'] != '' && $usuario['email'] != ''){
                $this->__set('login', $usuario['login']);
                $this->__set('id', $usuario['id']);
                $this->__set('email', $usuario['email']);
                $this->__set('auth_token', $this->generateAuthToken());
            }
        }   

        return $this;
    }

    //Metodo usado no login para gerar o token de acesso a aplicação web
    private function generateAuthToken(){
        $data = str_replace('/', '', date('m/d/Y'));
        $key = random_int(3, 100);
        $token = $this->__get('id') . $data . $key;
        $hash = password_hash(md5($token . $data . $key), PASSWORD_DEFAULT);
        return $hash;
    }

    public function comentar(){
        $query = "insert into tb_comentarios(id_jogo, id_usuario, comentario)
        values(:id_jogo, :id_usuario, :comentario)";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id_jogo', $this->__get('id_jogo'));
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->bindValue(':comentario', $this->__get('comentario'));

        $stmt->execute();

        return $this;

    }

    
}

?>