<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 15:05
 */

//Importa a conexão do banco.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

// Obtém a variável erro, responsável por mostrar mensagens abaixo depois de algum erro de autenticação.
$erro = (isset($_GET['erro'])) ? $_GET['erro'] : '';
if ($erro=="invalido"){
    echo "<div class=\"erro\">Usuário inválidos!</div>";
}
?>

<form action="autentica.php" method="post" name="f1">
    Usuário: <input type="text" id="txtlogin" name="txtlogin" class="txtbox" />
    Senha: <input type="password" id="txtsenha" name="txtsenha" class="txtbox" />

    <input type="submit" id="btnEntrar" value="Entrar" class="button" />
</form>

<script> document.f1.txtlogin.focus();</script>
<?php
rodape();
