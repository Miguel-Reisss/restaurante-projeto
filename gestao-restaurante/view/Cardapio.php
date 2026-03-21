<?php
require_once 'config/conexao.php';
$pdo = Conexao::getConnection();

// Busca as categorias ativas
$stmtCat = $pdo->query("SELECT * FROM categorias ORDER BY id ASC");
$categorias = $stmtCat->fetchAll();

// Busca os produtos ativos do banco
$stmtProd = $pdo->query("SELECT * FROM produtos WHERE ativo = 1");
$produtos = $stmtProd->fetchAll();

$cardapioAgrupado = [];
foreach ($produtos as $p) {
    $cardapioAgrupado[$p['categoria_id']][] = $p;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio - Celestina Point</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root { --bg-color: #F8F9FA; --text-color: #2B2D42; --card-bg: #ffffff; --header-bg: #D32F2F; --header-text: #ffffff; --border-color: #dee2e6; --btn-add-bg: #F4A261; --btn-add-hover: #e09150; --offcanvas-bg: #ffffff; --text-muted-cor: #6c757d; }
        body { background-color: var(--bg-color); color: var(--text-color); font-family: sans-serif; padding-bottom: 110px; margin: 0; }
        .header { background-color: var(--header-bg); color: var(--header-text); padding: 15px 20px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); display: flex; justify-content: center; align-items: center; position: relative; }
        .btn-voltar { background: transparent; border: none; color: var(--header-text); font-size: 1.5rem; position: absolute; left: 20px; text-decoration: none; display: flex; align-items: center; transition: 0.2s; }
        .btn-voltar:hover { transform: scale(1.1); color: var(--header-text); }
        .form-control, .input-group-text, .form-select { background-color: var(--card-bg); color: var(--text-color); border-color: var(--border-color); }
        .form-control:focus, .form-select:focus { box-shadow: none; border-color: var(--btn-add-bg); }
        .categoria-titulo { margin-top: 2.5rem; margin-bottom: 1.5rem; border-bottom: 2px solid var(--border-color); padding-bottom: 10px; font-weight: 600; text-transform: uppercase; color: #D32F2F; }
        .produto-img { width: 100%; height: 180px; object-fit: cover; border-radius: 8px 8px 0 0; margin-bottom: 15px; }
        .produto-card { background-color: var(--card-bg); border-radius: 12px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); transition: 0.3s; height: 100%; display: flex; flex-direction: column; border: 1px solid var(--border-color); padding: 15px; }
        .produto-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); }
        .preco { color: #D32F2F; font-weight: bold; font-size: 1.3rem; margin-top: 5px; }
        .controle-qtd { display: flex; align-items: center; justify-content: space-between; background-color: var(--bg-color); border: 1px solid var(--border-color); border-radius: 8px; padding: 5px; margin-top: 15px; }
        .btn-qtd { background-color: var(--btn-add-bg); color: white; border: none; border-radius: 6px; width: 35px; height: 35px; font-weight: bold; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; transition: 0.2s; }
        .btn-qtd:hover { background-color: var(--btn-add-hover); }
        .btn-qtd.minus { background-color: #6c757d; }
        .btn-qtd.minus:hover { background-color: #5a6268; }
        .qtd-numero { font-weight: bold; font-size: 1.2rem; width: 40px; text-align: center; }
        .carrinho-bar { background-color: var(--card-bg); border-top: 1px solid var(--border-color); z-index: 1000; }
        .texto-legivel { color: var(--text-muted-cor) !important; }
    </style>
</head>
<body>

    <div class="header mb-4">
        <a href="index.php?page=home" class="btn-voltar" title="Voltar ao Início"><i class="ph ph-arrow-left"></i></a>
        <img src="view/midia/logo.png" alt="Celestina Point" style="max-height: 45px; width: auto;">
    </div>

    <div class="container" style="max-width: 1200px;">
        
        <?php foreach ($categorias as $cat): ?>
            <?php 
            // Verifica se tem item do banco OU se é uma das categorias que têm itens fixos (ID 1, 2 ou 3)
            $temDinamico = isset($cardapioAgrupado[$cat['id']]);
            $temFixo = in_array($cat['id'], [1, 2, 3]);

            if ($temDinamico || $temFixo): 
            ?>
                <h3 class="categoria-titulo"><?= htmlspecialchars($cat['nome']) ?></h3>
                
                <div class="row g-4 justify-content-center mb-4">
                    
                    <?php if ($temDinamico): ?>
                        <?php foreach ($cardapioAgrupado[$cat['id']] as $p): ?>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="produto-card">
                                    <img src="view/midia/uploads/<?= htmlspecialchars($p['imagem'] ?? 'placeholder.png') ?>" class="produto-img" onerror="this.src='view/midia/logo.png'">
                                    <h5 class="fw-bold fs-5"><?= htmlspecialchars($p['nome']) ?></h5>
                                    <p class="texto-legivel small mt-1 mb-2 flex-grow-1"><?= htmlspecialchars($p['descricao']) ?></p>
                                    <div class="preco">R$ <?= number_format((float)$p['preco'], 2, ',', '.') ?></div>
                                    <div class="controle-qtd">
                                        <button class="btn-qtd minus btn-simples" data-nome="<?= htmlspecialchars($p['nome']) ?>">-</button>
                                        <span class="qtd-numero" data-nome="<?= htmlspecialchars($p['nome']) ?>">0</span>
                                        <button class="btn-qtd plus btn-simples" data-nome="<?= htmlspecialchars($p['nome']) ?>" data-preco="<?= $p['preco'] ?>">+</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if ($cat['id'] == 1): // Se for a categoria Lanches Especiais ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="produto-card">
                                <img src="view/midia/artesanal.png" class="produto-img" onerror="this.src='view/midia/logo.png'">
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
                    <?php endif; ?>

                    <?php if ($cat['id'] == 2): // Se for a categoria Porções ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="produto-card dinâmico" data-nome-base="Batata Frita Tradicional">
                                <img src="view/midia/batata.png" class="produto-img" onerror="this.src='view/midia/logo.png'">
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
                                <img src="view/midia/batata_cheddar.png" class="produto-img" onerror="this.src='view/midia/logo.png'">
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
                    <?php endif; ?>

                    <?php if ($cat['id'] == 3): // Se for a categoria Bebidas ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="produto-card dinâmico" data-nome-base="Coca-Cola">
                                <img src="view/midia/coca.png" class="produto-img" alt="Coca-Cola" onerror="this.src='view/midia/logo.png'">
                                <h5 class="fw-bold fs-5">Coca-Cola</h5>
                                <p class="texto-legivel small mt-1 mb-2 flex-grow-1">Escolha a versão e o tamanho.</p>
                                <select class="form-select form-select-sm mb-2 select-sabor">
                                    <option value="Original" selected>Original</option>
                                    <option value="Zero">Zero</option>
                                </select>
                                <select class="form-select form-select-sm mb-2 select-tamanho">
                                    <option value="Lata" data-preco="7.00" selected>Lata (350ml)</option>
                                    <option value="600ml" data-preco="10.00">Garrafa (600ml)</option>
                                    <option value="2 Litros" data-preco="16.00">Garrafa (2 Litros)</option>
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
                            <div class="produto-card dinâmico" data-nome-base="Suco">
                                <img src="view/midia/suco.png" class="produto-img" alt="Sucos Naturais" onerror="this.src='view/midia/logo.png'">
                                <h5 class="fw-bold fs-5">Sucos Naturais</h5>
                                <p class="texto-legivel small mt-1 mb-2 flex-grow-1">Sucos feitos na hora, 100% da fruta.</p>
                                <select class="form-select form-select-sm mb-2 select-sabor">
                                    <option value="de Laranja" selected>Laranja</option>
                                    <option value="de Limão">Limão</option>
                                    <option value="de Maracujá">Maracujá</option>
                                </select>
                                <select class="form-select form-select-sm mb-2 select-tamanho">
                                    <option value="P" data-preco="8.00">Copo P (300ml)</option>
                                    <option value="M" data-preco="12.00" selected>Copo M (500ml)</option>
                                    <option value="G" data-preco="20.00">Jarra G (1 Litro)</option>
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
                                <img src="view/midia/agua.png" class="produto-img" alt="Água Mineral" onerror="this.src='view/midia/logo.png'">
                                <h5 class="fw-bold fs-5">Água Mineral</h5>
                                <p class="texto-legivel small mt-1 mb-2 flex-grow-1">Garrafinha bem gelada.</p>
                                <select class="form-select form-select-sm mb-2 select-sabor">
                                    <option value="Sem Gás" selected>Sem Gás</option>
                                    <option value="Com Gás">Com Gás</option>
                                </select>
                                <select class="form-select form-select-sm mb-2 select-tamanho">
                                    <option value="500ml" data-preco="5.00" selected>Garrafa (500ml)</option>
                                    <option value="1.5L" data-preco="9.00">Garrafa (1.5 Litros)</option>
                                </select>
                                <div class="preco">R$ 5,00</div>
                                <div class="controle-qtd">
                                    <button class="btn-qtd minus">-</button>
                                    <span class="qtd-numero">0</span>
                                    <button class="btn-qtd plus">+</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div> <?php endif; ?>
        <?php endforeach; ?>

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

    <div class="offcanvas offcanvas-end shadow-lg" tabindex="-1" id="abaCarrinho">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold"><i class="ph ph-shopping-bag me-2" style="color: #F4A261;"></i> Seu Pedido</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <div id="itens-carrinho-lateral" class="flex-grow-1 overflow-auto pe-2"></div>
            <div class="mt-auto border-top pt-3">
                <div class="d-flex justify-content-between mb-3">
                    <span class="fw-bold fs-5">Total a pagar:</span>
                    <span class="fw-bold fs-5 text-success" id="total-lateral">R$ 0,00</span>
                </div>
                <button id="btn-confirmar-final" class="btn btn-lg w-100 btn-success fw-bold">Confirmar e Avançar <i class="ph ph-arrow-right ms-2"></i></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let carrinho = JSON.parse(localStorage.getItem('carrinho_celestina')) || {};
        const offcanvas = new bootstrap.Offcanvas(document.getElementById('abaCarrinho'));

        // ==========================================
        // LÓGICA PARA OS CARDS COM SELECT (Bebidas e Porções)
        // ==========================================
        function atualizarCardDinamico(card) {
            const selectTamanho = card.querySelector('.select-tamanho');
            if (!selectTamanho) return;
            
            const optionTamanho = selectTamanho.options[selectTamanho.selectedIndex];
            const tamanho = optionTamanho.value;
            const preco = parseFloat(optionTamanho.getAttribute('data-preco'));
            const nomeBase = card.getAttribute('data-nome-base');
            let nomeCompleto = `${nomeBase} (${tamanho})`;

            const selectSabor = card.querySelector('.select-sabor');
            if (selectSabor) {
                const sabor = selectSabor.options[selectSabor.selectedIndex].value;
                nomeCompleto = `${nomeBase} ${sabor} (${tamanho})`;
            }

            card.querySelector('.preco').innerText = preco.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            
            const btnPlus = card.querySelector('.btn-qtd.plus');
            const btnMinus = card.querySelector('.btn-qtd.minus');
            const spanQtd = card.querySelector('.qtd-numero');

            btnPlus.setAttribute('data-nome', nomeCompleto);
            btnPlus.setAttribute('data-preco', preco);
            btnMinus.setAttribute('data-nome', nomeCompleto);
            spanQtd.setAttribute('data-nome', nomeCompleto);

            spanQtd.innerText = carrinho[nomeCompleto] ? carrinho[nomeCompleto].qtd : 0;
        }

        document.querySelectorAll('.select-tamanho, .select-sabor').forEach(select => {
            select.addEventListener('change', function() {
                atualizarCardDinamico(this.closest('.produto-card'));
            });
        });

        // ==========================================
        // LÓGICA GERAL DO CARRINHO
        // ==========================================
        function atualizarTelaTotal() {
            let total = 0; let totalItens = 0;
            document.querySelectorAll('.qtd-numero').forEach(span => {
                const nome = span.getAttribute('data-nome');
                if(nome) { span.innerText = carrinho[nome] ? carrinho[nome].qtd : 0; }
            });
            for (let nome in carrinho) {
                total += carrinho[nome].preco * carrinho[nome].qtd;
                totalItens += carrinho[nome].qtd;
            }
            document.getElementById('valor-total').innerText = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            document.getElementById('qtd-total-itens').innerText = totalItens;
            localStorage.setItem('carrinho_celestina', JSON.stringify(carrinho));
        }

        function renderizarAbaLateral() {
            const container = document.getElementById('itens-carrinho-lateral');
            container.innerHTML = '';
            let total = 0;
            for (let nome in carrinho) {
                const item = carrinho[nome];
                total += item.preco * item.qtd;
                container.innerHTML += `
                    <div class="mb-3 border-bottom pb-2">
                        <div class="d-flex justify-content-between fw-bold mb-1">
                            <span style="max-width: 70%;">${nome}</span>
                            <span>R$ ${(item.preco * item.qtd).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-muted">R$ ${item.preco.toLocaleString('pt-BR', {minimumFractionDigits: 2})} (cada)</span>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-secondary btn-lateral-menos" data-nome="${nome}">-</button>
                                <span class="fw-bold">${item.qtd}</span>
                                <button class="btn btn-sm btn-warning btn-lateral-mais" data-nome="${nome}">+</button>
                            </div>
                        </div>
                    </div>
                `;
            }
            if (Object.keys(carrinho).length === 0) container.innerHTML = '<p class="mt-3 text-center text-muted">Seu carrinho está vazio.</p>';
            document.getElementById('total-lateral').innerText = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

            document.querySelectorAll('.btn-lateral-mais').forEach(btn => {
                btn.addEventListener('click', function() { carrinho[this.getAttribute('data-nome')].qtd++; atualizarTudo(); });
            });
            document.querySelectorAll('.btn-lateral-menos').forEach(btn => {
                btn.addEventListener('click', function() {
                    const nome = this.getAttribute('data-nome'); carrinho[nome].qtd--;
                    if (carrinho[nome].qtd <= 0) delete carrinho[nome];
                    atualizarTudo();
                    if (Object.keys(carrinho).length === 0) offcanvas.hide();
                });
            });
        }

        function atualizarTudo() {
            document.querySelectorAll('.produto-card.dinâmico').forEach(card => atualizarCardDinamico(card));
            atualizarTelaTotal(); renderizarAbaLateral();
        }

        // Eventos para BOTÕES PLUS e MINUS (Tanto os do DB quanto os com Select)
        document.querySelectorAll('.btn-qtd.plus').forEach(btn => {
            btn.addEventListener('click', function() {
                const nome = this.getAttribute('data-nome');
                const preco = parseFloat(this.getAttribute('data-preco'));
                if (!carrinho[nome]) carrinho[nome] = { preco: preco, qtd: 0 };
                carrinho[nome].qtd++;
                atualizarTudo();
            });
        });

        document.querySelectorAll('.btn-qtd.minus').forEach(btn => {
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
            if (Object.keys(carrinho).length === 0) alert("Adicione um item primeiro!");
            else { renderizarAbaLateral(); offcanvas.show(); }
        });

        document.getElementById('btn-confirmar-final').addEventListener('click', () => {
            if (Object.keys(carrinho).length > 0) window.location.href = 'index.php?page=finalizar';
        });

        // Inicializa a tela
        atualizarTudo();
    </script>
</body>
</html>