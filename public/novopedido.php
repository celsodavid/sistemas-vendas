<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 17:37
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

$insert = $pdo->prepare("insert into pedidos values(:codigo,:total,:valor,:troco)");

$insert->bindValue(':codigo', 0);
$insert->bindValue(':total', 0.0);
$insert->bindValue(':valor', 0.0);
$insert->bindValue(':troco', 0.0);
if ($insert->execute()) {
    $stmt = $pdo->query("select codped from pedidos where total = 0 and dinheiro = 0 and troco = 0 order by codped asc limit 1");
    $codped = (int) $stmt->fetch(PDO::FETCH_COLUMN);

    //exit(header("Location: index.php?codped=$codped"));
    echo "<script>location.replace(\"index.php?codped={$codped}\"); </script>";
}
else {
    echo "<h1>Erro ao cadastrar.</h1>";
}

rodape();
