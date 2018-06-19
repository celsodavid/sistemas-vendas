<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 16:46
 */

#Incluimos a biblioteca
require("phplot/phplot.php");

$tipo=$_GET['tipo'];

//Importa o arquivo de configuração da conexão do Mysql.
require "config.php";
$consulta = $pdo->prepare("SELECT produtos.descricao, sum(itens.qtde) as qtde FROM produtos,itens where produtos.codigo=itens.codprod group by itens.codprod");
$consulta->execute();

$dados = array();
$legenda2 = array();

while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
    $valor=array($linha['descricao'], $linha['qtde']);
    array_push($dados,$valor);

    $legenda=array($linha['descricao']);
    array_push($legenda2,$legenda);
}

#Definimos o objeto para inicar a "montagem" do gráfico
$grafico = new PHPlot();
$grafico->SetPlotType($tipo);

if ($tipo=="Pie"){
    $grafico->SetDataType('text-data-single');

    foreach ($legenda2 as $linha){
        $grafico->SetLegend($linha[0]);
    }
}

$grafico->SetDataValues($dados);
$grafico->SetTitle("Gráfico $tipo");

#Exibimos o gráfico
$grafico->DrawGraph();
