<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Menu Horizontal */
        ul {
            list-style: none;
            background-color: #000;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: #FFFF00;;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover {
            background-color: #111;
        }

        /* Menu Lateral Responsivo */
        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: -200px;
            background-color: #FFFF00;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidebar a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
        }

        .sidebar .close-btn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        .open-btn {
            font-size: 20px;
            cursor: pointer;
            background-color: #333;
            color: white;
            padding: 10px 15px;
            border: none;
        }

        .open-btn:hover {
            background-color: #444;
        }

        .content {
            margin-left: 200px;
            transition: margin-left 0.5s;
            padding: 16px;
        }
    </style>
</head>

<body>

    <!-- Menu Horizontal -->
    <ul>
       <li><a href="/metodista/pages/home/">Home</a></li> 
        <li><a href="/metodista/pages/php/receitas.php">Gerir Receita</a></li>
        <li><a href="/metodista/pages/php/index.php">Gerir Paciente</a></li>
        <li><a href="/metodista/pages/php/medico.php">Gerir Médico</a></li>
        <li><a href="/metodista/pages/home/logout.php">Sair</a> </li>
    </ul>

    <!-- Menu Lateral Responsivo -->
    <div class="sidebar" id="sidebar">
        <button class="open-btn" onclick="toggleSidebar()">☰ Open Sidebar</button>
        <a href="pages/php/receitas.php" >Gerir Receita</a>
        <a href="#" onclick="toggleSidebar()">Gerir Paciente</a>
        <a href="#" onclick="toggleSidebar()">Gerir Médico</a>
        <button class="close-btn" onclick="toggleSidebar()">×</button>
    </div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            if (sidebar.style.left === '0px') {
                sidebar.style.left = '-200px';
            } else {
                sidebar.style.left = '0px';
            }
        }
    </script>

</body>

</html>