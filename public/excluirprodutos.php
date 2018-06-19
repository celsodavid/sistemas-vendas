<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 14:52
 * Description: exclui um produto na base
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

$codigo=$_GET['codigo'];

$delete = $pdo->prepare("delete from produtos codigo=:codigo");
$delete->bindValue(':codigo', $codigo);

if ($delete->execute()){
    header("Location: cadproduto.php");
}else{
    echo "<h1>Erro ao excluir o produto.</h1>";
}

rodape();
