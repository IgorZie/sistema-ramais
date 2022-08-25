<?php

session_start();
require_once('./conexao.php');
$filtro = '';
$tipo = 'qualquer';
$querySearch = '';
$ordenacao = " ORDER BY us.nome;";

?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Igor Zielosko">
    <link rel="shortcut icon" href="https://www.prorim.org.br/wp-content/uploads/sites/4/2017/06/favicon.png" type="image/x-icon">
    <title>Pró Rim - Ramais</title>

    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">

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
    <link href="./assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

    <!-- Cabeçalho da página -->
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6">Pró Rim</a>

        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3">
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
                            <a class="nav-link active" aria-current="page">
                                <span data-feather="play" class="align-text-bottom"></span>
                                Ramais
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Lista de Ramais</h1>                    
                </div>

                <!-- Tabela/Grid da página -->
                <table class="table table-hover table-striped" id="tabela-ramais">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col" class="text-center">Ramal</th>
                            <th scope="col">Unidade</th>
                            <th scope="col">Setor</th>
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
                                . "<td>" . $row['setor'] . "</td>";
                        } ?>

                    </tbody>
                </table>

            </main>
        </div>
    </div>

    <script src="./assets/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>

    <script src="./assets/js/dashboard.js"></script>

    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>


    <script>
        $(document).ready(function() {
            $('#tabela-ramais').DataTable({
                language: {
                    "emptyTable": "Não foi encontrado nenhum registo",
                    "loadingRecords": "A carregar...",
                    "processing": "A processar...",
                    "lengthMenu": "Mostrar _MENU_ registos",
                    "zeroRecords": "Não foram encontrados resultados",
                    "search": "Procurar:",
                    "paginate": {
                        "first": "Primeiro",
                        "previous": "Anterior",
                        "next": "Seguinte",
                        "last": "Último"
                    },
                    "aria": {
                        "sortAscending": ": Ordenar colunas de forma ascendente",
                        "sortDescending": ": Ordenar colunas de forma descendente"
                    },
                    "autoFill": {
                        "cancel": "cancelar",
                        "fill": "preencher",
                        "fillHorizontal": "preencher células na horizontal",
                        "fillVertical": "preencher células na vertical"
                    },
                    "buttons": {
                        "collection": "Coleção",
                        "colvis": "Visibilidade de colunas",
                        "colvisRestore": "Restaurar visibilidade",
                        "copy": "Copiar",
                        "copySuccess": {
                            "1": "Uma linha copiada para a área de transferência",
                            "_": "%ds linhas copiadas para a área de transferência"
                        },
                        "copyTitle": "Copiar para a área de transferência",
                        "csv": "CSV",
                        "excel": "Excel",
                        "pageLength": {
                            "-1": "Mostrar todas as linhas",
                            "_": "Mostrar %d linhas"
                        },
                        "pdf": "PDF",
                        "print": "Imprimir",
                        "copyKeys": "Pressionar CTRL ou u2318 + C para copiar a informação para a área de transferência. Para cancelar, clique nesta mensagem ou pressione ESC.",
                        "createState": "Criar",
                        "removeAllStates": "Remover Todos",
                        "removeState": "Remover",
                        "renameState": "Renomear",
                        "savedStates": "Gravados",
                        "stateRestore": "Estado %d",
                        "updateState": "Atualizar"
                    },
                    "decimal": ",",
                    "infoFiltered": "(filtrado no total de _MAX_ registos)",
                    "infoThousands": ".",
                    "searchBuilder": {
                        "add": "Adicionar condição",
                        "button": {
                            "0": "Construtor de pesquisa",
                            "_": "Construtor de pesquisa (%d)"
                        },
                        "clearAll": "Limpar tudo",
                        "condition": "Condição",
                        "conditions": {
                            "date": {
                                "after": "Depois",
                                "before": "Antes",
                                "between": "Entre",
                                "empty": "Vazio",
                                "equals": "Igual",
                                "not": "Diferente",
                                "notBetween": "Não está entre",
                                "notEmpty": "Não está vazio"
                            },
                            "number": {
                                "between": "Entre",
                                "empty": "Vazio",
                                "equals": "Igual",
                                "gt": "Maior que",
                                "gte": "Maior ou igual a",
                                "lt": "Menor que",
                                "lte": "Menor ou igual a",
                                "not": "Diferente",
                                "notBetween": "Não está entre",
                                "notEmpty": "Não está vazio"
                            },
                            "string": {
                                "contains": "Contém",
                                "empty": "Vazio",
                                "endsWith": "Termina em",
                                "equals": "Igual",
                                "not": "Diferente",
                                "notEmpty": "Não está vazio",
                                "startsWith": "Começa em",
                                "notContains": "Não contém",
                                "notStarts": "Não começa com",
                                "notEnds": "Não termina com"
                            },
                            "array": {
                                "equals": "Igual",
                                "empty": "Vazio",
                                "contains": "Contém",
                                "not": "Diferente",
                                "notEmpty": "Não está vazio",
                                "without": "Sem"
                            }
                        },
                        "data": "Dados",
                        "deleteTitle": "Excluir condição de filtragem",
                        "logicAnd": "E",
                        "logicOr": "Ou",
                        "title": {
                            "0": "Construtor de pesquisa",
                            "_": "Construtor de pesquisa (%d)"
                        },
                        "value": "Valor",
                        "leftTitle": "Excluir critério",
                        "rightTitle": "Incluir critério"
                    },
                    "searchPanes": {
                        "clearMessage": "Limpar tudo",
                        "collapse": {
                            "0": "Painéis de pesquisa",
                            "_": "Painéis de pesquisa (%d)"
                        },
                        "count": "{total}",
                        "countFiltered": "{shown} ({total})",
                        "emptyPanes": "Sem painéis de pesquisa",
                        "loadMessage": "A carregar painéis de pesquisa",
                        "title": "Filtros ativos",
                        "showMessage": "Mostrar todos",
                        "collapseMessage": "Ocultar Todos"
                    },
                    "select": {
                        "cells": {
                            "1": "1 célula seleccionada",
                            "_": "%d células seleccionadas"
                        },
                        "columns": {
                            "1": "1 coluna seleccionada",
                            "_": "%d colunas seleccionadas"
                        },
                        "rows": {
                            "1": "%d linha seleccionada",
                            "_": "%d linhas seleccionadas"
                        }
                    },
                    "thousands": ".",
                    "editor": {
                        "close": "Fechar",
                        "create": {
                            "button": "Novo",
                            "title": "Criar novo registro",
                            "submit": "Criar"
                        },
                        "edit": {
                            "button": "Editar",
                            "title": "Editar registro",
                            "submit": "Atualizar"
                        },
                        "remove": {
                            "button": "Remover",
                            "title": "Remover",
                            "submit": "Remover",
                            "confirm": {
                                "_": "Tem certeza que quer apagar %d entradas?",
                                "1": "Tem certeza que quer apagar esta entrada?"
                            }
                        },
                        "multi": {
                            "title": "Multiplos valores",
                            "restore": "Desfazer alterações",
                            "info": "Os itens selecionados contêm valores diferentes para esta entrada. Para editar e definir todos os itens nesta entrada com o mesmo valor, clique ou toque aqui, caso contrário, eles manterão os seus valores individuais.",
                            "noMulti": "Este campo pode ser editado individualmente mas não pode ser editado em grupo"
                        },
                        "error": {
                            "system": "Ocorreu um erro no sistema"
                        }
                    },
                    "info": "Mostrando os registos _START_ a _END_ no total de _TOTAL_",
                    "infoEmpty": "Mostrando 0 os registos no total de 0",
                    "datetime": {
                        "previous": "anterior",
                        "next": "próximo",
                        "hours": "horas",
                        "minutes": "minutos",
                        "seconds": "segundos",
                        "unknown": "desconhecido",
                        "amPm": [
                            "am",
                            "pm"
                        ],
                        "weekdays": [
                            "Seg",
                            "Ter",
                            "Qua",
                            "Qui",
                            "Sex",
                            "Sáb",
                            "Dom"
                        ],
                        "months": [
                            "Janeiro",
                            "Fevereiro",
                            "Março",
                            "Abril",
                            "Maio",
                            "Junho",
                            "Julho",
                            "Agosto",
                            "Setembro",
                            "Outubro",
                            "Novembro",
                            "Dezembro"
                        ]
                    },
                    "stateRestore": {
                        "creationModal": {
                            "button": "Criar",
                            "columns": {
                                "search": "Pesquisa por Colunas",
                                "visible": "Visibilidade das Colunas"
                            },
                            "name": "Nome:",
                            "order": "Ordenar",
                            "paging": "Paginação",
                            "scroller": "Posição da barra de Scroll",
                            "search": "Pesquisa",
                            "searchBuilder": "Pesquisa Avançada",
                            "select": "Selecionar",
                            "title": "Criar Novo Estado",
                            "toggleLabel": "Incluir:"
                        },
                        "duplicateError": "Já existe um estado com o mesmo nome",
                        "emptyError": "Não pode estar a vazio",
                        "emptyStates": "Não existem estados gravados",
                        "removeConfirm": "Deseja mesmo remover o estado %s?",
                        "removeError": "Erro ao remover o estado.",
                        "removeJoiner": " e ",
                        "removeSubmit": "Apagar",
                        "removeTitle": "Apagar Estado",
                        "renameButton": "Renomear",
                        "renameLabel": "Novo nome para %s:",
                        "renameTitle": "Renomear Estado"
                    }
                }
            });
        });
    </script>
</body>

</html>