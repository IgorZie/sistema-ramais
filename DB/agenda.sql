-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Ago-2022 às 13:24
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agenda`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `setor`
--

CREATE TABLE `setor` (
  `id` int(11) NOT NULL,
  `descricao` varchar(250) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `setor`
--

INSERT INTO `setor` (`id`, `descricao`) VALUES
(1, 'TI'),
(2, 'PSICOLOGIA'),
(3, 'TX'),
(4, 'RH'),
(5, 'CONTABILIDADE'),
(6, 'FATURAMENTO'),
(7, 'FINANCEIRO'),
(8, 'DIRETORIA'),
(9, 'PRESIDÊNCIA'),
(10, 'VOLUNTARIADO'),
(11, 'SAC'),
(12, 'ADMINISTRATIVO');

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade`
--

CREATE TABLE `unidade` (
  `id` int(11) NOT NULL,
  `descricao` varchar(250) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `unidade`
--

INSERT INTO `unidade` (`id`, `descricao`) VALUES
(1, 'IPREPS'),
(2, 'CTDR MAFRA'),
(3, 'CTDR JOINVILLE'),
(4, 'BALNEARIO CAMBORIU'),
(5, 'PALMAS'),
(6, 'JARAGUA DO SUL'),
(7, 'VIDA CENTER'),
(8, 'GURUPI'),
(9, 'MATRIZ'),
(10, 'CALL CENTER'),
(11, 'CTDR JARAGUA'),
(12, 'SAO BENTO DO SUL'),
(13, 'CENTRO DE PESQUISA'),
(14, 'PRODUTOS SOCIAIS'),
(15, 'MAFRA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `ramal` int(11) NOT NULL,
  `id_unidade` int(11) NOT NULL,
  `id_setor` int(11) NOT NULL,
  `criado` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `setor`
--
ALTER TABLE `setor`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `unidade`
--
ALTER TABLE `unidade`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_unidade` (`id_unidade`),
  ADD KEY `id_setor` (`id_setor`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `setor`
--
ALTER TABLE `setor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `unidade`
--
ALTER TABLE `unidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `id_setor` FOREIGN KEY (`id_setor`) REFERENCES `setor` (`id`),
  ADD CONSTRAINT `id_unidade` FOREIGN KEY (`id_unidade`) REFERENCES `unidade` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
