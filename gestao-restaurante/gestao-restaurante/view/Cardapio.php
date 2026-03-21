<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio - Celestina Point</title>
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
            --btn-add-bg: #F4A261;
            --btn-add-hover: #e09150;
            --offcanvas-bg: #ffffff;
            --text-muted-cor: #6c757d;
        }

        [data-theme="dark"] {
            --bg-color: #121212;
            --text-color: #f1f1f1;
            --card-bg: #1e1e1e;
            --header-bg: #1a1a1a;
            --header-text: #D32F2F;
            --border-color: #333333;
            --btn-add-bg: #D32F2F;
            --btn-add-hover: #b71c1c;
            --offcanvas-bg: #1e1e1e;
            --text-muted-cor: #adb5bd;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: sans-serif;
            padding-bottom: 110px;
            transition: background-color 0.3s, color 0.3s;
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
            transition: background-color 0.3s;
        }

        .btn-voltar,
        .btn-theme {
            background: transparent;
            border: none;
            color: var(--header-text);
            font-size: 1.5rem;
            cursor: pointer;
            transition: transform 0.2s;
            position: absolute;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .btn-voltar {
            left: 20px;
        }

        .btn-voltar:hover {
            transform: scale(1.1);
            color: var(--header-text);
        }

        .btn-theme {
            right: 20px;
        }

        .btn-theme:hover {
            transform: scale(1.1);
        }

        .form-control,
        .input-group-text,
        .form-select {
            background-color: var(--card-bg);
            color: var(--text-color);
            border-color: var(--border-color);
        }

        .form-control:focus,
        .form-select:focus {
            background-color: var(--card-bg);
            color: var(--text-color);
            box-shadow: none;
            border-color: var(--btn-add-bg);
        }

        .categoria-titulo {
            margin-top: 2.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 10px;
            font-weight: 600;
        }

        .produto-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
            margin-bottom: 15px;
        }

        .produto-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border-color);
            padding: 15px;
        }

        .produto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .preco {
            color: #D32F2F;
            font-weight: bold;
            font-size: 1.3rem;
            margin-top: 5px;
        }

        .controle-qtd {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 5px;
            margin-top: 15px;
        }

        .btn-qtd {
            background-color: var(--btn-add-bg);
            color: white;
            border: none;
            border-radius: 6px;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            transition: 0.2s;
        }

        .btn-qtd:hover {
            background-color: var(--btn-add-hover);
        }

        .btn-qtd.minus {
            background-color: #6c757d;
        }

        .btn-qtd.minus:hover {
            background-color: #5a6268;
        }

        .qtd-numero {
            font-weight: bold;
            font-size: 1.2rem;
            width: 40px;
            text-align: center;
        }

        .carrinho-bar {
            background-color: var(--card-bg);
            border-top: 1px solid var(--border-color);
            z-index: 1000;
        }

        .offcanvas {
            background-color: var(--offcanvas-bg);
            color: var(--text-color);
        }

        .offcanvas-header {
            border-bottom: 1px solid var(--border-color);
        }

        .item-lateral {
            border-bottom: 1px dashed var(--border-color);
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .item-lateral:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        [data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .texto-legivel {
            color: var(--text-muted-cor) !important;
        }
    </style>
</head>

<body>

    <div class="header mb-4">
        <a href="index.php?page=home" class="btn-voltar" title="Voltar ao Início"><i class="ph ph-arrow-left"></i></a>
        <img src="view/midia/logo.png" alt="Celestina Point" style="max-height: 45px; width: auto;">
        <button id="theme-toggle" class="btn-theme" title="Trocar Tema"><i class="ph ph-moon"></i></button>
    </div>

    <div class="container" style="max-width: 1200px;">
        <div class="row mb-2">
            <div class="col-md-8 mx-auto">
                <div class="input-group input-group-lg shadow-sm">
                    <span class="input-group-text border-end-0 bg-transparent"><i class="ph ph-magnifying-glass"></i></span>
                    <input type="text" class="form-control border-start-0 bg-transparent" placeholder="Buscar prato, bebida...">
                </div>
            </div>
        </div>

        <h3 class="categoria-titulo">🍔 Lanches Especiais</h3>
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="produto-card">
                    <img src="view/midia/artesanal.png" class="produto-img">
                    <h5 class="fw-bold fs-5">Hambúrguer Artesanal</h5>
                    <p class="texto-legivel small mt-1 mb-2 flex-grow-1">Pão brioche, blend 180g, queijo cheddar, bacon crocante e maionese da casa.</p>
                    <div class="preco">R$ 35,90</div>
                    <div class="controle-qtd">
                        <button class="btn-qtd minus" data-nome="Hambúrguer Artesanal">-</button>
                        <span class="qtd-numero" data-nome="Hambúrguer Artesanal">0</span>
                        <button class="btn-qtd plus" data-nome="Hambúrguer Artesanal" data-preco="35.90">+</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="produto-card">
                    <img src="view/midia/smash.png" class="produto-img">
                    <h5 class="fw-bold fs-5">Smash Burger Duplo</h5>
                    <p class="texto-legivel small mt-1 mb-2 flex-grow-1">Pão australiano, 2 blends smash 90g, dobro de cheddar e cebola caramelizada.</p>
                    <div class="preco">R$ 32,50</div>
                    <div class="controle-qtd">
                        <button class="btn-qtd minus" data-nome="Smash Burger Duplo">-</button>
                        <span class="qtd-numero" data-nome="Smash Burger Duplo">0</span>
                        <button class="btn-qtd plus" data-nome="Smash Burger Duplo" data-preco="32.50">+</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="produto-card">
                    <img src="view/midia/chicken.png" class="produto-img">
                    <h5 class="fw-bold fs-5">Chicken Crispy</h5>
                    <p class="texto-legivel small mt-1 mb-2 flex-grow-1">Pão tradicional, filé de frango empanado crocante, alface e maionese verde.</p>
                    <div class="preco">R$ 28,90</div>
                    <div class="controle-qtd">
                        <button class="btn-qtd minus" data-nome="Chicken Crispy">-</button>
                        <span class="qtd-numero" data-nome="Chicken Crispy">0</span>
                        <button class="btn-qtd plus" data-nome="Chicken Crispy" data-preco="28.90">+</button>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="categoria-titulo">🍟 Porções</h3>
        <div class="row g-4 justify-content-center">

            <div class="col-12 col-md-6 col-lg-4">
                <div class="produto-card dinâmico" data-nome-base="Batata Frita">
                    <img src="view/midia/batata.png" class="produto-img">
                    <h5 class="fw-bold fs-5">Batata Frita Tradicional</h5>
                    <p class="texto-legivel small mt-1 mb-2 flex-grow-1">Porção de batatas palito sequinhas e crocantes.</p>

                    <select class="form-select form-select-sm mb-2 select-tamanho">
                        <option value="P" data-preco="15.00">Tamanho P</option>
                        <option value="M" data-preco="22.50" selected>Tamanho M</option>
                        <option value="G" data-preco="30.00">Tamanho G</option>
                    </select>

                    <div class="preco">R$ 22,50</div>
                    <div class="controle-qtd">
                        <button class="btn-qtd minus">-</button>
                        <span class="qtd-numero">0</span>
                        <button class="btn-qtd plus">+</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="produto-card dinâmico" data-nome-base="Fritas Cheddar & Bacon">
                    <img src="view/midia/batata_cheddar.png" class="produto-img">
                    <h5 class="fw-bold fs-5">Fritas Cheddar & Bacon</h5>
                    <p class="texto-legivel small mt-1 mb-2 flex-grow-1">Coberta com muito creme de cheddar e cubos de bacon.</p>

                    <select class="form-select form-select-sm mb-2 select-tamanho">
                        <option value="P" data-preco="25.00">Tamanho P</option>
                        <option value="M" data-preco="34.90" selected>Tamanho M</option>
                        <option value="G" data-preco="45.00">Tamanho G</option>
                    </select>

                    <div class="preco">R$ 34,90</div>
                    <div class="controle-qtd">
                        <button class="btn-qtd minus">-</button>
                        <span class="qtd-numero">0</span>
                        <button class="btn-qtd plus">+</button>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="categoria-titulo">🥤 Bebidas & Sucos</h3>
        <div class="row g-4 justify-content-center">

            <div class="col-12 col-md-6 col-lg-4">
                <div class="produto-card dinâmico" data-nome-base="Coca-Cola">
                    <img src="view/midia/coca.png" class="produto-img">
                    <h5 class="fw-bold fs-5">Coca-Cola</h5>
                    <p class="texto-legivel small mt-1 mb-2 flex-grow-1">Refrigerante Coca-Cola (Original ou Zero).</p>

                    <select class="form-select form-select-sm mb-2 select-tamanho">
                        <option value="P (Lata 250ml)" data-preco="7.00" selected>Tamanho P (Lata 350ml)</option>
                        <option value="M (600ml)" data-preco="10.00">Tamanho M (600ml)</option>
                        <option value="G (2L)" data-preco="16.00">Tamanho G (2 Litros)</option>
                    </select>

                    <div class="preco">R$ 7,00</div>
                    <div class="controle-qtd">
                        <button class="btn-qtd minus">-</button>
                        <span class="qtd-numero">0</span>
                        <button class="btn-qtd plus">+</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="produto-card dinâmico" data-nome-base="Suco Natural">
                    <img src="view/midia/suco.png" class="produto-img">
                    <h5 class="fw-bold fs-5">Sucos Naturais</h5>
                    <p class="texto-legivel small mt-1 mb-2 flex-grow-1">Laranja, Limão ou Maracujá (Especifique o sabor depois).</p>

                    <select class="form-select form-select-sm mb-2 select-tamanho">
                        <option value="P" data-preco="8.00">Tamanho P (300ml)</option>
                        <option value="M" data-preco="12.00" selected>Tamanho M (500ml)</option>
                        <option value="G" data-preco="20.00">Tamanho G (Jarra 1L)</option>
                    </select>

                    <div class="preco">R$ 12,00</div>
                    <div class="controle-qtd">
                        <button class="btn-qtd minus">-</button>
                        <span class="qtd-numero">0</span>
                        <button class="btn-qtd plus">+</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="produto-card dinâmico" data-nome-base="Água Mineral">
                    <img src="view/midia/agua.png" class="produto-img">
                    <h5 class="fw-bold fs-5">Água Mineral</h5>
                    <p class="texto-legivel small mt-1 mb-2 flex-grow-1">Com ou sem gás.</p>

                    <select class="form-select form-select-sm mb-2 select-tamanho">
                        <option value="P (500ml)" data-preco="5.00" selected>Tamanho P (500ml)</option>
                        <option value="G (1.5L)" data-preco="9.00">Tamanho G (1.5L)</option>
                    </select>

                    <div class="preco">R$ 5,00</div>
                    <div class="controle-qtd">
                        <button class="btn-qtd minus">-</button>
                        <span class="qtd-numero">0</span>
                        <button class="btn-qtd plus">+</button>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
    </div>

    <div class="fixed-bottom p-3 shadow-lg d-flex justify-content-between align-items-center carrinho-bar">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span class="opacity-75 d-block" style="font-size: 0.9rem;">
                    <i class="ph ph-shopping-cart"></i> <span id="qtd-total-itens">0</span> itens selecionados
                </span>
                <h3 id="valor-total" class="mb-0 fw-bold" style="color: #28a745 !important;">R$ 0,00</h3>
            </div>
            <button id="btn-abrir-lateral" class="btn btn-lg" style="background-color: #D32F2F; color: white; border-radius: 8px; font-weight: bold;">
                Ver Pedido <i class="ph ph-list-bullets ms-2"></i>
            </button>
        </div>
    </div>

    <div class="offcanvas offcanvas-end shadow-lg" tabindex="-1" id="abaCarrinho" aria-labelledby="abaCarrinhoLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title fw-bold" id="abaCarrinhoLabel">
                <i class="ph ph-shopping-bag me-2" style="color: #F4A261;"></i> Seu Pedido
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>

        <div class="offcanvas-body d-flex flex-column">
            <div id="itens-carrinho-lateral" class="flex-grow-1 overflow-auto pe-2">
                <p class="texto-legivel mt-3 text-center">Seu carrinho está vazio.</p>
            </div>

            <div class="mt-auto border-top pt-3" style="border-color: var(--border-color) !important;">
                <div class="d-flex justify-content-between mb-3">
                    <span class="fw-bold fs-5">Total a pagar:</span>
                    <span class="fw-bold fs-5 text-success" id="total-lateral">R$ 0,00</span>
                </div>

                <p class="texto-legivel small text-center mb-3">Revise seu pedido. Você poderá adicionar a mesa na próxima tela.</p>

                <button id="btn-confirmar-final" class="btn btn-lg w-100" style="background-color: #28a745; color: white; border-radius: 8px; font-weight: bold;">
                    Confirmar e Avançar <i class="ph ph-arrow-right ms-2"></i>
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // LÓGICA DO TEMA CLARO/ESCURO
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

        // LÓGICA DO CARRINHO E SELECT DE TAMANHOS
        let carrinho = JSON.parse(localStorage.getItem('carrinho_celestina')) || {};
        const offcanvas = new bootstrap.Offcanvas(document.getElementById('abaCarrinho'));

        // Função que configura o Card com base no tamanho (P, M, G) selecionado
        function atualizarCardDinamico(card) {
            const select = card.querySelector('.select-tamanho');
            if (!select) return;

            const option = select.options[select.selectedIndex];
            const tamanho = option.value;
            const preco = parseFloat(option.getAttribute('data-preco'));
            const nomeBase = card.getAttribute('data-nome-base');
            const nomeCompleto = `${nomeBase} (${tamanho})`;

            // Atualiza preço visível
            card.querySelector('.preco').innerText = preco.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });

            // Atualiza botões
            const btnPlus = card.querySelector('.btn-qtd.plus');
            const btnMinus = card.querySelector('.btn-qtd.minus');
            const spanQtd = card.querySelector('.qtd-numero');

            btnPlus.setAttribute('data-nome', nomeCompleto);
            btnPlus.setAttribute('data-preco', preco);
            btnMinus.setAttribute('data-nome', nomeCompleto);
            spanQtd.setAttribute('data-nome', nomeCompleto);

            // Mostra no span a quantidade que tem no carrinho para AQUELE tamanho
            const qtdNoCarrinho = carrinho[nomeCompleto] ? carrinho[nomeCompleto].qtd : 0;
            spanQtd.innerText = qtdNoCarrinho;
        }

        // Detectar mudança nos selects de tamanho
        document.querySelectorAll('.select-tamanho').forEach(select => {
            select.addEventListener('change', function() {
                atualizarCardDinamico(this.closest('.produto-card'));
            });
        });

        // Atualiza interface principal (somas do rodapé)
        function atualizarTelaTotal() {
            let total = 0;
            let totalItens = 0;

            // Atualiza spans de acordo com o item que ele representa
            document.querySelectorAll('.qtd-numero').forEach(span => {
                const nome = span.getAttribute('data-nome');
                const qtd = carrinho[nome] ? carrinho[nome].qtd : 0;
                span.innerText = qtd;
            });

            for (let nome in carrinho) {
                total += carrinho[nome].preco * carrinho[nome].qtd;
                totalItens += carrinho[nome].qtd;
            }

            document.getElementById('valor-total').innerText = total.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
            document.getElementById('qtd-total-itens').innerText = totalItens;

            localStorage.setItem('carrinho_celestina', JSON.stringify(carrinho));
        }

        // Renderiza itens dentro da Aba Lateral
        function renderizarAbaLateral() {
            const container = document.getElementById('itens-carrinho-lateral');
            container.innerHTML = '';
            let total = 0;

            for (let nome in carrinho) {
                const item = carrinho[nome];
                total += item.preco * item.qtd;

                container.innerHTML += `
                    <div class="item-lateral">
                        <div class="d-flex justify-content-between fw-bold mb-1">
                            <span>${nome}</span>
                            <span>R$ ${(item.preco * item.qtd).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="texto-legivel small">R$ ${item.preco.toLocaleString('pt-BR', {minimumFractionDigits: 2})} (cada)</span>
                            <div class="controle-qtd" style="margin-top: 0; padding: 2px;">
                                <button class="btn-qtd minus btn-lateral-menos" data-nome="${nome}" style="width: 25px; height: 25px;">-</button>
                                <span class="qtd-numero" style="width: 30px; font-size: 1rem;">${item.qtd}</span>
                                <button class="btn-qtd plus btn-lateral-mais" data-nome="${nome}" style="width: 25px; height: 25px;">+</button>
                            </div>
                        </div>
                    </div>
                `;
            }

            if (Object.keys(carrinho).length === 0) {
                container.innerHTML = '<p class="texto-legivel mt-3 text-center">Seu carrinho está vazio.</p>';
            }

            document.getElementById('total-lateral').innerText = total.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });

            // Re-liga botões da aba lateral
            document.querySelectorAll('.btn-lateral-mais').forEach(btn => {
                btn.addEventListener('click', function() {
                    carrinho[this.getAttribute('data-nome')].qtd++;
                    atualizarTudo();
                });
            });

            document.querySelectorAll('.btn-lateral-menos').forEach(btn => {
                btn.addEventListener('click', function() {
                    const nome = this.getAttribute('data-nome');
                    carrinho[nome].qtd--;
                    if (carrinho[nome].qtd <= 0) delete carrinho[nome];

                    atualizarTudo();
                    if (Object.keys(carrinho).length === 0) offcanvas.hide();
                });
            });
        }

        function atualizarTudo() {
            // Executa para garantir que cards dinâmicos estão com o data-nome certo antes de atualizar o total
            document.querySelectorAll('.produto-card.dinâmico').forEach(card => atualizarCardDinamico(card));
            atualizarTelaTotal();
            renderizarAbaLateral();
        }

        // Executa ao carregar a página
        atualizarTudo();

        // Clique no + da tela principal
        document.querySelectorAll('.produto-card .btn-qtd.plus').forEach(btn => {
            btn.addEventListener('click', function() {
                const nome = this.getAttribute('data-nome');
                const preco = parseFloat(this.getAttribute('data-preco'));
                if (!carrinho[nome]) carrinho[nome] = {
                    preco: preco,
                    qtd: 0
                };
                carrinho[nome].qtd++;
                atualizarTudo();
            });
        });

        // Clique no - da tela principal
        document.querySelectorAll('.produto-card .btn-qtd.minus').forEach(btn => {
            btn.addEventListener('click', function() {
                const nome = this.getAttribute('data-nome');
                if (carrinho[nome] && carrinho[nome].qtd > 0) {
                    carrinho[nome].qtd--;
                    if (carrinho[nome].qtd === 0) delete carrinho[nome];
                }
                atualizarTudo();
            });
        });

        document.getElementById('btn-abrir-lateral').addEventListener('click', () => {
            if (Object.keys(carrinho).length === 0) {
                alert("Adicione pelo menos um lanche ou bebida primeiro!");
            } else {
                renderizarAbaLateral();
                offcanvas.show();
            }
        });

        document.getElementById('btn-confirmar-final').addEventListener('click', () => {
            if (Object.keys(carrinho).length > 0) {
                window.location.href = 'index.php?page=finalizar';
            }
        });
    </script>
</body>

</html>