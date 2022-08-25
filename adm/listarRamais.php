<?php
session_start();
require_once('../conexao.php');
$filtro = '';
$querySearch = '';
$ordenacao = " ORDER BY us.nome;";

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
                            <a class="nav-link active" aria-current="page" href="./cadastroForm.php">
                                <span data-feather="play" class="align-text-bottom"></span>
                                Cadastrar Ramal
                            </a>
                            <a class="nav-link active" aria-current="page" href="#">
                                <span data-feather="play" class="align-text-bottom"></span>
                                Listar Ramais
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <!-- Lógica PHP para tratar o input de pesquisa -->
                <?php

                    if(isset($_GET['filtro'])){

                        if (isset($_GET['botao-filtro'])){
                            
                            $ordenacao = '';

                            $filtro = $_GET['filtro'];                            

                            $querySearch =  " WHERE (us.nome LIKE '%$filtro%' OR us.ramal LIKE '%$filtro%' OR u.descricao LIKE '%$filtro%' OR s.descricao LIKE '%$filtro') ORDER BY us.nome;";
                            
                        } else if (isset($_GET['botao-limpar'])){
                            $querySearch = '';
                            header('Location: /adm/listarRamais.php');
                        }

                    }

                ?>

                <!-- Div para alertar o usuário que conseguiu atualizar com sucesso -->
                <?php if (isset($_SESSION['atualizado'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['atualizado'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <!-- Input da pesquisa -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Lista de Ramais</h1>
                    <form action="./listarRamais.php" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="formPesquisa" placeholder="Pesquisar" name="filtro" style="text-transform: uppercase" value="<?= $filtro ?>">
                            <button class="btn btn-outline-primary" data-toggle="popover" title="Pesquisar" type="submit" name="botao-filtro"><span data-feather='search'></span></button>
                            <button class="btn btn-outline-primary" data-toggle="popover" title="Limpar filtro" type="submit" name="botao-limpar"><span data-feather='refresh-ccw'></span></button>
                        </div>
                    </form>
                </div>

                <!-- Tabela/Grid da página -->
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col" class="text-center">Ramal</th>
                            <th scope="col">Unidade</th>
                            <th scope="col">Setor</th>
                            <th scope="col" colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider align-middle">

                        <?php

                        $queryListar = ' SELECT us.id as id, us.nome as nome, us.ramal as ramal, u.descricao as unidade, s.descricao as setor
                                FROM usuario us
                                INNER JOIN unidade u ON u.id=us.id_unidade
                                INNER JOIN setor s ON s.id=us.id_setor ' . $ordenacao . $querySearch;
                                

                        $execQuery = mysqli_query($conn, $queryListar);

                        while ($row = mysqli_fetch_array($execQuery)) {
                            echo "<tr id='tr-" . $row['id'] . "'><th scope='row'>" . $row['nome'] . "</th>"
                                . "<td class='text-center'>" . $row['ramal'] . "</th>"
                                . "<td>" . $row['unidade'] . "</td>"
                                . "<td>" . $row['setor'] . "</td>"
                                . "<td><button id='edit-" . $row['id'] . "' type='button' class='btn btn-primary btn-sm botao-editar' data-bs-toggle='modal' data-bs-target='#editModal'><span data-feather='edit'></span> Editar</button>"
                                . "<td><button id='" . $row['id'] . "' type='button' class='btn btn-danger btn-sm botao-excluir' data-bs-toggle='modal' data-bs-target='#exampleModal'><span data-feather='trash-2'></span> Deletar</button>";
                        } ?>

                    </tbody>
                </table>

            </main>
        </div>
    </div>

    <!-- Modal para confirmar exclusão -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deletar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você tem certeza?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                    <button type="button" class="btn btn-danger" id="btn-modal-sim">Sim</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuário -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form name="edita-usuario" id="form-editar" method="POST">
                        <fieldset>
                            <div class="mb-3">
                                <input type="hidden" class="form-control" id="formId" name="id" minlength="3" required>
                            </div>
                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="formNome" style="text-transform: uppercase" name="nome" minlength="3" required>
                            </div>

                            <div class="mb-3">
                                <label for="formGroupExampleInput" class="form-label">Ramal</label>
                                <input type="text" class="form-control" id="formRamal" name="ramal" maxlength="6" required>
                            </div>

                            <div class="mb-3">
                                <label for="unidade" class="form-label">Unidade</label>
                                <select id="formUnidade" name="unidade" class="form-select" aria-label="Mailing" required>
                                    <option value="" selected>Selecione a unidade</option>
                                    <?php
                                    $unidades = 'SELECT * FROM unidade ORDER BY id';
                                    $queryUnidade = mysqli_query($conn, $unidades);
                                    while ($row = mysqli_fetch_array($queryUnidade)) {
                                        echo "<option value='" . $row['id'] . "'> " . $row['descricao']  . " </option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="setor" class="form-label">Setor</label>
                                <select id="formSetor" name="setor" class="form-select" required>
                                    <option value="" selected>Selecione o setor</option>
                                    <?php
                                    $unidades = 'SELECT * FROM setor ORDER BY descricao;';
                                    $queryUnidade = mysqli_query($conn, $unidades);
                                    while ($row = mysqli_fetch_array($queryUnidade)) {
                                        echo "<option value='" . $row['id'] . "'> " . $row['descricao']  . " </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </fieldset>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="btn-modal-edit">Salvar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>

    <script src="../assets/js/dashboard.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="../assets/js/main.js"></script>

</body>

</html>

<?php
unset($_SESSION['atualizado']);
?>
