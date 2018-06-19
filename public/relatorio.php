<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 16:42
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

// Define a constante da bibllioteca MPDF e inclui a mesma.
define('MPDF_PATH', 'MPDF57/');
include(MPDF_PATH.'mpdf.php');

// Cria um novo documento.
$mpdf=new mPDF('','', 0, '', 10, 10);

// Cria um array com valores de formatação
$arr = array (
    'L' => array (
        'content' => 'Controle de vendas',
        'font-size' => 10,
        'font-style' => 'B',
        'font-family' => 'serif',
        'color'=>'#000000'
    ),
    'C' => array (
        'content' => 'RELATÓRIO DE VENDAS',
        'font-size' => 10,
        'font-style' => 'B',
        'font-family' => 'serif',
        'color'=>'#000000'
    ),
    'R' => array (
        'content' => '{DATE d/m/Y}',
        'font-size' => 10,
        'font-style' => 'B',
        'font-family' => 'serif',
        'color'=>'#000000'
    ),
    'line' => 1,
);

// Define cabeçalho e rodapé do documento.
$mpdf->SetHeader($arr, 'O');
$mpdf->SetFooter('2015 - Relatório de vendas | Página: {nb}');

// Busca o total de vendas
$totalg = $pdo->prepare("SELECT (itens.valor * sum(itens.qtde)) as total FROM produtos,itens where produtos.codigo=itens.codprod group by itens.codprod, itens.valor");
$totalg->execute();

$total=0;
while($row = $totalg->fetch(PDO::FETCH_ASSOC)){
    $total=$total+$row['total'];
}

// Busca o total de vendas por produto
$consulta = $pdo->prepare("SELECT produtos.descricao, sum(itens.qtde) as qtde, (itens.valor*sum(itens.qtde)) as subtotal, itens.valor FROM produtos,itens where produtos.codigo=itens.codprod group by itens.codprod, itens.valor");
$consulta->execute();

$html = "<table border width='100%'>
            <tr>
                <td>Produto</td>
                <td>Quantidade</td>
                <td>Valor Unitário</td>
                <td>Subtotal</td>
            </tr>
            <tr>
                <td colspan='4'>----------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
            </tr>";

while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
    $html.="<tr>
                <td>$linha[descricao]</td>
                <td>$linha[qtde]</td>
                <td>$linha[valor]</td>
                <td>$linha[subtotal]</td>
            </tr>
            <tr>
                <td colspan='4'>----------------------------------------------------------------------------------------------------------------------------------------------------------------</td>
            </tr>";
}

$html.="<tr>
            <td></td>
            <td></td>
            <td>TOTAL</td>
            <td>$total</td>
        </tr>
</table>";

$mpdf->WriteHTML($html);
$mpdf->WriteHTML("----------------------------------------------------------------------------------------------------------------------------------------------------------------");
$mpdf->Output();

exit();
