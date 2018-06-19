<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 28/05/18
 * Time: 17:44
 */

//Importa a conexão do banco.
require "config.php";

//Importa as funções cabecalho, rodape e menu.
require "funcoes.php";

//Verifica se a variável codped existe, caso contrário é gerado um novo pedido
if (!isset($_GET['codped'])){
    header("Location: novopedido.php");
}

cabecalho();

$codped= (isset($_GET['codped'])) ? $_GET['codped'] : 0;

// Obtém a variável erro, responsável por mostrar as mensagens.
$erro= (isset($_GET['erro'])) ? $_GET['erro'] : '';
if ($erro=="logout"){
    @session_start();
    session_destroy();
    setcookie("teste", "");
    echo "<div class=\"erro\">Sessão encerrada!</div>";
}

// Monta o formulário para a votação.
echo "<div class=\"informe\">
        <table width=\"100%\">
            <tr>
                <td align=\"center\">
                    <form action=\"gravaitem.php\" method=\"post\" name=\"furna\" id=\"furna\" onsubmit=\"return false\">
                        <input type='hidden' name='codped' value=\"$codped\">
                        <p><label>Produto: <input type=\"text\" name=\"codprod\" size=\"3\" maxlength=\"3\" id=\"codprod\" onkeydown=\"javascript:EnterTab('qtde',event)\"></label></p>
                        <p>
                            <span class=\"carregando2\"><img src=\"ajax-loader.gif\"/></span>
                            <span class=\"total\" id=\"valor\"></span>
                            <script type=\"text/javascript\">
                                $(function(){
                                    $('#codprod').keyup(function(){
                                        if ($(this).val()) {
                                            $('#valor').hide();
                                            $('.carregando2').show();
                                            $.getJSON('buscaproduto.php?codigo=',{codigo: $(this).val(), ajax: 'true'},function(j){
                                                var cand;
                                                for (var i = 0; i < j.length; i++) {
                                                    var cand = '<p><strong>'+j[i].descricao+' - R$ '+j[i].valor+'</strong></div>';
                                                }
                                                
                                                $('#valor').html(cand).show();
                                                $('.carregando2').hide();
                                                                                                
                                                if (j[0].valor=='invalido.png'){
                                                    $('.confirma').hide();
                                                    $('.qtde').hide();
                                                    $('.corrige').show();
                                                    $('#valor').html('<img src=img/'+j[0].valor+' width=80 height=50>');
                                                } else {
                                                    $('.confirma').show();
                                                    $('.corrige').show();
                                                    $('.qtde').show();
                                                    $('.qtde').focus();
                                                }
                                            });
                                        } else {
                                            $('#valor').html('');                                            
                                            $('.confirma').hide();
                                            $('.qtde').hide();
                                        }
                                    });
                                });
                            </script>
                        </p>
                    <p>
                        <span class=\"qtde\">Quantidade: <input type='text' name='qtde' size='3' id='qtde' onkeydown=\"javascript:EnterTab('confirma',event)\"></span>
                        <table>
                            <tr>                                
                                <td><input type='button' class='corrige confirma' value='Corrige' id='corrige' onClick=\"limpar();\"></td>
                                <td><input type='button' class='confirma' value='Confirma' id='confirma' onClick=\"enviar();\"></td>
                            </tr>
                        </table>
                    </p>
                </form>
            </td>
        </tr>
    </table>
</div>
<script>document.furna.codprod.focus();</script>";
# <!--<td><span class="corrige" tabindex=0> <img src="img/corrige.png" width="60" height="50" onClick="limpar();"></span></td>-->

$consulta = $pdo->query("select * from pedidos, itens, produtos where pedidos.codped=itens.pedido and itens.codprod=produtos.codigo and pedidos.codped=$codped");

echo "<div class=\"logotipo\">
            <table border width='100%'>
            <tr class='cab'>
                <td>Cód</td>
                <td>Prod</td>
                <td>Qtde</td>
                <td>R$</td>
                <td>Subtotal</td>
                <td>Excluir</td>
            </tr>";

$total=0;
while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
    $subtotal=$linha['qtde']*$linha['valor'];
    $total=$total+$subtotal;
    echo "<tr align='center'>
            <td><strong>$linha[codprod]</strong></td>
            <td><strong>$linha[descricao]</strong></td>
            <td><strong>$linha[qtde]</strong></td>
            <td><strong>$linha[valor]</strong></td>
            <td><strong>$subtotal</strong></td>
            <td><strong><a href='excluiritem.php?coditem=" . $linha['coditem'] . "&codped=" .$linha['codped']. "'>Excluir</a></strong></td>
         </tr>";
}

$conped = $pdo->query("select sum(itens.qtde*itens.valor) as total, pedidos.dinheiro, pedidos.troco from pedidos, itens where pedidos.codped=$codped and pedidos.codped=itens.pedido");
$pedido = $conped->fetch(PDO::FETCH_ASSOC);

echo "
    <tr align='center'>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
    <tr align='center'>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>Total</td>
        <td class='total'>R$ $total</td>
        <td>-</td>
    </tr>
    <tr align='center'>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>Dinheiro</td>
        <td>
            <form name='f1' method='post' action='troco.php'>
                <input type='hidden' name='codped' value='$codped'>
                <input type='hidden' name='total' value='" . $pedido['total'] . "'>
                <input type='text' name='dinheiro' value='" . $pedido['dinheiro'] . "' size='5' id='dinheiro'><br>
                <input type='submit' value='Calcular Troco'>
            </form>
        </td>
        </td>-<td>
    </tr>
    <tr align='center'>
        <td></td>
        <td>-</td>
        <td>-</td>
        <td>Troco</td>
        <td class='total'>R$ {$pedido['troco']}</td>
        <td>-</td>
    </tr>
    </table>
</div>";

//Chama a função cabecalho para montá-lo.
$consulta = $pdo->query("select * from produtos order by codigo");

echo "
<table width=\"100%\" class=\"preco\">
    <tr>
        <th>Cod</th>
        <th>Produto</th>
        <th>R$</th>
    </tr>";

while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
            <td align=\"center\">$row[codigo]</td>
            <td>$row[descricao]</td>
            <td align=\"right\">$row[valor]</td>
        </tr>";
}
echo "</table>";

rodape();
