<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 14:45
 * Description: Responsavel pela atualizacao de dados do produto na base
 */

//Importa a conexão do banco.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
cabecalho();

$codigo=$_GET['codigo'];

$consulta = $pdo->query("select * from produtos where codigo=:codigo");
$consulta->bindValue(':codigo', $codigo);
$consulta->execute();

while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
    $codigo=$row['codigo'];
    $descricao=$row['descricao'];
    $valor=$row['valor'];
    $estoque=$row['estoque'];
    $estoquemin=$row['estoquemin'];
}

echo "<form action=\"gravaaltprodutos.php\" method=\"post\" name=\"furna\" id=\"furna\">
    <input type=\"hidden\" name=\"txtcodigo\" value=\"$codigo\"> 
    <p><label>Descrição: <input type=\"text\" name=\"txtdescricao\" value=\"$descricao\" size=\"50\" maxlength=\"100\"></label></p>
    <p><label>Valor: <input type=\"text\" name=\"txtvalor\" value=\"$valor\" size=\"10\" maxlength=\"10\"></label></p>
    <p><label>Quantidade em Estoque: <input type=\"text\" name=\"txtestoque\" value=\"$estoque\" size=\"10\" maxlength=\"10\"></label></p>
    <p><label>Quantidade Mínima em Estoque: <input type=\"text\" name=\"txtestoquemin\" value= \"$estoquemin\" size=\"10\" maxlength=\"10\"></label></p>
    <p>
        <input type=\"submit\" value=\"Gravar\">
        <input type=\"reset\" value=\"Limpar\">
    </p> 
</form>
<script>document.furna.txtdescricao.focus(); </script>";

//Chama a função rodape.
rodape();
