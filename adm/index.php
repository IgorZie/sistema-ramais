<?php
session_start();

define('USER', 'adm');
define('PASSWORD', 'prorim@2022');

// Seta e verifica o Login e Senha
if (isset($_POST['username']) && isset($_POST['senha'])) {

    $login = $_POST['username'];
    $senha = $_POST['senha'];

    if ($login == USER && $senha == PASSWORD) {
        $_SESSION['user'] = 'adm';
        header("Location: ./cadastroForm.php");
        exit;
    } else {
        $_SESSION['login_error'] = 'Usuário/Senha inválido';
        header('Location: ./index.php');
        exit;
    }
}

?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Igor Zielosko">
    <link rel="shortcut icon" href="https://www.prorim.org.br/wp-content/uploads/sites/4/2017/06/favicon.png" type="image/x-icon">
    <title>Pró-Rim Agenda/Login</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">



    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="../assets/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">
        
    <!-- Alerta para caso o login e senha estiverem errado -->
        <?php if (isset($_SESSION['login_error'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['login_error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" disabled aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Formulário dos inputs login e senha -->
        <form name='login' method="POST" action="./index.php">
            <h1 class="h3 mb-3 fw-normal">Pró-Rim</h1>

            <div class="form-floating">
                <input type="text" class="form-control mb-3" id="floatingInput" name='username' placeholder="Username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="floatingPassword" name='senha' placeholder="Senha" required>
                <label for="floatingPassword">Senha</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
        </form>
    </main>



</body>

</html>

<?php

unset($_SESSION['login_sucess']);
unset($_SESSION['login_error']);

?>