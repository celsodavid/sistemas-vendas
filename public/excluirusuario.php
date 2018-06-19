<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 13:57
 * Description: Arquivo responsavel por excluir o usuario da base
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

$codigo=$_GET['codigo'];

$delete = $pdo->prepare("delete from usuarios usucod= :codigo");
$delete->bindValue(':codigo', $codigo);
if ($delete->execute()) {
    echo "<h1>Usuário excluído! Aguarde...</h1>";
    header("Refresh: 2; URL=cadusuario.php");
}
else {
    echo "<h1>Erro ao excluir.</h1>";
}

rodape();
