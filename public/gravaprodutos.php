<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 14:30
 * Description: grava os novos produtos na base
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

$descricao=$_POST['txtdescricao'];
$valor=$_POST['txtvalor'];
$estoque=$_POST['txtestoque'];
$estoquemin=$_POST['txtestoquemin'];

if ($descricao==""){
    echo "<h2>Campo <b>descrição</b> em branco!</h2><p>";
    echo "<input type=\"button\" value=\"Voltar\" onClick=\"javascript:history.back()\">";

    rodape();
    exit();
}

if ($valor==""){
    echo "<h2>Campo <b>valor</b> em branco!</h2><p>";
    echo "<input type=\"button\" value=\"Voltar\" onClick=\"javascript:history.back()\">";

    rodape();
    exit();
}

$insert = $pdo->prepare("insert into produtos values(:codigo,:descricao,:valor,:estoque,:estoquemin)");
$insert->bindValue(':codigo', 0);
$insert->bindValue(':descricao', "$descricao");
$insert->bindValue(':valor', "$valor");
$insert->bindValue(':estoque', "$estoque");
$insert->bindValue(':estoquemin', "$estoquemin");

if($insert->execute()){
    // header("Location: cadproduto.php");
    echo "<h1>Produto cadastrado!</h1>";
    header("Refresh: 2; URL=cadproduto.php");
}
else{
    echo "<h1>Erro ao cadastrar.</h1>";
}

rodape();
