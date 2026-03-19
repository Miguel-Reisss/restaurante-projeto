<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento - Celestina Point</title>
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
            --active-border: #D32F2F;
            --active-bg: rgba(211, 47, 47, 0.05);
        }

        [data-theme="dark"] {
            --bg-color: #121212;
            --text-color: #f1f1f1;
            --card-bg: #1e1e1e;
            --header-bg: #1a1a1a;
            --header-text: #D32F2F;
            --border-color: #333333;
            --text-muted: #adb5bd;
            --active-border: #D32F2F;
            --active-bg: rgba(211, 47, 47, 0.15);
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

        /* Estilos para os botões de pagamento selecionáveis */
        .payment-option {
            display: block;
            position: relative;
            cursor: pointer;
        }

        .payment-card {
            background-color: var(--card-bg);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: 0.2s;
        }

        .payment-option input[type="radio"] {
            display: none;
        }

        /* Quando o input radio é selecionado, muda a cor do card */
        .payment-option input[type="radio"]:checked+.payment-card {
            border-color: var(--active-border);
            background-color: var(--active-bg);
        }

        .payment-icon {
            font-size: 2rem;
            color: var(--active-border);
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

        /* Esconde a caixa de troco por padrão */
        #caixa-troco {
            display: none;
        }
    </style>
</head>

<body>

    <div class="header mb-4">
        <a href="index.php?page=finalizar" class="btn-voltar" title="Voltar"><i class="ph ph-arrow-left"></i></a>
        <img src="view/midia/logo.png" alt="Celestina Point" style="max-height: 45px; width: auto;">
        <button id="theme-toggle" class="btn-theme" title="Trocar Tema"><i class="ph ph-moon"></i></button>
    </div>

    <div class="container" style="max-width: 600px;">

        <div class="resumo-card text-center py-4">
            <p class="text-muted-custom mb-1 fs-5">Total a Pagar</p>
            <h1 class="fw-bold" id="valor-total-pagamento" style="color: #28a745 !important; font-size: 2.5rem;">R$ 0,00</h1>
        </div>

        <form id="form-pagamento" action="index.php?controller=pedido&action=store" method="POST">

            <input type="hidden" name="mesa_id" id="input-mesa">
            <input type="hidden" name="observacoes" id="input-obs">
            <input type="hidden" name="total" id="input-total">
            <input type="hidden" name="tipo" value="salao">
            <input type="hidden" name="status" value="aberto">

            <h4 class="fw-bold mb-3">Forma de Pagamento</h4>

            <div class="d-flex flex-column gap-3 mb-4">

                <label class="payment-option">
                    <input type="radio" name="metodo_pagamento" value="Pix" required>
                    <div class="payment-card">
                        <i class="ph ph-qr-code payment-icon"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Pix</h6>
                            <span class="text-muted-custom small">Aprovação na hora</span>
                        </div>
                    </div>
                </label>

                <label class="payment-option">
                    <input type="radio" name="metodo_pagamento" value="Cartão de Crédito">
                    <div class="payment-card">
                        <i class="ph ph-credit-card payment-icon"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Cartão de Crédito</h6>
                            <span class="text-muted-custom small">Maquininha na mesa</span>
                        </div>
                    </div>
                </label>

                <label class="payment-option">
                    <input type="radio" name="metodo_pagamento" value="Cartão de Débito">
                    <div class="payment-card">
                        <i class="ph ph-credit-card payment-icon" style="color: #F4A261;"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Cartão de Débito</h6>
                            <span class="text-muted-custom small">Maquininha na mesa</span>
                        </div>
                    </div>
                </label>

                <label class="payment-option">
                    <input type="radio" name="metodo_pagamento" value="Dinheiro" id="radio-dinheiro">
                    <div class="payment-card">
                        <i class="ph ph-money payment-icon" style="color: #28a745;"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Dinheiro</h6>
                            <span class="text-muted-custom small">Pagamento em espécie</span>
                        </div>
                    </div>
                </label>

                <div id="caixa-troco" class="resumo-card mt-2 p-3" style="background-color: var(--bg-color);">
                    <label class="form-label fw-bold small">Precisa de troco para quanto?</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" class="form-control" id="valor-troco" name="troco_para" placeholder="Ex: 50,00" step="0.01">
                    </div>
                    <span class="text-muted-custom" style="font-size: 0.75rem;">Deixe em branco se não precisar de troco.</span>
                </div>

            </div>

            <div class="fixed-bottom p-3 shadow-lg d-flex justify-content-center align-items-center carrinho-bar">
                <div class="container" style="max-width: 600px; padding: 0;">
                    <button type="submit" class="btn btn-lg w-100" style="background-color: #28a745; color: white; border-radius: 8px; font-weight: bold;">
                        Concluir e Enviar Pedido <i class="ph ph-check-circle ms-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // 1. TEMA
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

        // 2. RECUPERA OS DADOS DA TELA ANTERIOR
        // Vamos pegar o carrinho pra calcular o total exato
        let carrinho = JSON.parse(localStorage.getItem('carrinho_celestina')) || {};
        let total = 0;
        let resumoTexto = "Itens do Pedido:\n";

        for (let nome in carrinho) {
            total += carrinho[nome].preco * carrinho[nome].qtd;
            resumoTexto += `${carrinho[nome].qtd}x ${nome}\n`;
        }

        // Mostra o total na tela
        document.getElementById('valor-total-pagamento').innerText = total.toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });
        document.getElementById('input-total').value = total;

        // Pega as observações e mesa do LocalStorage que salvamos na tela de "Finalizar"
        const mesaCliente = localStorage.getItem('mesa_celestina') || 'Mesa não informada';
        const obsCliente = localStorage.getItem('obs_celestina') || '';

        document.getElementById('input-mesa').value = mesaCliente;

        // Junta os itens com as observações e método de pagamento
        document.getElementById('input-obs').value = resumoTexto + (obsCliente ? `\nObs: ${obsCliente}` : '');

        // 3. LÓGICA DO TROCO (Aparece só quando clica em dinheiro)
        const radios = document.querySelectorAll('input[name="metodo_pagamento"]');
        const caixaTroco = document.getElementById('caixa-troco');

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'Dinheiro') {
                    caixaTroco.style.display = 'block';
                } else {
                    caixaTroco.style.display = 'none';
                    document.getElementById('valor-troco').value = ''; // Limpa o troco se mudar de ideia
                }
            });
        });

        // 4. ENVIO FINAL
        document.getElementById('form-pagamento').addEventListener('submit', function(e) {
            // Pega qual foi o método selecionado
            const metodo = document.querySelector('input[name="metodo_pagamento"]:checked').value;
            const troco = document.getElementById('valor-troco').value;

            // Adiciona o método de pagamento nas observações para o Cozinheiro/Caixa ver
            let infoPagamento = `\n\nPagamento: ${metodo}`;
            if (metodo === 'Dinheiro' && troco) {
                infoPagamento += ` (Troco para R$ ${troco})`;
            }

            document.getElementById('input-obs').value += infoPagamento;

            // Limpa o carrinho e dados locais após enviar
            localStorage.removeItem('carrinho_celestina');
            localStorage.removeItem('mesa_celestina');
            localStorage.removeItem('obs_celestina');
        });
    </script>
</body>

</html>