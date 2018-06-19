<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 16:13
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

// Recebe o voto do usuário.
$codped=$_POST['codped'];
$codprod=$_POST['codprod'];
$qtde=$_POST['qtde'];
//$valor=$_POST['valor'];

$con = $pdo->query("select * from produtos where codigo=$codprod");
$prod = $con->fetch(PDO::FETCH_ASSOC);
$valor=$prod['valor'];
$estoque=$prod['estoque'];
$estoquemin=$prod['estoquemin'];

# INSERT INTO `vendas`.`itens` (`pedido`, `codprod`, `valor`, `qtde`) VALUES ('0', '0', '0', '');

$consulta = $pdo->prepare("insert into itens(pedido,codprod,valor,qtde) values(:codped, :codprod, :valor, :qtde)");
$consulta->bindParam(':codped', $codped);
$consulta->bindParam(':codprod', $codprod);
$consulta->bindParam(':valor', $valor);
$consulta->bindParam(':qtde', $qtde);

if($consulta->execute()){
    $estoqueatu=$estoque-$qtde;

    $altest = $pdo->prepare("update produtos set estoque=:estoque where codigo=$codprod");
    $altest->bindValue(':estoque', $estoqueatu);
    $altest->execute();

    echo "<h1>Produto cadastrado. Obrigado!</h1><p>";

    if ($estoque<=$estoquemin) {
        echo "<h1>Atenção o produto atingiu o estoque mínimo!Estoque atual: $estoqueatu</h1><p>";
        rodape();

//        header("Refresh: 3; url=index.php?codped=$codped");
        echo "<script>location.replace(\"index.php?codped={$codped}\"); </script>";
        exit();
    }

//    header("Location: index.php?codped=$codped");
    echo "<script>location.replace(\"index.php?codped={$codped}\"); </script>";
} else {
    echo "<h1>Erro ao cadastrar o produto.</h1>";
}

rodape();
