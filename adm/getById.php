<?php
require_once('../conexao.php');

$id = str_replace('edit-', '', $_GET['userId']);

$queryBusca = " SELECT * FROM usuario WHERE id=$id";
$execQuery = mysqli_query($conn, $queryBusca);

while($row = mysqli_fetch_array($execQuery)){
    $nome = $row['nome'];
    $ramal = $row['ramal'];
    $unidade = $row['id_unidade'];
    $setor = $row['id_setor'];
}

if (mysqli_num_rows($execQuery) > 0){

    echo json_encode(['sucess' => true, 'id' => $id, 'nome' => $nome, 'ramal' => $ramal, 'unidade' => $unidade, 'setor' => $setor]);

} else {

    echo json_encode(['sucess' => false]);
}
