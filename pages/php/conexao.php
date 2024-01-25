<?php

class Conexao {
    private $host = "localhost";
    private $usuario = "root";
    private $senha = "";
    private $banco = "receita";
    private $conexao;

    public function __construct() {
        $this->conexao = new mysqli($this->host, $this->usuario, $this->senha, $this->banco);

        if ($this->conexao->connect_error) {
            die("Erro de Conexão: " . $this->conexao->connect_error);
        }
    }

    public function getConexao() {
        return $this->conexao;
    }
}

?>