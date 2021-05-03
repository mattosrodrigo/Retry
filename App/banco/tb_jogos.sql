-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Nov-2019 às 02:22
-- Versão do servidor: 10.3.16-MariaDB
-- versão do PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_retry`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_jogos`
--

CREATE TABLE `tb_jogos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(90) DEFAULT NULL,
  `categoria` varchar(90) DEFAULT NULL,
  `criador` varchar(90) DEFAULT NULL,
  `data_lancamento` date DEFAULT NULL,
  `plataformas` varchar(90) DEFAULT NULL,
  `link_video` varchar(200) DEFAULT NULL,
  `resumo` text DEFAULT NULL,
  `avaliacao` text DEFAULT NULL,
  `sinopse_resumida` text DEFAULT NULL,
  `requisitos_minimos` text DEFAULT NULL,
  `requisitos_recomendados` text DEFAULT NULL,
  `nota` decimal(10,0) DEFAULT NULL,
  `imagem` varchar(100) DEFAULT NULL,
  `imgretrato` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_jogos`
--

INSERT INTO `tb_jogos` (`id`, `titulo`, `categoria`, `criador`, `data_lancamento`, `plataformas`, `link_video`, `resumo`, `avaliacao`, `sinopse_resumida`, `requisitos_minimos`, `requisitos_recomendados`, `nota`, `imagem`, `imgretrato`) VALUES
(2, 'teste', '', '', '2019-11-03', '', '', '', '', '', '', '', '0', 'proposta redacao.png', 'fotografo-capta-imagem-incrivel-do-eclipse-solar-no-chile-Blog-eMania-03-07.jpg'),
(3, 'teste2', '', '', '0000-00-00', '', '', '', '', '', '', NULL, '0', 'fotografo-capta-imagem-incrivel-do-eclipse-solar-no-chile-Blog-eMania-03-07.jpg', 'IMG_20170904_150427307.jpg'),
(4, 'teste3', '', '', '2011-10-12', '', '', '', '', '', '', NULL, '0', 'neon-sinal-barzinhos-imagem-coquetel_23-2148184280.jpg', 'fotografo-capta-imagem-incrivel-do-eclipse-solar-no-chile-Blog-eMania-03-07.jpg'),
(6, 'teste4', '', 'sdadsada', '0000-00-00', '', '', '', '', 'sad', '', '', '0', 'WhatsApp Image 2019-09-30 at 10.14.37 AM.jpeg', 'fotografo-capta-imagem-incrivel-do-eclipse-solar-no-chile-Blog-eMania-03-07.jpg');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_jogos`
--
ALTER TABLE `tb_jogos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_jogos`
--
ALTER TABLE `tb_jogos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
