<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 15:07
 */

//Importa a conexão do banco.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

// Reseta todas as variáveis de sessão.
session_start();
session_unset();
session_destroy();

// Obtém o logon e a senha
$login = $_POST['txtlogin'];
$senha = $_POST['txtsenha'];

// Criptografa a senha do usuário.
$senha = md5($senha);

$consulta = $pdo->prepare("select * from usuarios where usuarios.usulogin=:login and usuarios.ususenha=:senha");
$consulta->bindValue(':login', $login);
$consulta->bindValue(':senha', $senha);
$consulta->execute();

$linha = $consulta->fetch(PDO::FETCH_ASSOC);

// Se não houve retorno de valores é redirecionado para a tela de login.
if ($linha['usucod'] == ""){
    header("Location: login.php?erro=invalido");
    exit();
}

// Inicia a sessão e registra as variávies na mesma.
session_start();

$_SESSION['usucod']=$linha['usucod'];
$_SESSION['usulogin']=$linha['usulogin'];
$_SESSION['usunome']=$linha['usunome'];
$_SESSION['ususenha']=$linha['ususenha'];

// Redireciona para a tela de apuração.
header("Location: inicio.php");
exit();