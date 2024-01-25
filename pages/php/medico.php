<?php
// Incluir a classe de conexão e a classe Medico
require_once 'Conexao.php';
require_once 'medico1.php';

// Instanciar a classe de conexão
$conexao = new Conexao();

// Instanciar a classe Medico
$medico = new Medico($conexao);

// Verificar se o formulário foi enviado para cadastrar ou editar médico
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cadastrar_medico'])) {
        // Cadastrar novo médico
        $nomeMedico = $_POST['nome_medico'];
        $especialidadeMedico = $_POST['especialidade_medico'];
        $crmMedico = $_POST['crm_medico'];

        // Chamar o método cadastrarMedico
        $medico->cadastrarMedico($nomeMedico, $especialidadeMedico, $crmMedico);
    } elseif (isset($_POST['editar_medico'])) {
        // Editar médico existente
        $idMedico = $_POST['id_medico'];
        $nomeMedico = $_POST['nome_medico'];
        $especialidadeMedico = $_POST['especialidade_medico'];
        $crmMedico = $_POST['crm_medico'];

        // Chamar o método editarMedico
        $medico->editarMedico($idMedico, $nomeMedico, $especialidadeMedico, $crmMedico);
    }
}

// Verificar se há um parâmetro 'action' na URL para realizar ações de CRUD
if (isset($_GET['action_medico'])) {
    $actionMedico = $_GET['action_medico'];

    // Executar operações de CRUD com base na ação
    switch ($actionMedico) {
        case 'edit':
            // Editar médico
            $idMedico = $_GET['id_medico'];
            // Recuperar dados do médico pelo ID
            $medicoParaEdicao = $medico->listarMedicoPorId($idMedico);
            break;

        case 'delete':
            // Excluir médico
            $idMedico = $_GET['id_medico'];
            // Chamar o método excluirMedico
            $medico->excluirMedico($idMedico);
            break;

        default:
            break;
    }
}

// Listar todos os médicos
$medicos = $medico->listarMedicos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/metodista/assets/css/styleplus.css">
    <title>CRUD de Médicos</title>
</head>
<body>
   <div class="container">
   <div class="lateral">
            <?php
    require_once '../home/menulateral.php';
    ?>
   <div class="conteudo">
   <h1>CRUD de Médicos</h1>
    
    <!-- Formulário para cadastrar ou editar médico -->
    <form action="medico.php" method="post">
        <?php if (isset($medicoParaEdicao)) : ?>
            <input type="hidden" name="id_medico" value="<?= $medicoParaEdicao['id']; ?>">
        <?php endif; ?>

        <label for="nome_medico">Nome:</label>
        <input type="text" id="nome_medico" name="nome_medico" 
            value="<?= isset($medicoParaEdicao) ? $medicoParaEdicao['nome'] : ''; ?>" required><br>

        <label for="especialidade_medico">Especialidade:</label>
        <input type="text" id="especialidade_medico" name="especialidade_medico" 
            value="<?= isset($medicoParaEdicao) ? $medicoParaEdicao['especialidade'] : ''; ?>" required><br>

        <label for="crm_medico">CRM:</label>
        <input type="text" id="crm_medico" name="crm_medico" 
            value="<?= isset($medicoParaEdicao) ? $medicoParaEdicao['crm'] : ''; ?>" required><br>

        <?php if (isset($medicoParaEdicao)) : ?>
            <button type="submit" name="editar_medico">Editar</button>
        <?php else : ?>
            <button type="submit" name="cadastrar_medico">Cadastrar</button>
        <?php endif; ?>
      
    </form>

    <!-- Tabela para listar médicos -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Especialidade</th>
            <th>CRM</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($medicos as $med) : ?>
            <tr>
                <td><?= $med['id']; ?></td>
                <td><?= $med['nome']; ?></td>
                <td><?= $med['especialidade']; ?></td>
                <td><?= $med['crm']; ?></td>
                <td>
                    <a href="medico.php?action_medico=edit&id_medico=<?= $med['id']; ?>">Editar</a>
                    <a href="medico.php?action_medico=delete&id_medico=<?= $med['id']; ?>" 
                        onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
   </div>
   </div>
</body>
</html>