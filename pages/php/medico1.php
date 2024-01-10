<?php

class Medico {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao->getConexao();
    }

    public function cadastrarMedico($nome, $especialidade, $crm) {
        $query = "INSERT INTO medico (nome, especialidade, crm) VALUES (?, ?, ?)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param("sss", $nome, $especialidade, $crm);
        $stmt->execute();
        $stmt->close();
    }

    public function listarMedicos() {
        $query = "SELECT * FROM medico";
        $result = $this->conexao->query($query);
        $medicos = $result->fetch_all(MYSQLI_ASSOC);
        return $medicos;
    }

    public function listarMedicoPorId($id) {
        $query = "SELECT * FROM medico WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $medico = $result->fetch_assoc();
        $stmt->close();
        return $medico;
    }

    public function editarMedico($id, $nome, $especialidade, $crm) {
        $query = "UPDATE medico SET nome = ?, especialidade = ?, crm = ? WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param("sssi", $nome, $especialidade, $crm, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function excluirMedico($id) {
        $query = "DELETE FROM medico WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

?>