<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 16:30
 */

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

// Define a constante da bibllioteca MPDF e inclui a mesma.
define('MPDF_PATH', 'MPDF57/');
include(MPDF_PATH . 'mpdf.php');

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
        'content' => 'RELATÓRIO',
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
$mpdf->SetFooter('2015 - Relatório de estoque mínimo | Página: {nb}');

// Busca o logo, nome e a totalização de votos de cada candidato.
$consulta = $pdo->prepare("SELECT * FROM produtos where estoque <= estoquemin order by descricao");
$consulta->execute();

$html = "<table border width='100%'>
    <tr>
        <th colspan='4'>RELATÓRIO DE PRODUTOS PARA COMPRAR</th>
    </tr>
    <tr>
        <td colspan='4'>-----------------------------------------
        ---------------------------------------------------------
        ---------------------------------------------------------
        -----</td>
    </tr>
    <tr>
        <th>CÓDIGO</th>
        <th>DESCRIÇÃO</th>
        <th>ESTOQUE MÍNIMO</th>
        <th>ESTOQUE ATUAL</th>
    </tr>
    <tr>
        <td colspan='4'>-------------------------------------
        ---------------------------------------------------------
        ---------------------------------------------------------
        ---------
        </td>
    </tr>";

while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
    $html.="<tr>
                <th>{$linha['codigo']}</th>
                <th>{$linha['descricao']}</th>
                <th>{$linha['estoquemin']}</th>
                <th>{$linha['estoque']}</th>
            </tr>
            <tr>
                <td colspan='4'>--------------------------------
    ---------------------------------------------------------
    ---------------------------------------------------------
    --------------</td>
            </tr>";
}

$html.="</table>";

$mpdf->WriteHTML($html);
$mpdf->WriteHTML("---------------------------------------
---------------------------------------------------------
---------------------------------------------------------
-------");

$mpdf->Output();

exit();
