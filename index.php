
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">

    <title>login</title>
</head>

<body>
    <div class="container">
        <div class="login-form">
            <h3>Receita Online <span>.</span></h3>

            <!-- Adicione o formulário abaixo -->
            <form action="pages/php/login.php" method="post">
                <?php if (isset($mensagemErro)) : ?>
                    <p style="color: red;"><?= $mensagemErro; ?></p>
                <?php endif; ?>
                <input type="text" name="user" placeholder="username" required><br>
                <input type="password" name="password" placeholder="password" required><br>
                <button type="submit">Login</button>
            </form>
            <!-- Fim do formulário -->
        </div>
    </div>
</body>

</html>