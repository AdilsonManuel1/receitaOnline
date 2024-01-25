<?php
// Inclua a lógica de conexão com o banco de dados aqui
// Substitua 'seu_servidor', 'seu_usuario', 'sua_senha' e 'seu_banco' pelas informações reais

$mysqli = new mysqli('localhost', 'root', '', 'receita');

if ($mysqli->connect_error) {
    die('Erro de Conexão (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// Mensagem de erro inicial vazia
$mensagemErro = '';

// Verifica se o formulário de login foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o nome de usuário e a senha correspondem a um usuário válido
    $username = $_POST['user'];
    $password = $_POST['password'];

    // Consulta SQL para verificar o usuário e senha
    $query = "SELECT * FROM user WHERE username = ? AND pass = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Login bem-sucedido, redireciona para index.php
        header('Location: ../home/');
        exit();
    } else {
        // Login inválido, exibe uma mensagem de erro
        $mensagemErro = 'Nome de usuário ou senha incorretos.';
    }

    $stmt->close();
}
?>
