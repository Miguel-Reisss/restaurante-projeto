<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio - Sabor & Tempo</title>
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
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: sans-serif;
            padding-bottom: 100px;
            transition: background-color 0.3s, color 0.3s;
            margin: 0;
        }

        /* Cabeçalho */
        .header {
            background-color: var(--header-bg);
            color: var(--header-text);
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            transition: background-color 0.3s;
        }

        .header h2 {
            margin: 0;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
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
        .input-group-text {
            background-color: var(--card-bg);
            color: var(--text-color);
            border-color: var(--border-color);
        }

        .form-control:focus {
            background-color: var(--card-bg);
            color: var(--text-color);
            box-shadow: none;
            border-color: var(--btn-add-bg);
        }

        /* Categorias e Imagens */
        .categoria-titulo {
            margin-top: 2rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 10px;
            font-weight: 600;
        }

        /* Estilo para a imagem do produto */
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
            /* Reduzi o padding interno para acomodar a imagem melhor */
        }

        .produto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .preco {
            color: #D32F2F;
            font-weight: bold;
            font-size: 1.3rem;
            margin-top: auto;
        }

        .btn-add {
            background-color: var(--btn-add-bg);
            border: none;
            color: white;
            font-weight: bold;
            width: 100%;
            border-radius: 8px;
            padding: 12px;
            margin-top: 15px;
            transition: all 0.3s;
        }

        .btn-add:hover {
            background-color: var(--btn-add-hover);
            color: white;
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
        <a href="index.php?page=home" class="btn-voltar" title="Voltar ao Início"><i class="ph ph-arrow-left"></i></a>
        <h2><i class="ph ph-cooking-pot" style="color: #F4A261;"></i> <b>SABOR</b> <span style="font-weight: 300;">& TEMPO</span></h2>
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

        <h3 class="categoria-titulo">🍔 Lanches & Porções</h3>
        <div class="row g-4 justify-content-center">

            <div class="col-12 col-md-6 col-lg-4">
                <div class="produto-card">
                    <img src="https://via.placeholder.com/400x200?text=Foto+Hamburguer" alt="Hambúrguer Artesanal" class="produto-img">

                    <h5 class="fw-bold fs-5">Hambúrguer Artesanal</h5>
                    <p class="opacity-75 small mt-1 mb-3">Pão brioche, blend 180g, queijo cheddar, bacon crocante e maionese da casa.</p>
                    <div class="preco">R$ 35,90</div>
                    <button class="btn btn-add btn-adicionar" data-preco="35.90"><i class="ph ph-plus-circle me-1"></i> Adicionar</button>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="produto-card">
                    <img src="https://via.placeholder.com/400x200?text=Foto+Batata" alt="Porção de Fritas" class="produto-img">

                    <h5 class="fw-bold fs-5">Porção de Fritas</h5>
                    <p class="opacity-75 small mt-1 mb-3">Batatas rústicas fritas na hora acompanhadas de molho de alho.</p>
                    <div class="preco">R$ 22,50</div>
                    <button class="btn btn-add btn-adicionar" data-preco="22.50"><i class="ph ph-plus-circle me-1"></i> Adicionar</button>
                </div>
            </div>

        </div>

        <h3 class="categoria-titulo">🥤 Bebidas</h3>
        <div class="row g-4 justify-content-center">

            <div class="col-12 col-md-6 col-lg-4">
                <div class="produto-card">
                    <img src="https://via.placeholder.com/400x200?text=Foto+Refrigerante" alt="Refrigerante Lata" class="produto-img">

                    <h5 class="fw-bold fs-5">Refrigerante Lata</h5>
                    <p class="opacity-75 small mt-1 mb-3">Coca-Cola, Guaraná ou Sprite (350ml).</p>
                    <div class="preco">R$ 7,00</div>
                    <button class="btn btn-add btn-adicionar" data-preco="7.00"><i class="ph ph-plus-circle me-1"></i> Adicionar</button>
                </div>
            </div>

        </div>
        <br><br>
    </div>

    <div class="fixed-bottom p-3 shadow-lg d-flex justify-content-between align-items-center carrinho-bar">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span class="opacity-75">Total do Pedido:</span>
                <h3 id="valor-total" class="mb-0 fw-bold" style="color: #28a745 !important;">R$ 0,00</h3>
            </div>
            <button class="btn btn-lg" style="background-color: #D32F2F; color: white; border-radius: 8px; font-weight: bold;">
                Finalizar Pedido <i class="ph ph-arrow-right ms-2"></i>
            </button>
        </div>
    </div>

    <script>
        // 1. LÓGICA DO TEMA CLARO/ESCURO
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeIcon = themeToggleBtn.querySelector('i');
        const htmlElement = document.documentElement;

        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
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

        // 2. LÓGICA DO CARRINHO DE COMPRAS
        // Inicia o carrinho buscando do localStorage (caso o cliente tenha voltado a página)
        let carrinho = JSON.parse(localStorage.getItem('carrinho')) || [];
        let totalCarrinho = 0;

        const totalElement = document.getElementById('valor-total');
        const botoesAdicionar = document.querySelectorAll('.btn-adicionar');

        // Função para recalcular e mostrar o total na tela
        function atualizarTelaTotal() {
            totalCarrinho = carrinho.reduce((soma, item) => soma + item.preco, 0);
            totalElement.innerText = totalCarrinho.toLocaleString('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
        }

        // Atualiza a tela logo que a página carrega
        atualizarTelaTotal();

        // Clique no botão de adicionar
        botoesAdicionar.forEach(botao => {
            botao.addEventListener('click', function() {
                // Pega os dados do produto (O h5 fica dentro do mesmo produto-card do botão)
                const card = this.closest('.produto-card');
                const nomeProduto = card.querySelector('h5').innerText;
                const precoProduto = parseFloat(this.getAttribute('data-preco'));

                // Adiciona no array e salva no navegador
                carrinho.push({
                    nome: nomeProduto,
                    preco: precoProduto
                });
                localStorage.setItem('carrinho', JSON.stringify(carrinho));

                // Atualiza o valor lá embaixo
                atualizarTelaTotal();

                // Efeito visual bonitinho
                const textoOriginal = this.innerHTML;
                this.innerHTML = '<i class="ph ph-check-circle me-1"></i> Adicionado';
                this.style.backgroundColor = '#28a745';

                setTimeout(() => {
                    this.innerHTML = textoOriginal;
                    this.style.backgroundColor = '';
                }, 1000);
            });
        });

        // 3. BOTÃO DE IR PARA A FINALIZAÇÃO
        // Adicione um id="btn-ir-finalizar" no seu botão vermelho lá no HTML do cardápio!
        document.querySelector('.carrinho-bar .btn-lg').addEventListener('click', () => {
            if (carrinho.length === 0) {
                alert("Selecione pelo menos um item para continuar.");
            } else {
                window.location.href = 'index.php?page=finalizar';
            }
        });
    </script>
</body>

</html>