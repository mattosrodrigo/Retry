<?php

namespace App\Models;

use MF\Model\Model;

class Jogos extends Model {
    private $id;
    private $titulo;
    private $categoria;
    private $criador;
    private $data_lancamento;
    private $plataformas;
    private $imagem;
    private $link_video;
    private $resumo;
    private $avaliacao;
    private $nota;
    private $sinopseResumida;
    private $imgRetrato;
    private $tmp_retrato;
    private $reqMin;
    private $reqRecomendado;
    private $likes;
    private $id_usuario;
    private $tmp_img;
    private $diretorio;

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($attr, $value){
        $this->$attr = $value;
    }

    //Persiste um novo jogo no banco de dados
    public function salvar(){
        $query = "insert into tb_jogos(titulo, categoria, criador, data_lancamento, plataformas, link_video, resumo, avaliacao, sinopse_resumida, requisitos_minimos, requisitos_recomendados, nota, imagem, imgretrato)
        values(:titulo, :categoria, :criador, :data_lancamento, :plataformas, :link_video, :resumo, :avaliacao, :sinopse_resumida, :requisitos_minimos, :requisitos_recomendados, :nota, :imagem, :imgretrato)";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':titulo', $this->__get('titulo'));
        $stmt->bindValue(':categoria', $this->__get('categoria'));
        $stmt->bindValue(':criador', $this->__get('criador'));
        $stmt->bindValue(':data_lancamento', $this->__get('data_lancamento'));
        $stmt->bindValue(':plataformas', $this->__get('plataformas'));
        $stmt->bindValue(':link_video', $this->__get('link_video'));
        $stmt->bindValue(':resumo', $this->__get('resumo'));
        $stmt->bindValue(':avaliacao', $this->__get('avaliacao'));
        $stmt->bindValue(':sinopse_resumida', $this->__get('sinopseResumida'));
        $stmt->bindValue(':requisitos_minimos', $this->__get('reqMin'));
        $stmt->bindValue(':requisitos_recomendados', $this->__get('reqRecomendados'));
        $stmt->bindValue(':nota', $this->__get('nota'));
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->bindValue(':imgretrato', $this->__get('imgRetrato'));

        $stmt->execute();

        return $this;
    }

    //upload de imagens
    public function uploadImg(){
        $this->__set('diretorio', $this->__get('diretorio') . $this->db->lastInsertId() . '/');
        mkdir($this->__get('diretorio'), 0755);
        move_uploaded_file($this->__get('tmp_img'), $this->__get('diretorio') . $this->__get('imagem'));
        move_uploaded_file($this->__get('tmp_retrato'), $this->__get('diretorio') . $this->__get('imgRetrato'));
    }

    //edita os dados de um jogo
    public function editar(){
        $query = "update tb_jogos
        set titulo = :titulo, categoria = :categoria, criador = :criador, data_lancamento = :data_lancamento,
        plataformas = :plataformas, link_video = :link_video, resumo = :resumo, avaliacao = :avaliacao, sinopse_resumida = :sinopse_resumida, 
        requisitos_minimos = :requisitos_minimos, requisitos_recomendados = :requisitos_recomendados, 
        nota = :nota, imagem = :imagem, imgretrato = :imgretrato
        where id = :id";

        $stmt = $this->db->prepare($query);


        $stmt->bindValue(':titulo', $this->__get('titulo'));
        $stmt->bindValue(':categoria', $this->__get('categoria'));
        $stmt->bindValue(':criador', $this->__get('criador'));
        $stmt->bindValue(':data_lancamento', $this->__get('data_lancamento'));
        $stmt->bindValue(':plataformas', $this->__get('plataformas'));
        $stmt->bindValue(':link_video', $this->__get('link_video'));
        $stmt->bindValue(':resumo', $this->__get('resumo'));
        $stmt->bindValue(':avaliacao', $this->__get('avaliacao'));
        $stmt->bindValue(':sinopse_resumida', $this->__get('sinopseResumida'));
        $stmt->bindValue(':requisitos_minimos', $this->__get('reqMin'));
        $stmt->bindValue(':requisitos_recomendados', $this->__get('reqRecomendados'));
        $stmt->bindValue(':nota', $this->__get('nota'));
        $stmt->bindValue(':imagem', $this->__get('imagem'));
        $stmt->bindValue(':imgretrato', $this->__get('imgRetrato'));
        $stmt->bindValue(':id', $this->__get('id'));

        $stmt->execute();

        if($this->__get('tmp_img') != ''){
            move_uploaded_file($this->__get('tmp_img'), $this->__get('diretorio') . $this->__get('imagem'));
        }

        if($this->__get('tmp_retrato') != ''){
            move_uploaded_file($this->__get('tmp_retrato'), $this->__get('diretorio') . $this->__get('imgRetrato'));
        }
            

        return $this;
    }

