<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 16:18
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

$codped=$_POST['codped'];
$total=$_POST['total'];
$dinheiro=$_POST['dinheiro'];

$troco=$dinheiro-$total;

# UPDATE `vendas`.`pedidos` SET `total`='0', `dinheiro`='50.0', `troco`='50.0' WHERE `codped`='1';
$upd = $pdo->query("update pedidos set total=$total, dinheiro=$dinheiro, troco=$troco where codped=$codped");
if ($upd->execute()){
    echo "<script>location.replace(\"index.php?codped={$codped}\"); </script>";
//    header("Location: index.php?codped=$codped");
} else {
    echo "<h1>Erro ao fazer o troco.</h1>";
}

rodape();
