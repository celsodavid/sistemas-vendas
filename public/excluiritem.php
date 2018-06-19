<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 16:17
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

$coditem=$_GET['coditem'];
$codped=$_GET['codped'];

$delete = $pdo->query("delete from itens where coditem=$coditem");
if ($delete->execute()){
    $conped = $pdo->query("select sum(itens.qtde*itens.valor) as total, pedidos.dinheiro, pedidos.troco from pedidos, itens where pedidos.codped=$codped and pedidos.codped=itens.pedido");
    $pedido = $conped->fetch(PDO::FETCH_ASSOC);

    $troco=$pedido['dinheiro']-$pedido['total'];
    $total = $pedido['total'];
    $dinheiro = $pedido['dinheiro'];

    if ($total==""){
        $total=0;
    }

    if ($dinheiro==""){
        $dinheiro=0;
    }

    $upd = $pdo->query("update pedidos set total=$total, dinheiro=$dinheiro, troco=$troco where codped=$codped");
    $upd->execute();

    header("Location: index.php?codped=$codped");
} else {
    echo "<h1>Erro ao excluir o produto.</h1>";
}

rodape();
