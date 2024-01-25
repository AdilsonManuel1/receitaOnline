<?php
// Incluir a classe de conexão e a classe Paciente
require_once 'Conexao.php';
require_once 'Paciente.php';

// Instanciar a classe de conexão
$conexao = new Conexao();

// Instanciar a classe Paciente
$paciente = new Paciente($conexao);

// Verificar se o formulário foi enviado para cadastrar um novo paciente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter dados do formulário
    $nome = $_POST['nome'];
    $bilhete = $_POST['bilhete'];
    $dataNascimento = $_POST['data_nascimento'];
    $endereco = $_POST['endereco'];
    $telefone = $_POST['telefone'];

    // Chamar o método cadastrarPaciente
    $paciente->cadastrarPaciente($nome, $bilhete, $dataNascimento, $endereco, $telefone);
}

// Verificar se há um parâmetro 'action' na URL para realizar ações de CRUD
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Executar operações de CRUD com base na ação
    switch ($action) {
        case 'edit':
            // Editar paciente
            $id = $_GET['id'];
            // Recuperar dados do paciente pelo ID
            $pacienteParaEdicao = $paciente->listarPacientesPorId($id);
            break;

        case 'update':
            // Atualizar paciente
            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $bilhete = $_POST['bilhete'];
            $dataNascimento = $_POST['data_nascimento'];
            $endereco = $_POST['endereco'];
            $telefone = $_POST['telefone'];
            // Chamar o método editarPaciente
            $paciente->editarPaciente($id, $nome, $bilhete, $dataNascimento, $endereco, $telefone);
            break;

        case 'delete':
            // Excluir paciente
            $id = $_GET['id'];
            // Chamar o método excluirPaciente
            $paciente->excluirPaciente($id);
            break;

        default:
            break;
    }
}

// Listar todos os pacientes
$pacientes = $paciente->listarPacientes();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/metodista/assets/css/styleplus.css">
    <title>Gerir Pacientes</title>
</head>
<body>
<div class="container">
<div class="lateral">
            <?php
    require_once '../home/menulateral.php';
    ?>
 <div class="conteudo">
       
<h1>Gerir Pacientes</h1>
    
    <!-- Formulário para cadastrar paciente -->
    <form action="index.php" method="post">
        <label for="nome">Nome</label>
        <input type="text" id="nome" placeholder="Nome" name="nome" required><br>

        <label for="bilhete">Bilhete</label>
        <input type="text" id="bilhete" name="bilhete" required><br>

        <label for="data_nascimento">Nascido(a)</label>
        <input type="date" id="data_nascimento" name="data_nascimento" required><br>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required><br>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" required><br>

        <button type="submit">Cadastrar</button>
    </form>

    <!-- Tabela para listar pacientes -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Bilhete</th>
            <th>Data de Nascimento</th>
            <th>Endereço</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($pacientes as $pac) : ?>
            <tr>
                <td><?= $pac['id']; ?></td>
                <td><?= $pac['nome']; ?></td>
                <td><?= $pac['bilhete']; ?></td>
                <td><?= $pac['datanascimento']; ?></td>
                <td><?= $pac['endereco']; ?></td>
                <td><?= $pac['telefone']; ?></a> </td>
                <td><a  href="https://api.whatsapp.com/send?phone=<?= $pac['telefone']; ?>" target="_blank">Link do WhatsApp</a></td>

                <td>
                    <a href="index.php?action=edit&id=<?= $pac['id']; ?>">Editar</a>
                    <a href="index.php?action=delete&id=<?= $pac['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Formulário para editar paciente -->
    <?php if (isset($pacienteParaEdicao)) : ?>
        <h2>Editar Paciente</h2>
        <form action="index.php?action=update" method="post">
            <input type="hidden" name="id" value="<?= $pacienteParaEdicao['id']; ?>">
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" value="<?= $pacienteParaEdicao['nome']; ?>" required><br>

            <label for="bilhete">Bilhete de Identidade:</label>
            <input type="text" id="bilhete" name="bilhete" value="<?= $pacienteParaEdicao['bilhete']; ?>" required><br>

            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" value="<?= $pacienteParaEdicao['datanascimento']; ?>" required><br>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?= $pacienteParaEdicao['endereco']; ?>" required><br>

            <label for="telefone">Telefone:</label>
            <input type="tel" id="telefone" name="telefone" value="<?= $pacienteParaEdicao['telefone']; ?>" required><br>

            <button type="submit">Atualizar</button>
        </form>
 </div>
</div>
    <?php endif; ?>
</body>
</html>