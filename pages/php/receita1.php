<?php
use Dompdf\Dompdf;
class Receita {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao->getConexao();
    }

    public function cadastrarReceita($idMedico, $idPaciente, $descricao) {
        $query = "INSERT INTO receitas (id_medico, id_paciente, descricao) VALUES (?, ?, ?)";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param("iis", $idMedico, $idPaciente, $descricao);
        $stmt->execute();
        $stmt->close();
    }

    public function listarReceitas() {
        $query = "SELECT r.id, p.nome as paciente, m.nome as medico, r.descricao FROM receitas r
                  INNER JOIN paciente p ON r.id_paciente = p.id
                  INNER JOIN medico m ON r.id_medico = m.id";
        $result = $this->conexao->query($query);
        $receitas = $result->fetch_all(MYSQLI_ASSOC);
        return $receitas;
    }

    public function listarReceitaPorId($id) {
        $query = "SELECT * FROM receitas WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $receita = $result->fetch_assoc();
        $stmt->close();
        return $receita;
    }

    public function editarReceita($id, $idMedico, $idPaciente, $descricao) {
        $query = "UPDATE receitas SET id_medico = ?, id_paciente = ?, descricao = ? WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param("iisi", $idMedico, $idPaciente, $descricao, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function excluirReceita($id) {
        $query = "DELETE FROM receitas WHERE id = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    // Adicione este método na classe Receita
public function pesquisarReceitas($termoPesquisa) {
    $query = "SELECT r.id, m.nome AS medico, p.nome AS paciente, r.descricao FROM receitas r
              INNER JOIN medicos m ON r.id_medico = m.id
              INNER JOIN pacientes p ON r.id_paciente = p.id
              WHERE r.descricao LIKE ?";
    
    $stmt = $this->conexao->prepare($query);
    $termoPesquisa = "%$termoPesquisa%"; // Adiciona % para pesquisar em qualquer parte do campo
    $stmt->bind_param("s", $termoPesquisa);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $receitas = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    return $receitas;
}


public function obterDescricaoReceita($idReceita) {
    // Consulta SQL para obter a descrição da receita com base no ID
    $query = "SELECT descricao FROM receitas WHERE id = ?";
    $stmt = $this->conexao->prepare($query);
    $stmt->bind_param("i", $idReceita);
    $stmt->execute();
    $stmt->bind_result($descricao);
    $stmt->fetch();
    $stmt->close();

    return $descricao;
}

public function gerarPDF($idReceita) {
    $descricao = $this->obterDescricaoReceita($idReceita);

    require_once 'dompdf/autoload.inc.php';
    $dompdf = new Dompdf();
    $dompdf->loadHtml($descricao);

    $dompdf->set_option('defaultfont', 'sans');
    //$dompdf->setPaper('A4', 'portrait');
    $dompdf->setPaper('A4', 'landscape'); 
    $dompdf->render();
    $dompdf->stream();
}

}




?>