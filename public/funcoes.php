<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 11:21
 * Description: Helper de funcoes para ser reutilizavel no sistema
 */

//ini_set('display_errors', FALSE);

######### Função que verifica se o usuário está logado #########
function acesso(){
    session_start();
    if (!isset($_SESSION['usucod'])) {
        header("Location: login.php");
        exit();
    }
    else {
        echo "<h3>Usuário: {$_SESSION['usunome']}</h3>";
    }
}

function cabecalho() {
    header("Pragma: no-cache");
    header("Cache: no-cache");
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    echo sprintf(
        '<!doctype html>
                <html lang="pt-br">
                    <head>
                        <meta charset="utf - 8">
                        <title>Controle de vendas</title>
                        <link rel="stylesheet" href="%s">
                        <script type="text/javascript" src="%s"></script>',
        "estilo.css",
        "js/jquery-1.11.0.min.js"
    );

    // Se for a tela de votos aciona as funções em javascript
    if ($_SERVER['PHP_SELF'] == "/index.php") {
        echo sprintf(
            '<script>
                    function enviar(){
                        //document.furna.codprod.value="";
                        //document.furna.codprod.focus();
                        
                        var codprod = $("#codprod");                       
                        codprod.attr("value", codprod.val());
                        
                        var qtde = $("#qtde");                       
                        qtde.attr("value", qtde.val());
                        
                        $("#valor").hide();
                        $(".confirma").hide();
                        $(".corrige").hide();
                        $(".qtde").hide();
                        
                        document.furna.submit();
                    }
                    
                    function EnterTab(InputId, Evento){
                        if(Evento.keyCode == 13) {
                            var x = document.furna.codprod.value;
                            if (x == null || x == "") {
                                alert("Entre com o valor em dinheiro!");
                                document.f1.dinheiro.focus();
                                document.f1.dinheiro.select();
                            } else {
                                document.getElementById(InputId).focus();
                            }
                        } else if (Evento.keyCode == 113) {
                            window.location.assign("http://localhost:8090/novopedido.php");
                        }
                    }
                </script>'
        );
    }

    // Monta os divs responsáveis pelo layout em css.
    echo sprintf(
        '</head>
                <body>
                    <div id="principal">
                        <div id="cabecalho">
                            <div class="titulo">Controle de vendas</div>
                            <div class="login"><a href="novopedido.php">NovoPedido</a></div>
                            <div class="produto"><a href="inicio.php">Início</a></div>
                            <div class="produto"><a href="cadproduto.php">Produtos</a></div>
                            <div class="produto"><a href="estoquemin.php">Estoque mínimo</a></div>
                            <div class="produto"><a href="relvendas.php">Relatório</a></div>
                            <div class="produto"><a href="cadusuario.php">Usuários</a></div>
                            <div class="produto"><a href="index.php?erro=logout">Sair</a></div>
                        </div>                        
                        <div id="centro">
               '
    );
}

//Função que monta o rodapé de todos os scripts.
function rodape() {
    echo sprintf(
        '</div>
                <div id="rodape">Controle de Vendas - %s</div>
              </div> <!-- fim principal --> 
           </body>
        </html>',
        date("Y")
    );
}
