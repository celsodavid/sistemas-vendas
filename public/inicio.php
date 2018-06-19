<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 15:09
 */

//Importa a conexão do banco.
require "config.php";

//Importa as funções cabecalho e rodape.
require "funcoes.php";

acesso();
cabecalho();

echo "<h1>Área Administrativa</h1>";
echo "<h2>Use o botão (Sair) para encerrar a sessão após o uso.</h2>";

rodape();
