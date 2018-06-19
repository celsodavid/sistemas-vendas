CREATE DATABASE IF NOT EXISTS `vendas`;

CREATE TABLE `vendas`.`usuarios` (
  `usucod` INT NOT NULL AUTO_INCREMENT,
  `usunome` VARCHAR(100) NULL,
  `usulogin` VARCHAR(50) NULL,
  `ususenha` VARCHAR(100),
  PRIMARY KEY (`usucod`));

CREATE TABLE `vendas`.`produtos` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(100),
  `valor` DOUBLE NULL,
  `estoque` INT NULL,
  `estoquemin` INT NULL,
  PRIMARY KEY (`codigo`));

CREATE TABLE `vendas`.`pedidos` (
  `codped` INT NOT NULL AUTO_INCREMENT,
  `total` DOUBLE NULL,
  `dinheiro` DOUBLE NULL,
  `troco` DOUBLE NULL,
  PRIMARY KEY (`codped`));

CREATE TABLE `vendas`.`itens` (
  `coditem` INT NOT NULL AUTO_INCREMENT,
  `pedido` INT NULL,
  `codprod` INT NULL,
  `valor` DOUBLE NULL,
  `qtde` INT NULL,
  PRIMARY KEY (`coditem`));