<?php
session_start();
require_once('../conexao.php');

$nome = mb_strtoupper($_POST['nome']);
$ramal = $_POST['ramal'];
$setor = $_POST['setor'];
$unidade = $_POST['unidade'];

$checkRamal = " SELECT ramal FROM usuario WHERE ramal = $ramal";
$execQueryCheck = mysqli_query($conn, $checkRamal);

// Verifica se já tem usuário com o mesmo ramal
if (mysqli_num_rows($execQueryCheck) > 0){
    $_SESSION['cadastro_error'] = 'Ramal já cadastrado';
    header('Location: ./cadastroForm.php');
    exit;
}

// Insere no banco os dados e retorna para a página de cadastro
$SQL = " INSERT INTO usuario (nome, ramal, id_unidade, id_setor, criado) VALUES ('$nome', '$ramal', '$unidade', '$setor', NOW());";
$query = mysqli_query($conn, $SQL);

if ($query){
    $_SESSION['cadastro'] = 'Cadastrado com sucesso';
    header('Location: ./cadastroForm.php');
    exit;
}