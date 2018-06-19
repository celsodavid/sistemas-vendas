<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 16:37
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Chama a função cabecalho para montá-lo.
acesso();
cabecalho();

// Busca a totalização geral de vendas.
$totalg = $pdo->prepare("SELECT (itens.valor * sum(itens.qtde)) as total FROM produtos,itens where produtos.codigo=itens.codprod group by itens.codprod, itens.valor");
$totalg->execute();

$total=0;
while($row = $totalg->fetch(PDO::FETCH_ASSOC)){
    $total=$total+$row['total'];
}

// Busca as vendas de todos os produtos
$consulta = $pdo->prepare("SELECT produtos.descricao, sum(itens.qtde) as qtde, (itens.valor*sum(itens.qtde)) as subtotal, itens.valor FROM produtos,itens where produtos.codigo=itens.codprod group by itens.codprod, itens.valor");
$consulta->execute();

echo "<div class=\"logotipo2\">
        <h2>Relatório de vendas</h2>
        <table align=\"center\" bordercolor=\"#666666\" width=\"600\" border=\"1\">
            <tr>
                <tH>PRODUTO</tH>
                <tH>QUANTIDADE</tH>
                <tH>VALOR UNITÁRIO</tH>
                <tH>SUBTOTAL</tH>
            </tr>";

while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
    echo "<tr>
            <th>{$linha['descricao']}</th>
            <th>{$linha['qtde']}</th>
            <th>{$linha['valor']}</th>
            <th>{$linha['subtotal']}</th>
          </tr>";
}

echo "<tr>
            <th></th>
            <th></th>
            <th>TOTAL</th>
            <th>$total</th>
        </tr>
    </table>
    <h3><a href=\"relatorio.php\" target=\"new\">Gerar relatório em PDF</a></h3>
    <p>
        Gráficos
        <a href=\"grafico.php?tipo=bars\">Barras</a> :: 
        <a href=\"grafico.php?tipo=Pie\">Pizza</a> :: 
        <a href=\"grafico.php?tipo=linepoints\">Linha e pontos</a> :: 
        <a href=\"grafico.php?tipo=area\">Área</a>
    </p>
</div>";

rodape();
