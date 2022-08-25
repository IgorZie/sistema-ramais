<?php
require_once('../conexao.php');

if(isset($_GET['userId'])){

    $userId = $_GET['userId'];

    $queryDeletar = " DELETE FROM usuario WHERE id=$userId;";
    $execQuery = mysqli_query($conn, $queryDeletar);

    if(mysqli_affected_rows($conn) > 0){
        echo json_encode(['sucess' => true]);
    } else {
        echo json_encode(['sucess' => false]);
    }

}