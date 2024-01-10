<?php

class Paciente {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao->getConexao();
    }

    public function cadastrarPaciente($nome, $bilhete, $dataNascimento, $endereco, $telefone) {
        $query = "INSERT INTO paciente (nome, datanascimento,bilhete, endereco, telefone) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param("sssss", $nome,$dataNascimento,$bilhete, $endereco, $telefone);
        $stmt->execute();
        $stmt->close();
    }

    public function listarPacientes() {
        $query = "SELECT * FROM paciente";
        $result = $this->conexao->query($query);
        $pacientes = $result->fetch_all(MYSQLI_ASSOC);
        return $pacientes;
    }

    public function listarPacientesPorId($id) {
        $query = "SELECT * FROM paciente WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $paciente = $result->fetch_assoc();
        $stmt->close();
        return $paciente;
    }

    public function editarPaciente($id, $nome, $dataNascimento,$bilhete, $endereco, $telefone) {
        $query = "UPDATE paciente SET nome = ?, bilhete = ?, datanascimento = ?, endereco = ?, telefone = ? WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param("sssssi", $nome, $bilhete, $dataNascimento, $endereco, $telefone, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function excluirPaciente($id) {
        $query = "DELETE FROM paciente WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

?>