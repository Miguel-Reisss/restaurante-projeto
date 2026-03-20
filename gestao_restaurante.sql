-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+deb12u1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 20/03/2026 às 14:52
-- Versão do servidor: 10.11.14-MariaDB-0+deb12u2
-- Versão do PHP: 8.2.29

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
  `categoria_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `categoria_id`, `nome`, `data_criacao`) VALUES
(1, 0, 'Lanches Especiais', '2026-03-12 09:00:15'),
(2, 0, 'Porções', '2026-03-12 09:00:15'),
(3, 0, 'Bebidas', '2026-03-12 09:00:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha_hash` varchar(255) NOT NULL,
  `nivel_acesso` enum('admin','gerente','atendente','cozinha') NOT NULL DEFAULT 'atendente',
  `ativo` tinyint(1) DEFAULT 1,
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `nome`, `email`, `senha_hash`, `nivel_acesso`, `ativo`, `data_criacao`) VALUES
(1, 'Administrador', 'admin@restaurante.com', '$2y$10$wE/.76Tz5.zB8H5lR.1Yw.4H4F8G5K3y1y3T7q8V8y8q8q8q8q8q', 'admin', 1, '2026-03-12 09:00:15');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(4, 2, 10, 'livre');

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
  `observacoes` text DEFAULT NULL,
  `data_criacao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_mesa`, `tipo`, `status`, `total`, `observacoes`, `data_criacao`) VALUES
(11, 2, 'salao', 'entregue', 35.90, 'Itens do Pedido:\n1x Hambúrguer Artesanal\n\n\nPagamento: Pix', '2026-03-19 10:58:19'),
(12, 2, 'salao', 'entregue', 85.90, 'Itens do Pedido:\n1x Hambúrguer Artesanal\n1x Fritas Cheddar & Bacon (G)\n1x Água Mineral Sem Gás (500ml)\n\n\nPagamento: Cartão de Crédito', '2026-03-19 11:10:44'),
(14, 2, 'salao', 'entregue', 0.00, 'Itens do Pedido:\r\n\r\n\r\nPagamento: Pix', '2026-03-19 11:14:57'),
(15, 2, 'salao', 'entregue', 35.90, 'Itens do Pedido:\r\n1x Hambúrguer Artesanal\r\n\r\n\r\nPagamento: Pix', '2026-03-19 11:28:35'),
(16, 2, 'salao', 'entregue', 35.90, 'Itens do Pedido:\r\n1x Hambúrguer Artesanal\r\n\r\n\r\nPagamento: Pix', '2026-03-19 11:31:35'),
(18, 4, 'salao', 'entregue', 28.90, 'Itens do Pedido:\r\n1x Chicken Crispy\r\n\r\n\r\nPagamento: Pix', '2026-03-19 11:43:32'),
(19, 2, 'salao', 'pronto', 70.80, 'Itens do Pedido:\n1x Fritas Cheddar & Bacon (M)\n1x Hambúrguer Artesanal\n\n\nPagamento: Pix', '2026-03-19 11:48:03'),
(22, 2, 'salao', 'aberto', 22.50, 'Itens do Pedido:\n1x Batata Frita Tradicional (M)\n\n\nPagamento: Cartão de Crédito', '2026-03-20 11:27:35'),
(23, NULL, 'salao', 'aberto', 35.90, 'Itens do Pedido:\r\n1x Hambúrguer Artesanal\r\n\r\n\r\nPagamento: Cartão de Crédito', '2026-03-20 11:40:09'),
(24, NULL, 'salao', 'aberto', 35.90, 'Itens do Pedido:\r\n1x Hambúrguer Artesanal\r\n\r\n\r\nPagamento: Cartão de Crédito', '2026-03-20 11:40:40');

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
  `ativo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `imagem`, `categoria_id`, `ativo`) VALUES
(1, 'sergio', 'alzira', 1000.00, '1774016112_sergio.jpg', 1, 1);

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
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pedido_mesa` (`id_mesa`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `fk_item_pedido` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_item_produto` FOREIGN KEY (`id_produto`) REFERENCES `produtos` (`id`);

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
