<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 14:50
 * Description: grava a atualizacao dos produtos na base
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

$codigo=$_POST['txtcodigo'];
$descricao=$_POST['txtdescricao'];
$valor=$_POST['txtvalor'];
$estoque=$_POST['txtestoque'];
$estoquemin=$_POST['txtestoquemin'];

$upd = $pdo->prepare("update produtos set descricao=:descricao, valor=:valor, estoque=:estoque, estoquemin=:estoquemin where codigo=:codigo");

$upd->bindValue(':codigo', $codigo);
$upd->bindValue(':descricao', "$descricao");
$upd->bindValue(':valor', "$valor");
$upd->bindValue(':estoque', "$estoque");
$upd->bindValue(':estoquemin', "$estoquemin");

if($upd->execute()){
    header("Location: cadproduto.php");
}else{
    echo "<h1>Erro ao alterar o produto.</h1>";
}

rodape();
