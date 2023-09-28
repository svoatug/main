<?php
include_once("Connection.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inicialize as variáveis antes da validação
$nome = "";
$origem = "";
$qtd_prod = "";
$marca = "";
$preco = "";
$msgErro = ""; // Inicialize a variável de erro

if(isset($_POST['submetido'])) {
    $nome = $_POST['nome'];
    $origem = $_POST['origem'];
    $qtd_prod = $_POST['qtd_prod'];
    $marca = $_POST['marca'];
    $preco = $_POST['preco'];

    $erros = array();
    
    //Valida campos obrigatórios
    if(! trim($nome))
        array_push($erros, "Informe o nome do produto!");

    if(! trim($origem))
        array_push($erros, "Informe o estado de origem do produto!");

    if(! $qtd_prod)
        array_push($erros, "Informe a quantidade no estoque!");
    
    if(! trim($marca))
        array_push($erros, "Informe a marca!");

    if(! trim($preco))
        array_push($erros, "Informe o preco!");    

    if(!$erros) { //Apenas se validou os campos obrigatórios
        //Valida se a quantidade é maior que 0
        if($qtd_prod <= 0)
            array_push($erros, "A quantidade de produtos deve ser maior que zero!");

        //Valida se o nome tem entre 3 e 50 caracteres
        if(strlen($nome) < 3 || strlen($nome) > 50)
            array_push($erros, "O nome deve ter entre 3 e 50 caracteres!");

        if($preco <= 0)
            array_push($erros, "O preco deve ser maior que 0!");    

        
    }

    if(!$erros) { //Apenas se passou por todas as validações
        $id = vsprintf( '%s%s-%s-%s-%s-%s%s%s',
                str_split(bin2hex(random_bytes(16)), 4) );

        //Pega a conexão com a base de dados e cria a statement para inserir o time
        $conn = Connection::getConnection();

        $sql = "INSERT INTO produto (id, nome, origem, qtd_prod, marca, preco ) VALUES (?, ?, ?, ?, ?, ?)";
        $stm = $conn->prepare($sql);
        $stm->execute([$id, $nome, $origem, $qtd_prod, $marca, $preco]);

        //Mensagem para exibir que o time foi inserido
        echo "Produto inserido no banco de dados!";

        //Redireciona para o menu
        header("location: produto_listar.php");
    
    } else {
        //Seta as mensagens do array de erro para a variável $msgErro
        $msgErro = implode("<br>", $erros);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
</head>
<body>

    <h1>Cadastro de produtos</h1>

    <h3>Formulário de produtos</h3>
    <form action="" method="POST">
        <input type="text" name="nome" 
            placeholder="Informe o nome"
            value="<?= $nome ?>" />
        
        <br><br>

        <select name="origem">
            <option value="">---Selecione a origem---</option>
            <option value="PR" <?php if($origem == 'PR') echo 'selected'; ?>
                >Paraná</option>
            <option value="SP" <?php echo ($origem == 'SP' ? 'selected' : '') ?>
                >São Paulo</option>
            <option value="MG" <?php echo ($origem == 'MG' ? 'selected' : '') ?>
                >Minas Gerais</option>
            <option value="O" <?php echo ($origem == 'O' ? 'selected' : '') ?>
                >Outro</option>
        </select>

        <br><br>

        <input type="number" name="qtd_prod" 
            placeholder="Informe a quantidade no estoque"
            value="<?= $qtd_prod ?>" />

        <br><br>

        <input type="text" name="marca" 
            placeholder="Informe o marca"
            value="<?= $marca ?>" />

        <br><br>

        <input type="number" name="preco" 
            placeholder="Informe o preco"
            value="<?= $preco ?>" />

        <input type="hidden" name="submetido" value="1" />

        <button type="submit">Gravar</button>
        <button type="reset">Limpar</button>
    </form>

    <br> <br>
    <div>
    <a href='produto_listar.php'>listar produtos</a>
    </div>

    <div style="color: red;">
        <?= $msgErro ?>
    </div>

   
    
</body>
</html>