<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 16:27
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
acesso();
cabecalho();

$consulta = $pdo->prepare("SELECT * FROM produtos where estoque <= estoquemin order by descricao");
$consulta->execute();

echo "<div class=\"logotipo2\">
<h2>Relatório de produtos para comprar</h2>
<table align=\"center\" bordercolor=\"#666666\" width=\"600\" border=\"1\">
    <tr>
        <tH>CÓDIGO</tH>
        <tH>DESCRIÇÃO</tH>
        <tH>ESTOQUE MÍNIMO</tH>
        <tH>ESTOQUE ATUAL</tH>
    </tr>";

while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
    echo "<tr>
            <th>{$linha['codigo']}</th>
            <th>{$linha['descricao']}</th>
            <th>{$linha['estoquemin']}</th>
            <th>{$linha['estoque']}</th>
        </tr>";
}

echo "</table>
    <h3> <a href=\"relestoquemin.php\" target=\"new\">Gerar relatório em PDF</a></h3>
</div>";

rodape();
