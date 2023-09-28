<?php

require_once("Connection.php");

//Capturando e validando o ID para exclusão
$id = 0;
if(isset($_GET['id']))
    $id = $_GET['id'];

if(! $id) {
    echo "ID inválido!<br>";
    echo "<a href='produto_listar.php'>Voltar</a>";
    exit;
}

//Executar a exclusão no banco de dados
$conn = Connection::getConnection();

$sql = "DELETE FROM produto WHERE id = ?";
$stm = $conn->prepare($sql);
$stm->execute([$id]);

header("location: produto_listar.php");

