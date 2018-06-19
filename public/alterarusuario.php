<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 13:42
 * Description: Edita os usuario atraves do usucod
 */

//Importa a conexão do banco.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

$codigo = $_GET['codigo'];

$consulta = $pdo->prepare("SELECT * FROM usuarios where usucod=:codigo");
$consulta->bindValue(':codigo', $codigo);
$consulta->execute();

while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
    $codigo = $row['usucod'];
    $nome = $row['usunome'];
    $login = $row['usulogin'];
}

echo sprintf(
    '<form action="%s" method="post" name="f1" id="f1">
                <input type="hidden" name="txtcodigo" value="$codigo">
                <p><label>Nome:<input type="text" name="txtnome" value="%s" size="50" maxlength="100"></label></p>
                <p><label>Login: <input type="text" name="txtlogin" value="%s" size="50" maxlength="100"></label></p>
                <p><label>Senha:<input type="password" name="txtsenha" size="50" maxlength="100"></label></p>
                <p>
                    <input type="submit" value="Gravar">
                    <input type="reset" value="Limpar">
                </p>
            </form>
            <script>document.furna.txtnome.focus();</script>',
    'gravaaltusuario.php',
    $nome,
    $login
);

//Chama a função rodape.
rodape();
