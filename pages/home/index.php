<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receita Médica</title>
    <!-- Adicione os links para os arquivos CSS do Bootstrap -->

    <style>
        body {
            padding-top: 56px;
            /* Adiciona espaço para o navbar fixo no topo */
        }

        .navbar-brand img {
            max-height: 40px;
            margin-right: 10px;
        }

        .sidebar {
            height: 100vh;
            position: fixed;


            /* Ajusta a altura do menu lateral para evitar sobreposição com o navbar */
        }

        .main-content {
            margin-left: 220px;
            /* Ajusta a margem esquerda para evitar sobreposição com o menu lateral */
        }

        .subtopic {
            margin-top: 20px;
        }
    </style>
    <link rel="stylesheet" href="../../assets/css/style.css">



</head>

<body>

<div class="lateral">
            <?php

    require_once 'menulateral.php';
    ?>
            </div>
       
            <!-- Conteúdo Principal -->

        </div>
        <div class="clinica">
        <h2>Receitas <span>Oline</span>.</h2>
        </div>
        <div class="imagem-principal">
                <img src="../../assets/img/sangue.jpg" alt="" srcset="">
            </div>
    </div>

    <!-- Adicione os scripts do Bootstrap e jQuery no final do corpo do documento -->


</body>

</html>