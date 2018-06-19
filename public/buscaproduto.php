<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 13:13
 * Description: Arquivo responsavel por buscar o produto pelo codigo do produto (AJAX)
 */

//Importa a conexão do banco.
require "config.php";

// Recebe o código informado pelou suário para ser pesquisado no banco.
$codigo = $_GET['codigo'];

// Se o valor informado for um número ele faz a pesquisa.
if (is_numeric($codigo)) {
    $consulta = $pdo->prepare("SELECT * FROM produtos WHERE codigo = :codigo");
    $consulta->bindValue(':codigo', $_GET['codigo']);
    $consulta->execute();

    $conta=0;
    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
        $imagem[] = array(
            'codigo' => $linha['codigo'],
            'descricao' => $linha['descricao'],
            'valor' => $linha['valor'],
        );

        $conta++;
    }

    if ($conta==1) {
        // Retorna um array com os valores do candidato.
        echo(json_encode($imagem));
    }
    else {
        $imagem[] = array(
            'codigo' => 0,
            'descricao' => '',
            'valor' => 'invalido.png',
        );

        // Retorna um array com valores inválidos.
        echo(json_encode($imagem));
    }
}
else {
    $imagem[] = array(
        'codigo' => 0,
        'descricao' => '',
        'valor' => 'invalido.png',
    );

    // Retorna um array com valores inválidos.
    echo(json_encode($imagem));
}
