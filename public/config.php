<?php
/**
 * Created by PhpStorm.
 * User: celsolopes
 * Date: 29/05/18
 * Time: 11:17
 * Description: Arquivo responsavel pela conexao com o Mysql e ao banco de dados `Vendas`
 */

$pdo = new PDO('mysql:host=db;dbname=vendas','root', 'admin', array(PDO::ATTR_PERSISTENT => true));
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
