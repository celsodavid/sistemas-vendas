<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 13:49
 * Description: Altera os usuario (UPDT)
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

$codigo=$_POST['txtcodigo'];
$nome=$_POST['txtnome'];
$login=$_POST['txtlogin'];
$senha=$_POST['txtsenha'];
$senha=md5($senha);

$sql="update usuarios set usunome=:nome, usulogin=:login, ususenha=:senha where usucod=:codigo";
$update = $pdo->prepare($sql);
$update->bindValue(':codigo', $codigo);
$update->bindValue(':nome', $nome);
$update->bindValue(':login', $login);
$update->bindValue(':senha', $senha);
if ($update->execute()) {
    echo "<h1>Usuário alterado!</h1>";
    header("Refresh: 2; URL=cadusuario.php");
}
else {
    echo "<h1>Erro ao alterar o usuário.</h1>";
}

rodape();
