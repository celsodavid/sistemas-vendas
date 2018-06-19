<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 13:17
 * Description: Arquivo responsavel pelo cadastro do produto
 */

//Importa a conexão do banco.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
acesso();
cabecalho();

// Obtém a variável erro, responsável por mostrar as mensagens abaixo depois de sair do sistema.
$erro = (isset($_GET['erro'])) ? $_GET['erro'] : "";

if ($erro == "logout") {
    session_start();
    session_destroy();
    echo "<div class=\"erro\">Sessão encerrada!</div>";
}

// Monta o formulário para o cadastro.
echo sprintf(
    '<p><br>
                <form action="%s" method="post" name="f1" id="f1">
                    <p><label> Nome: <input type="text" name="txtnome" size="50" maxlength="100"></label></p>
                    <p><label>Login: <input type="text" name="txtlogin" size="50" maxlength="100"></label></p>
                    <p><label>Senha: <input type="password" name="txtsenha" size="50" maxlength="100"></label></p>
                    <p>
                        <input type="submit" value="Gravar">
                        <input type="reset" value="Limpar">
                    </p>
                </form>
           </p>
           <script> document.furna.txtnome.focus();</script>
           ',
    'gravausuario.php'
);

// Seleciona todos os usuários cadastrados ordenado por código
$consulta = $pdo->prepare("SELECT * FROM usuarios order by usucod");
$consulta->execute();

$format = '<table width="100%">';
$format .= '<tr bgcolor="#eb0">
              <td>CÓDIGO</td>
              <td>NOME</td>
              <td>LOGIN</td>
              <td>Alterar</td>
              <td>Excluir</td>
           </tr>';

while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
    $format .= "<tr>";
    $format .= "<td>{$row['usucod']}</td>";
    $format .= "<td>{$row['usunome']}</td>";
    $format .= "<td>{$row['usulogin']}</td>";
    $format .= "<td align='center'><a href='alterarusuario.php?codigo={$row[usucod]}'>Alterar</a></td>";
    $format .= "<td align='center'><a href='excluirusuario.php?codigo={$row[usucod]}'>Excluir</a></td>";
    $format .= "</tr>";
}

$format .= "</table>";
echo $format;

//Chama a função rodape.
rodape();
