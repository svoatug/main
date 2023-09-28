<?php

require_once("Connection.php");

$conn = Connection::getConnection();

//$sql = "SELECT id, nome, cidade FROM times";
$sql = "SELECT * FROM produto";
$stm = $conn->prepare($sql);
$stm->execute();

$result = $stm->fetchAll();
//echo "<pre>" . print_r($result, true) . "</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Times</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>Nome</th>
            <th>Origem</th>
            <th>Quantidade</th>
            <th>Marca</th>
            <th>Preco</th>
            <th></th>
        </tr>
        <?php foreach($result as $r): ?>
            <tr>
                <td><?= $r['nome'] ?></td>
                <td><?php 
                    switch($r['origem']) {
                        case 'PR':
                            echo 'Paraná';
                            break;
                        
                        case 'SP':
                            echo 'São Paulo';
                            break;

                        case 'MG':
                            echo 'Minas Gerais';
                            break;

                        case 'O':
                            echo 'Outro';
                            break;

                        default:
                            echo $l['não informado'];
                    } 
                ?></td>
                <td><?= $r['qtd_prod'] ?></td>
                <td><?= $r['marca'] ?></td>
                <td><?= $r['preco'] ?></td>
                <td><a 
                    href="time_excluir.php?id=<?= $r["id"] ?>"
                    onclick="return confirm('Confirma a exclusão?');"
                    >Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>