<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pedido - Sabor & Tempo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        :root {
            --bg-color: #F8F9FA;
            --text-color: #2B2D42;
            --card-bg: #ffffff;
            --header-bg: #D32F2F;
            --header-text: #ffffff;
            --border-color: #dee2e6;
        }

        [data-theme="dark"] {
            --bg-color: #121212;
            --text-color: #f1f1f1;
            --card-bg: #1e1e1e;
            --header-bg: #1a1a1a;
            --header-text: #D32F2F;
            --border-color: #333333;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: sans-serif;
            padding-bottom: 100px;
            transition: 0.3s;
            margin: 0;
        }

        .header {
            background-color: var(--header-bg);
            color: var(--header-text);
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .header h2 {
            margin: 0;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-voltar {
            background: transparent;
            border: none;
            color: var(--header-text);
            font-size: 1.5rem;
            position: absolute;
            left: 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .btn-theme {
            background: transparent;
            border: none;
            color: var(--header-text);
            font-size: 1.5rem;
            cursor: pointer;
            position: absolute;
            right: 20px;
        }

        .resumo-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .item-carrinho {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed var(--border-color);
        }

        .item-carrinho:last-child {
            border-bottom: none;
        }

        .form-control {
            background-color: var(--bg-color);
            color: var(--text-color);
            border-color: var(--border-color);
        }

        .form-control:focus {
            background-color: var(--bg-color);
            color: var(--text-color);
            box-shadow: none;
            border-color: #D32F2F;
        }

        .carrinho-bar {
            background-color: var(--card-bg);
            border-top: 1px solid var(--border-color);
            z-index: 1000;
        }
    </style>
</head>

<body>

    <div class="header mb-4">
        <a href="index.php?page=cardapio" class="btn-voltar" title="Voltar ao Cardápio"><i class="ph ph-arrow-left"></i></a>
        <h2><i class="ph ph-cooking-pot" style="color: #F4A261;"></i> <b>SABOR</b> <span style="font-weight: 300;">& TEMPO</span></h2>
        <button id="theme-toggle" class="btn-theme" title="Trocar Tema"><i class="ph ph-moon"></i></button>
    </div>

    <div class="container" style="max-width: 800px;">
        <h3 class="mb-4 fw-bold">Resumo do Pedido</h3>

        <div class="resumo-card">
            <h5 class="fw-bold mb-3"><i class="ph ph-shopping-bag me-2"></i>Itens Selecionados</h5>
            <div id="lista-itens">
                <p class="text-muted">Carregando itens...</p>
            </div>
            <div class="d-flex justify-content-between mt-3 pt-3" style="border-top: 2px solid var(--border-color);">
                <h4 class="fw-bold">Total:</h4>
                <h4 class="fw-bold text-success" id="total-tela">R$ 0,00</h4>
            </div>
        </div>

        <form id="form-pedido" action="index.php?controller=pedido&action=store" method="POST">

            <div class="resumo-card">
                <h5 class="fw-bold mb-3"><i class="ph ph-armchair me-2"></i>Informações da Mesa</h5>

                <div class="mb-3">
                    <label class="form-label fw-bold">Número da Mesa *</label>
                    <input type="number" name="mesa_id" class="form-control form-control-lg" placeholder="Ex: 5" required min="1">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Observações (Opcional)</label>
                    <textarea id="obs-cliente" class="form-control" rows="2" placeholder="Ex: Tirar cebola, hambúrguer bem passado..."></textarea>
                </div>
            </div>

            <input type="hidden" name="tipo" value="salao">
            <input type="hidden" name="status" value="aberto">
            <input type="hidden" name="total" id="input-total" value="0">
            <input type="hidden" name="observacoes" id="input-observacoes" value="">

            <div class="fixed-bottom p-3 shadow-lg d-flex justify-content-between align-items-center carrinho-bar">
                <div class="container d-flex justify-content-end">
                    <button type="submit" class="btn btn-lg w-100" style="background-color: #D32F2F; color: white; border-radius: 8px; font-weight: bold; max-width: 800px;">
                        Enviar Pedido para Cozinha <i class="ph ph-paper-plane-tilt ms-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // 1. TEMA CLARO/ESCURO
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeIcon = themeToggleBtn.querySelector('i');
        const htmlElement = document.documentElement;
        if (localStorage.getItem('theme') === 'dark') {
            htmlElement.setAttribute('data-theme', 'dark');
            themeIcon.classList.replace('ph-moon', 'ph-sun');
        }
        themeToggleBtn.addEventListener('click', () => {
            if (htmlElement.getAttribute('data-theme') === 'dark') {
                htmlElement.removeAttribute('data-theme');
                themeIcon.classList.replace('ph-sun', 'ph-moon');
                localStorage.setItem('theme', 'light');
            } else {
                htmlElement.setAttribute('data-theme', 'dark');
                themeIcon.classList.replace('ph-moon', 'ph-sun');
                localStorage.setItem('theme', 'dark');
            }
        });

        // 2. RECUPERAR CARRINHO
        const listaItensDiv = document.getElementById('lista-itens');
        const totalTela = document.getElementById('total-tela');
        const inputTotal = document.getElementById('input-total');
        const formPedido = document.getElementById('form-pedido');
        const obsCliente = document.getElementById('obs-cliente');
        const inputObservacoes = document.getElementById('input-observacoes');

        // Pega os itens salvos ou cria array vazio
        let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
        let total = 0;
        let resumoTexto = "Itens do Pedido:\n";

        if (carrinho.length === 0) {
            listaItensDiv.innerHTML = '<p class="text-danger">Seu carrinho está vazio!</p>';
        } else {
            listaItensDiv.innerHTML = ''; // Limpa o "Carregando"

            carrinho.forEach(item => {
                total += item.preco;
                resumoTexto += `- ${item.nome}\n`;

                // Adiciona na tela
                listaItensDiv.innerHTML += `
                    <div class="item-carrinho">
                        <span>${item.nome}</span>
                        <span class="fw-bold">R$ ${item.preco.toFixed(2).replace('.', ',')}</span>
                    </div>
                `;
            });

            // Atualiza os valores totais na tela e no input escondido
            totalTela.innerText = total.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
            inputTotal.value = total;
        }

        // Antes de enviar o formulário, junta os itens com as observações do cliente
        formPedido.addEventListener('submit', function(e) {
            if (carrinho.length === 0) {
                e.preventDefault();
                alert("Adicione itens ao pedido antes de finalizar!");
                return;
            }

            const obsExtra = obsCliente.value ? `\n\nObs do Cliente: ${obsCliente.value}` : '';
            inputObservacoes.value = resumoTexto + obsExtra;

            // Limpa o carrinho depois de enviar!
            localStorage.removeItem('carrinho');
        });
    </script>
</body>

</html>