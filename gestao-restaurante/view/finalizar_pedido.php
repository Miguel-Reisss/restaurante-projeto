<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pedido - Celestina Point</title>
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
            --text-muted: #6c757d;
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
            padding: 15px 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
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
            align-items: center;
            padding: 12px 0;
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

        .text-muted-custom {
            color: var(--text-muted) !important;
        }
    </style>
</head>

<body>

    <div class="header mb-4">
        <a href="index.php?page=cardapio" class="btn-voltar" title="Voltar ao Cardápio"><i class="ph ph-arrow-left"></i></a>

        <img src="view/midia/logo.png" alt="Celestina Point" style="max-height: 45px; width: auto;">

       
    </div>

    <div class="container" style="max-width: 800px;">
        <h3 class="mb-4 fw-bold">Resumo do Pedido</h3>

        <div class="resumo-card">
            <h5 class="fw-bold mb-3"><i class="ph ph-shopping-bag me-2" style="color: #F4A261;"></i> Itens Selecionados</h5>
            <div id="lista-itens">
                <p class="text-muted-custom text-center py-3">Carregando itens...</p>
            </div>

            <div class="d-flex justify-content-between mt-3 pt-3" style="border-top: 2px solid var(--border-color);">
                <h4 class="fw-bold">Total:</h4>
                <h4 class="fw-bold text-success" id="total-tela" style="color: #28a745 !important;">R$ 0,00</h4>
            </div>
        </div>

        <form id="form-pedido" action="index.php?controller=pedido&action=store" method="POST">

            <div class="resumo-card">
                <h5 class="fw-bold mb-3"><i class="ph ph-armchair me-2" style="color: #F4A261;"></i> Informações da Mesa</h5>

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

            <div class="fixed-bottom p-3 shadow-lg d-flex justify-content-center align-items-center carrinho-bar">
                <div class="container" style="max-width: 800px; padding: 0;">
                    <p class="text-muted-custom small text-center mb-2">Revise seu pedido antes de enviar para a cozinha.</p>
                    <button type="submit" class="btn btn-lg w-100" style="background-color: #D32F2F; color: white; border-radius: 8px; font-weight: bold;">
                        Enviar Pedido para Cozinha <i class="ph ph-paper-plane-tilt ms-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // 1. TEMA CLARO/ESCURO
      

        
        // 2. LER O CARRINHO NO NOVO FORMATO (OBJETO)
        const listaItensDiv = document.getElementById('lista-itens');
        const totalTela = document.getElementById('total-tela');
        const inputTotal = document.getElementById('input-total');
        const formPedido = document.getElementById('form-pedido');
        const obsCliente = document.getElementById('obs-cliente');
        const inputObservacoes = document.getElementById('input-observacoes');

        // Pega o objeto salvo no localStorage
        let carrinho = JSON.parse(localStorage.getItem('carrinho_celestina')) || {};
        let total = 0;
        let resumoTexto = "Itens do Pedido:\n";

        // Verifica se o objeto está vazio
        if (Object.keys(carrinho).length === 0) {
            listaItensDiv.innerHTML = '<p class="text-danger text-center py-3">Seu carrinho está vazio! Volte ao cardápio para adicionar itens.</p>';
        } else {
            listaItensDiv.innerHTML = '';

            // Loop passando por cada item do objeto carrinho
            for (let nome in carrinho) {
                const item = carrinho[nome];
                const subtotalItem = item.preco * item.qtd;

                total += subtotalItem;

                // Monta o texto que vai para o banco de dados (ex: 2x Hambúrguer Artesanal)
                resumoTexto += `${item.qtd}x ${nome}\n`;

                // Desenha na tela (ex: 2x Hambúrguer Artesanal | R$ 71,80)
                listaItensDiv.innerHTML += `
                    <div class="item-carrinho">
                        <div>
                            <span class="fw-bold me-2" style="color: #D32F2F;">${item.qtd}x</span>
                            <span>${nome}</span>
                        </div>
                        <span class="fw-bold">R$ ${subtotalItem.toLocaleString('pt-BR', {minimumFractionDigits: 2})}</span>
                    </div>
                `;
            }

            // Atualiza os valores totais
            totalTela.innerText = total.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
            inputTotal.value = total;
        }

        // Antes de enviar o formulário
        formPedido.addEventListener('submit', function(e) {
            e.preventDefault(); // Impede o formulário de enviar para o PHP ainda!

            if (Object.keys(carrinho).length === 0) {
                alert("Adicione itens ao pedido antes de finalizar!");
                return;
            }

            // Pega o número da mesa e a observação e salva no navegador temporariamente
            const numMesa = document.querySelector('input[name="mesa_id"]').value;
            const textoObs = obsCliente.value;

            localStorage.setItem('mesa_celestina', numMesa);
            localStorage.setItem('obs_celestina', textoObs);

            // Redireciona para a nova tela de pagamento (você precisa criar essa rota no index principal, ou passar a página direta)
            window.location.href = 'index.php?page=pagamento';
        });
    </script>
</body>

</html>