    //recupera todos os jogos gravados
    public function getAll(){
        $query = "select * from tb_jogos";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //exclui um determinado jogo
    public function excluir(){
        $query = "delete from tb_jogos where id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id', $this->__get('id'));

        $stmt->execute();

        return $this;
    }
    
    //Valida a inclusão de um novo jogo
    public function validaInclusao(){
        $query = "select * from tb_jogos 
        where titulo = :titulo, categoria = :categoria,
        criador = :criador, data_lancamento = :data_lancamento,";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':titulo', $this->__get('titulo'));
        $stmt->bindValue(':categoria', $this->__get('categoria'));
        $stmt->bindValue(':criador', $this->__get('criador'));
        $stmt->bindValue(':data_lancamento', $this->__get('data_lancamento'));
        $stmt->execute();

        if(count($stmt->fetchAll(\PDO::FETCH_ASSOC)) > 0){
            return false;
        }else{
            return true;
        }
    }

    //salva a pesquisa do usuario
    public function salvaPesquisa(){
        $query = "insert into tb_visitas(id_jogo) values(:id_jogo)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_jogo', $this->__get('id'));
        $stmt->execute();

        return $this;
    }

    //recupera todos os dados de um jogo para exibir na view
    public function getJogo(){
        //seleciona o jogo
        $query = "select * from tb_jogos where id = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue('id', $this->__get('id'));
        $stmt->execute();

        //salva a pesquisa do usuario
        $this->salvaPesquisa();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    //curtir um jogo
    public function like(){
        $query = "insert into tb_likes(id_jogo, id_usuario) values(:id_jogo, :id_usuario)";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_jogo', $this->__get('id'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));

        $stmt->execute();

        return $this;
    }

    //descurte um jogo
    public function unlike(){
        $query = "delete from tb_likes where id_jogo = :id_jogo and id_usuario = :id_usuario";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_jogo', $this->__get('id'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));

        $stmt->execute();

        return $this;
    }

    //Recupera a quantidade de likes de um determinado jogo
    public function getLikes(){
        $query = "select count(*) as qtd_likes from tb_likes where id_jogo = :id_jogo";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id_jogo', $this->__get('id'));

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function isLiked(){
        $query = "select count(*) as liked from tb_likes where id_jogo = :id_jogo and id_usuario = :id_usuario";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id_jogo', $this->__get('id'));
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));

        $stmt->execute();

        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

        if($resultado['liked'] == 0){
            return false;
        }else{
            return true;
        }
        
    }

    public function getComentarios(){
        $query = "select com.*, usu.login nome from tb_comentarios com 
        right join tb_usuarios as usu on com.id_usuario = usu.id
        where id_jogo = :id_jogo order by data";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':id_jogo', $this->__get('id'));

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //pesquisar jogo
    public function search(){
        $query = "select * from tb_jogos where titulo
        like :titulo
        order by titulo";

        $stmt = $this->db->prepare($query);

        $stmt->bindValue(':titulo', '%'.$this->__get('titulo').'%');

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    //mais populares
    public function getPopulares(){
        $query = "select jog.id, jog.titulo, jog.imgretrato, jog.sinopse_resumida, 
        (select count(*) as qtd_visita from tb_visitas where id_jogo = jog.id) as qtd_visitas
        from tb_jogos jog
        order by qtd_visitas desc
        ";

        $stmt = $this->db->prepare($query);
        
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    //Ultimos lançamentos
    public function getLancamentos(){
        $query = "select * from tb_jogos order by data_lancamento desc";
        $stmt = $this->db->prepare($query);
        
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //Ultimos lançamentos
    public function getAvaliados(){
        $query = "select * from tb_jogos order by nota desc";
        $stmt = $this->db->prepare($query);
        
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}