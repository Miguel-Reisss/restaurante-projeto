-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24/03/2026 às 21:41
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gestao_restaurante`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `data_criacao`) VALUES
(1, 'Lanches Especiais', '2026-03-12 09:00:15'),
(2, 'Porções', '2026-03-12 09:00:15'),
(3, 'Bebidas', '2026-03-12 09:00:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `nivel_acesso` varchar(30) NOT NULL DEFAULT 'garcom',
  `ativo` tinyint(1) DEFAULT 1,
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `email`, `senha_hash`, `nivel_acesso`, `ativo`, `data_criacao`) VALUES
(1, 'Administrador', 'admin@restaurante.com', '123456', 'admin', 1, '2026-03-12 09:00:15'),
(2, 'Dian', 'dian@restaurante.com', '$2y$10$9KDZWH.UKPENXJ2vQl27/.wLc8zjW3HjgHbc2G6aSgq9xuyyAOVvK', 'garcom', 1, '2026-03-24 08:47:46');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`id`, `id_pedido`, `id_produto`, `nome`, `quantidade`, `subtotal`) VALUES
(15, 42, 0, 'Hambúrguer Artesanal', 1, 22.00),
(16, 43, 0, 'Suco de Limão (M)', 1, 12.00),
(17, 43, 0, 'Smash Burger Duplo', 1, 30.00),
(18, 44, 0, 'Smash Burger Duplo', 1, 30.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `capacidade` int(11) NOT NULL,
  `status` enum('livre','ocupada','manutencao') DEFAULT 'livre'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `mesas`
--

INSERT INTO `mesas` (`id`, `numero`, `capacidade`, `status`) VALUES
(2, 1, 2, 'livre'),
(4, 2, 10, 'livre'),
(5, 5, 5, 'livre'),
(6, 3, 6, 'livre'),
(7, 4, 5, 'livre'),
(8, 6, 3, 'livre'),
(9, 7, 2, 'livre'),
(10, 8, 4, 'livre'),
(11, 9, 2, 'livre'),
(12, 10, 4, 'livre');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `metodo` varchar(50) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `troco_para` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'concluido',
  `data_pagamento` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id`, `id_pedido`, `metodo`, `valor`, `troco_para`, `status`, `data_pagamento`) VALUES
(13, 39, 'Cartão de Crédito', 25.00, NULL, 'concluido', '2026-03-24 13:58:53'),
(14, 40, 'Cartão de Débito', 63.00, NULL, 'concluido', '2026-03-24 14:01:50'),
(15, 41, 'Cartão de Débito', 42.00, NULL, 'concluido', '2026-03-24 14:11:35'),
(16, 42, 'Pix', 22.00, NULL, 'concluido', '2026-03-24 14:15:47'),
(17, 43, 'Cartão de Débito', 42.00, NULL, 'concluido', '2026-03-24 14:39:40'),
(18, 44, 'Cartão de Crédito', 30.00, NULL, 'concluido', '2026-03-24 20:35:25');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_mesa` int(11) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT 'salao',
  `status` varchar(50) DEFAULT 'aberto',
  `total` decimal(10,2) DEFAULT 0.00,
  `itens_resumo` text DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_mesa`, `tipo`, `status`, `total`, `itens_resumo`, `observacoes`, `data_criacao`) VALUES
(42, 10, 'salao', 'pronto', 22.00, '1x Hambúrguer Artesanal', 'tirar cebola', '2026-03-24 11:15:47'),
(43, 2, 'salao', 'aberto', 42.00, '1x Suco de Limão (M)\n1x Smash Burger Duplo', 'tirar tudo', '2026-03-24 11:39:40'),
(44, 5, 'salao', 'aberto', 30.00, '1x Smash Burger Duplo', '', '2026-03-24 17:35:25');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT 1,
  `tem_tamanho` bit(1) DEFAULT b'0',
  `tem_tamanhos` tinyint(1) DEFAULT 0,
  `preco_p` decimal(10,2) DEFAULT NULL,
  `preco_m` decimal(10,2) DEFAULT NULL,
  `preco_g` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `imagem`, `categoria_id`, `ativo`, `tem_tamanho`, `tem_tamanhos`, `preco_p`, `preco_m`, `preco_g`) VALUES
