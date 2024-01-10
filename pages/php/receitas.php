<?php
// Incluir a classe de conexão e as classes Medico, Paciente e Receita
require_once 'Conexao.php';
require_once 'Medico1.php';
require_once 'Paciente.php';
require_once 'receita1.php';



// Instanciar a classe de conexão
$conexao = new Conexao();
use Dompdf\Dompdf;

// Instanciar as classes Medico, Paciente e Receita
$medico = new Medico($conexao);
$paciente = new Paciente($conexao);
$receita = new Receita($conexao);

// Verificar se o formulário foi enviado para cadastrar ou editar receita
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cadastrar_receita'])) {
        // Cadastrar nova receita
        $idMedico = $_POST['id_medico'];
        $idPaciente = $_POST['id_paciente'];
        $descricaoReceita = $_POST['descricao_receita'];

        // Chamar o método cadastrarReceita
        $receita->cadastrarReceita($idMedico, $idPaciente, $descricaoReceita);
    } elseif (isset($_POST['editar_receita'])) {
        // Editar receita existente
        $idReceita = $_POST['id_receita'];
        $idMedico = $_POST['id_medico'];
        $idPaciente = $_POST['id_paciente'];
        $descricaoReceita = $_POST['descricao_receita'];

        // Chamar o método editarReceita
        $receita->editarReceita($idReceita, $idMedico, $idPaciente, $descricaoReceita);
    }
}

// Verificar se o formulário foi enviado para cadastrar, editar, pesquisar ou baixar PDF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ...

    } elseif (isset($_POST['pesquisar_receitas'])) {
        // Pesquisar receitas
        $termoPesquisa = $_POST['search'];
        $receitas = $receita->pesquisarReceitas($termoPesquisa);
    } elseif (isset($_POST['download_pdf'])) {
        // Baixar PDF
        $receita->gerarPDF($receitas);
    }
// Adicione este método na classe Receita


// Verificar se há um parâmetro 'action' na URL para realizar ações de CRUD
if (isset($_GET['action_receita'])) {
    $actionReceita = $_GET['action_receita'];
    

    // Executar operações de CRUD com base na ação
    switch ($actionReceita) {
        case 'edit':
            // Editar receita
            $idReceita = $_GET['id_receita'];
            // Recuperar dados da receita pelo ID
            $receitaParaEdicao = $receita->listarReceitaPorId($idReceita);
            break;

        case 'delete':
            // Excluir receita
            $idReceita = $_GET['id_receita'];
            // Chamar o método excluirReceita
            $receita->excluirReceita($idReceita);
            break;
            case 'pdf':
       
                $idReceita = $_GET['id_receita'];
                $receitaObj = new Receita($conexao); // Crie uma instância da classe Receita
                $receitaObj->gerarPDF($idReceita);
                break;

        default:
            break;
    }
    
}

// Listar todas as receitas
$receitas = $receita->listarReceitas();

// Listar todos os médicos e pacientes para preencher os selects no formulário
$medicos = $medico->listarMedicos();
$pacientes = $paciente->listarPacientes();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir Receitas</title>
    <link rel="stylesheet" href="/metodista/assets/css/styledados.css">

</head>
<body>
    <div class="container">
    
   <div class="lateral">
            <?php
    require_once '../home/menulateral.php';
    ?>
            </div>
   <div class="conteudo">
   <h1>Gerir Receitas</h1>
    
    <!-- Formulário para cadastrar ou editar receita -->
    <form action="receitas.php" method="post">
        <?php if (isset($receitaParaEdicao)) : ?>
            <input type="hidden" name="id_receita" value="<?= $receitaParaEdicao['id']; ?>">
        <?php endif; ?>

        <label for="id_medico">Médico:</label>
        <select id="id_medico" name="id_medico" required>
            <?php foreach ($medicos as $med) : ?>
                <option value="<?= $med['id']; ?>" <?= (isset($receitaParaEdicao) && $receitaParaEdicao['id_medico'] == $med['id']) ? 'selected' : ''; ?>>
                    <?= $med['nome']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="id_paciente">Paciente:</label>
        <select id="id_paciente" name="id_paciente" required>
            <?php foreach ($pacientes as $pac) : ?>
                <option value="<?= $pac['id']; ?>" <?= (isset($receitaParaEdicao) && $receitaParaEdicao['id_paciente'] == $pac['id']) ? 'selected' : ''; ?>>
                    <?= $pac['nome']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="descricao_receita">    </label>
        <textarea id="descricao_receita" placeholder="Descrição da Receita" name="descricao_receita" required><?= isset($receitaParaEdicao) ? $receitaParaEdicao['descricao'] : ''; ?></textarea><br>

        <?php if (isset($receitaParaEdicao)) : ?>
            <button type="submit" name="editar_receita">Editar</button>
        <?php else : ?>
            <button type="submit" name="cadastrar_receita">Cadastrar</button>
        <?php endif; ?>
       
    </form>

    <!-- Tabela para listar receitas -->
 
 
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Médico</th>
            <th>Paciente</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($receitas as $rec) : ?>
            <tr>
                <td><?= $rec['id']; ?></td>
                <td><?= $rec['medico']; ?></td>
                <td><?= $rec['paciente']; ?></td>
                <td><?= $rec['descricao']; ?></td>
                <td>
                    <a href="receitas.php?action_receita=edit&id_receita=<?= $rec['id']; ?>">Editar</a>
                    <a href="receitas.php?action_receita=pdf&id_receita=<?= $rec['id']; ?>">Baixar Receita</a>
                    <a href="receitas.php?action_receita=delete&id_receita=<?= $rec['id']; ?>" 
                        onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
   </div>


    </div>

</body>
</html>