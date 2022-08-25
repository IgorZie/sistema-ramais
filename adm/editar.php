<?php
session_start();
require_once('../conexao.php');

$id = $_GET['id'];
$nome = mb_strtoupper($_GET['nome']);
$ramal = $_GET['ramal'];
$unidade = $_GET['unidade'];
$setor = $_GET['setor'];

$selectRamal = " SELECT * FROM usuario WHERE ramal=$ramal;";
$execRamal = mysqli_query($conn, $selectRamal);
if (mysqli_num_rows($execRamal) > 0){
    die(json_encode(["sucess" => false]));
}


$queryUpdate = " UPDATE usuario SET nome='$nome', ramal=$ramal, id_unidade=$unidade, id_setor=$setor, atualizado=NOW() WHERE id=$id";
$execUpdate = mysqli_query($conn, $queryUpdate);

if (mysqli_affected_rows($conn) > 0){
    echo json_encode(['sucess' => true]);
    $_SESSION['atualizado'] = 'Usuário atualizado com sucesso!';
} else {
    echo json_encode(['sucess' => false]);
}