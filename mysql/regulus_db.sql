-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 30-Out-2013 às 23:37
-- Versão do servidor: 5.5.27
-- versão do PHP: 5.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dados_banc`
--

DROP TABLE IF EXISTS `dados_banc`;
CREATE TABLE IF NOT EXISTS `dados_banc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Cod_Banc` varchar(3) NOT NULL,
  `Agencia` varchar(6) NOT NULL,
  `Conta` varchar(12) NOT NULL,
  `descricao` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`Cod_Banc`,`Agencia`,`Conta`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores`
--

DROP TABLE IF EXISTS `fornecedores`;
CREATE TABLE IF NOT EXISTS `fornecedores` (
  `ID_Forn` int(11) NOT NULL AUTO_INCREMENT,
  `Raz_Social` varchar(50) NOT NULL,
  `Endereco` varchar(40) DEFAULT NULL,
  `Bairro` varchar(20) DEFAULT NULL,
  `Cidade` varchar(20) DEFAULT NULL,
  `Estado` varchar(2) DEFAULT NULL,
  `Municip` varchar(60) DEFAULT NULL,
  `CEP` varchar(8) DEFAULT NULL,
  `CGC` varchar(14) NOT NULL,
  `Telefone` varchar(14) DEFAULT NULL,
  `Email` varchar(20) DEFAULT NULL,
  `HomeP` varchar(20) DEFAULT NULL,
  `Contato` varchar(30) DEFAULT NULL,
  `tipo_forn` int(11) NOT NULL,
  `ie` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`ID_Forn`),
  KEY `tipo_forn` (`tipo_forn`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reg_user`
--

DROP TABLE IF EXISTS `reg_user`;
CREATE TABLE IF NOT EXISTS `reg_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos`
--

DROP TABLE IF EXISTS `tipos`;
CREATE TABLE IF NOT EXISTS `tipos` (
  `ID_tip` int(11) NOT NULL AUTO_INCREMENT,
  `Desc_tip` varchar(64) NOT NULL,
  PRIMARY KEY (`ID_tip`),
  KEY `ID_tip` (`ID_tip`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `titulos`
--

DROP TABLE IF EXISTS `titulos`;
CREATE TABLE IF NOT EXISTS `titulos` (
  `Num_Tit` varchar(9) NOT NULL,
  `Parcela` varchar(2) NOT NULL,
  `Num_NF` varchar(9) DEFAULT NULL,
  `Desc_Tit` varchar(64) DEFAULT NULL,
  `Num_par` varchar(2) DEFAULT NULL,
  `ID_Forn` int(11) NOT NULL,
  `Dat_Emis` datetime NOT NULL,
  `Dat_Venc` datetime NOT NULL,
  `Val_Tit` decimal(15,2) NOT NULL,
  `Val_mult` decimal(15,2) DEFAULT NULL,
  `Val_Desc` decimal(15,2) DEFAULT NULL,
  `Val_Tot` decimal(15,2) NOT NULL,
  `Imposto` decimal(15,2) DEFAULT NULL,
  `Dat_Baix` datetime DEFAULT NULL,
  `Val_Pag` decimal(15,2) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `id_banc` int(11) DEFAULT NULL,
  UNIQUE KEY `titulo_parcela` (`Num_Tit`,`Num_par`),
  KEY `ID_Forn` (`ID_Forn`),
  KEY `tipo` (`tipo`),
  KEY `id_banc` (`id_banc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `titulos`
--
ALTER TABLE `titulos`
  ADD CONSTRAINT `titulos_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipos` (`ID_tip`),
  ADD CONSTRAINT `titulos_ibfk_2` FOREIGN KEY (`ID_Forn`) REFERENCES `fornecedores` (`ID_Forn`),
  ADD CONSTRAINT `titulos_ibfk_3` FOREIGN KEY (`id_banc`) REFERENCES `dados_banc` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
