<?php

namespace App\Models;

use MF\Model\Model;

class Admin extends Model {
    private $id;
    private $login;
    private $senha;
    private $access_token;

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($attr, $value){
        $this->$attr = $value;
    }

    //cadastrar novo administrador
    public function salvar(){
        $query = "insert into tb_admin(login, senha, access_token) values(:login, :senha, :access_token)";

        //$this->__set('login', 'marcogea');
        //$this->__set('senha', md5('123456'));
        //$this->__set('access_token', md5('123456'));

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':login', $this->__get('login'));
        $stmt->bindValue(':senha', password_hash($this->__get('senha'), PASSWORD_ARGON2I));
        $stmt->bindValue(':access_token', password_hash($this->__get('access_token'), PASSWORD_DEFAULT));

        $stmt->execute();

        return $this;
    }

    //metodo para entrar na administração do site
    public function login(){
        $query = "select * from tb_admin where login = :login";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':login', $this->__get('login'));
        $stmt->execute();

        $admin = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(password_verify($this->__get('senha'), $admin['senha']) || password_verify($this->__get('access_token'), $admin['access_token'])){
            if($admin['id'] != '' && $admin['login'] != '' && $admin['access_token'] != ''){
                $this->__set('login', $admin['login']);
                $this->__set('id', $admin['id']);
                $this->__set('access_token', $admin['access_token']);
                $this->__set('senha', '');
            }
        }

        return $this;
    }

}

?>