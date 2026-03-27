# 🍔 Celestina Point - Sistema de Gestão para Restaurantes

Um sistema web completo para gerenciamento de pedidos, mesas e cardápio digital, desenvolvido com foco na agilidade do atendimento e facilidade de gestão.

## 🚀 Funcionalidades

O sistema é dividido em três áreas principais de acesso:

### 📱 1. Visão do Cliente (Cardápio Digital)
* **Acesso Inteligente:** O cliente entra no cardápio através de um Código PIN fornecido pelo garçom (ou via leitura de QR Code da mesa).
* **Cardápio Dinâmico:** Produtos organizados por categoria, suporte a variações de tamanhos (P, M, G) e descrição detalhada.
* **Carrinho de Compras:** Sistema de carrinho via `localStorage` (não perde os dados se a página recarregar), com cálculo automático de totais.
* **Checkout:** Tela de finalização com opções de pagamento (Pix, Cartão, Dinheiro com cálculo de troco) e campo para observações do prato.

### 👨‍🍳 2. Painel do Garçom / Cozinha
* **Gestão de Mesas:** Consulta rápida dos códigos PIN de cada mesa e visualização do status (Livre/Ocupada).
* **Controle de Pedidos:** Acompanhamento de pedidos em tempo real com alteração de status (`Novo Pedido` ➡️ `Preparando` ➡️ `Pronto` ➡️ `Entregue`).
* **Filtros:** Busca de pedidos por número ou ocultação de pedidos já entregues.

### 👑 3. Painel CEO (Administrador)
* **Dashboard:** Visão geral com contagem de produtos, mesas, categorias e funcionários ativos.
* **Gestão de Produtos:** Cadastro, edição e exclusão de itens do cardápio, com upload de imagens e configuração de múltiplos preços.
* **Gestão de Equipe:** Controle de acesso (Garçom, Caixa, Admin) e senhas.
* **Gestão do Salão:** Criação de novas mesas e acompanhamento detalhado de tudo que está sendo consumido no restaurante.

---

## 🛠️ Tecnologias Utilizadas

* **Front-end:** HTML5, CSS3, JavaScript e Bootstrap 5.
* **Back-end:** PHP (Padrão MVC simples).
* **Banco de Dados:** MySQL.
* **Ícones:** Phosphor Icons.
