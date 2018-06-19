<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 14:20
 * Description: pagina do formulario para o cadastro do produto
 */

//Importa a conexão do banco.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
acesso();
cabecalho();

// Obtém a variável erro, responsável por mostrar as mensagens abaixo depois do sistema.
$erro = (isset($_GET['erro'])) ? $_GET['erro'] : "";
if ($erro=="logout") {
    session_start();
    session_destroy();
    echo "<div class=\"erro\">Sessão encerrada!</div>";
}

echo "<form action=\"gravaprodutos.php\" method=\"post\" name=\"f1\" id=\"f1\">
    <p><label>Descrição: <input type=\"text\" name=\"txtdescricao\" size=\"50\" maxlength=\"100\"></label></p>
    <p><label>Valor: <input type=\"text\" name=\"txtvalor\" size=\"10\" maxlength=\"10\"></label></p>
    <p><label>Quantidade em Estoque: <input type=\"text\" name=\"txtestoque\" size=\"10\" maxlength=\"10\"></label></p>
    <p><label>Quantidade Mínima em Estoque: <input type=\"text\" name=\"txtestoquemin\" size=\"10\" maxlength=\"10\"></label></p>
    <p>
        <input type=\"submit\" value=\"Gravar\">
        <input type=\"reset\" value=\"Limpar\">
    </p>
</form>
<script>document.furna.txtdescricao.focus();</script>";

// Seleciona todos os candidatos cadastrados ordenado por código
$consulta = $pdo->query("select * from produtos order by codigo");

echo "<table width=\"100%\" border>
        <tr>
        <td>Código</td>
        <td>Descrição</td>
        <td>Valor</td>
        <td>Alterar</td>
        <td>Excluir</td>
     </tr>";

// Mostra os candidatos.
while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
            <td>$row[codigo]</td>
            <td>$row[descricao]</td>
            <td>$row[valor]</td>
            <td align=\"center\"><a href=\"alterarprodutos.php?codigo={$row['codigo']}\">Alterar</a></td>
            <td align=\"center\"><a href=\"excluirprodutos.php?codigo={$row['codigo']}\">Excluir</a></td>
        </tr>";
}

echo "</table>";

rodape();
