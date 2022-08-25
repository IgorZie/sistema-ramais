<?php
session_start();
require_once('../conexao.php');

// Verifica se o usuário está em sessão
if (!isset($_SESSION['user'])) {
    die('Você não tem permissão para acessar essa página');
}

?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Igor Zielosko">
    <link rel="shortcut icon" href="https://www.prorim.org.br/wp-content/uploads/sites/4/2017/06/favicon.png" type="image/x-icon">
    <title>Pró Rim - Agenda ADM</title>

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
    <link href="../assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

    <!-- Cabeçalho da página -->
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="./index.php">Pró Rim</a>

        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="#">
                    <span data-feather="user"></span>
                </a>
            </div>
        </div>
    </header>

    <!-- Barra de navegação da página -->
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                <span data-feather="play" class="align-text-bottom"></span>
                                Cadastrar Ramal
                            </a>
                            <a class="nav-link active" aria-current="page" href="./listarRamais.php">
                                <span data-feather="play" class="align-text-bottom"></span>
                                Listar Ramais
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <!-- Alerta se deu sucesso no cadastro -->
                <?php if (isset($_SESSION['cadastro'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['cadastro'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Alerta se deu erro no cadastro -->
                <?php if (isset($_SESSION['cadastro_error'])) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['cadastro_error'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Cadastrar Ramal</h1>
                </div>

                <!-- Formulário do cadastro -->
                <form name="cadastra-ramal" method="POST" action="./cadastrar.php">
                    <fieldset>
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" style="text-transform: uppercase" name="nome" minlength="3" required>
                        </div>

                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Ramal</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" name="ramal" maxlength="6" required>
                        </div>

                        <div class="mb-3">
                            <label for="unidade" class="form-label">Unidade</label>
                            <select id="unidade" name="unidade" class="form-select" required>
                                <option value="" selected>Selecione a unidade</option>
                                <?php
                                $unidades = 'SELECT * FROM unidade ORDER BY descricao';
                                $queryUnidade = mysqli_query($conn, $unidades);
                                while ($row = mysqli_fetch_array($queryUnidade)) {
                                    echo "<option value='". $row['id']."'> " . $row['descricao']  . " </option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="unidade" class="form-label">Setor</label>
                            <select id="setor" name="setor" class="form-select" required>
                                <option value="" selected>Selecione o setor</option>
                                <?php
                                $setores = 'SELECT * FROM setor ORDER BY descricao';
                                $querySetores = mysqli_query($conn, $setores);
                                while ($row = mysqli_fetch_array($querySetores)) {
                                    echo "<option value='". $row['id']."'> " . $row['descricao']  . " </option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <button id="btn-salvar" type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </fieldset>
                </form>

            </main>
        </div>
    </div>


    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>

    <script src="../assets/js/dashboard.js"></script>

    <script src="../assets/js/main.js"></script>
</body>

</html>

<?php

unset($_SESSION['cadastro']);
unset($_SESSION['cadastro_error']);

?>