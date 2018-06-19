<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 13:35
 * Description: Arquivo responsavel por gravar o usuario na base
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

$nome = $_POST['txtnome'];
$login = $_POST['txtlogin'];
$senha = $_POST['txtsenha'];
$senha = md5($senha);

if ($nome == "") {
    echo "<h2>Campo <b>nome</b> em branco!</h2><p>";
    echo "<input type=\"button\" value=\"Voltar\" onClick=\"javascript:history.back()\">";

    rodape();
    exit();
}

if ($login == "") {
    echo "<h2>Campo <b>login</b> em branco!</h2><p>";
    echo "<input type=\"button\" value=\"Voltar\" onClick=\"javascript:history.back()\">";

    rodape();
    exit();
}

if ($senha == "") {
    echo "<h2>Campo <b>senha</b> em branco!</h2><p>";
    echo "<input type=\"button\" value=\"Voltar\" onClick=\"javascript:history.back()\">";

    rodape();
    exit();
}

// Comando SQL que inseri na tabela usuarios.
$insert = $pdo->prepare("insert into usuarios values(:codigo,:nome,:login,:senha)");
$insert->bindValue(':codigo', 0);
$insert->bindValue(':nome', $nome);
$insert->bindValue(':login', $login);
$insert->bindValue(':senha', $senha);

if ($insert->execute()) {
    echo "<h1>Usuário cadastrado!</h1>";
    header("Refresh: 2; URL=cadusuario.php");
}
else {
    echo "<h1>Erro ao cadastrar.</h1>";
}

rodape();