(29, 'Hambúrguer Artesanal', 'Pão brioche, blend 180g, queijo cheddar, bacon crocante e maionese da casa.', 22.00, '1774355157_HambrguerArtesanal.png', 1, 1, b'0', 0, NULL, NULL, NULL),
(30, 'Smash Burger Duplo', 'Pão australiano, 2 blends smash 90g, dobro de cheddar e cebola caramelizada.', 30.00, '1774355283_SmashBurgerDuplo.png', 1, 1, b'0', 0, NULL, NULL, NULL),
(31, 'Chicken Crispy', 'Pão tradicional, filé de frango empanado crocante, alface e maionese verde.', 25.00, '1774355557_ChickenCrispy.png', 1, 1, b'0', 0, NULL, NULL, NULL),
(32, 'Batata Frita Tradicional', 'Porção de batatas palito sequinhas e crocantes.', 0.00, '1774355719_BatataFritaTradicional.png', 2, 1, b'0', 1, 15.00, 20.00, 25.00),
(33, 'Batata Frita Cheddar & Bacon', 'Porção de Batata Frita coberta com muito creme de cheddar e cubos de bacon.', 0.00, '1774355866_BatataFritaCheddarBacon.png', 2, 1, b'0', 1, 20.00, 25.00, 30.00),
(34, 'Coca-Cola', 'Refrigerante Coca-Cola Original bem gelado.', 0.00, '1774356370_CocaCola.png', 3, 1, b'0', 1, 7.00, 10.00, 16.00),
(35, 'Coca-Cola Zero', 'Refrigrante Coca-Cola Zero bem gelado.', 0.00, '1774356666_CocaColaZero.png', 3, 1, b'0', 1, 7.00, 10.00, 16.00),
(36, 'Suco Natural de Laranja', 'Refrescante e cheio de energia! Feito com laranjas frescas espremidas na hora. Doçura natural, sem conservantes ou açúcares adicionados.', 0.00, '1774360230_SucoNaturaldeLaranja.png', 3, 1, b'0', 1, 8.00, 12.00, 20.00),
(37, 'Suco de Uva', 'O puro sabor da fruta! Suco integral de uvas selecionadas, com coloração intensa, aroma marcante e textura aveludada, servido bem gelado.', 0.00, '1774360247_SucodeUva.png', 3, 1, b'0', 1, 8.00, 12.00, 20.00),
(38, 'Suco de Limão', 'O equilíbrio perfeito para matar a sede! Limonada fresca e batida na hora, com aquele toque cítrico inconfundível. Refrescância garantida a cada gole.', 0.00, '1774360263_SucodeLimo.png', 3, 1, b'0', 1, 8.00, 12.00, 20.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `valores_produtos_tamanho`
--

CREATE TABLE `valores_produtos_tamanho` (
  `produto_id` int(11) NOT NULL,
  `valor_p` decimal(6,3) DEFAULT NULL,
  `valor_m` decimal(6,3) DEFAULT NULL,
  `valor_g` decimal(6,3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `valores_produtos_tamanho`
--

INSERT INTO `valores_produtos_tamanho` (`produto_id`, `valor_p`, `valor_m`, `valor_g`) VALUES
(23, 14.990, 39.990, 39.990),
(22, 12.920, 32.400, 32.400),
(24, 12.920, 32.400, 32.400),
(25, 6.000, 15.990, 15.990);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_item_pedido` (`id_pedido`),
  ADD KEY `fk_item_produto` (`id_produto`);

--
-- Índices de tabela `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_mesa` (`id_mesa`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produto_categoria` (`categoria_id`);

--
-- Índices de tabela `valores_produtos_tamanho`
--
ALTER TABLE `valores_produtos_tamanho`
  ADD KEY `produto_id` (`produto_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `valores_produtos_tamanho`
--
ALTER TABLE `valores_produtos_tamanho`
  MODIFY `produto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `fk_item_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedido_mesa` FOREIGN KEY (`id_mesa`) REFERENCES `mesas` (`id`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
