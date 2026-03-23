<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel CEO - Celestina Point</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body {
            background-color: #F8F9FA;
            font-family: sans-serif;
            overflow-x: hidden;
        }

        .sidebar {
            background-color: #2B2D42;
            min-height: 100vh;
            color: white;
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            margin-bottom: 5px;
            border-radius: 8px;
            font-weight: 500;
        }

        .sidebar .nav-link.active {
            background-color: #D32F2F;
            color: white;
        }

        .sidebar .nav-link:hover:not(.active) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .logo-area {
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 1px solid #3f425c;
            padding-bottom: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0">
        <div class="row g-0">

            <div class="col-md-2 sidebar p-3">
                <div class="logo-area">
                    <i class="ph ph-crown text-warning"></i> Painel CEO
                </div>

                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-resumo" type="button"><i class="ph ph-squares-four"></i> Visão Geral</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-produtos" type="button"><i class="ph ph-hamburger"></i> Produtos</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-categorias" type="button"><i class="ph ph-list-dashes"></i> Categorias</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-mesas" type="button"><i class="ph ph-armchair"></i> Mesas</button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-funcionarios" type="button"><i class="ph ph-users"></i> Funcionários</button>
                </div>

                <div class="mt-5 px-3">
                    <a href="index.php?controller=pedido&action=index" class="btn btn-outline-light w-100 mb-2"><i class="ph ph-receipt"></i> Ver Pedidos</a>
                </div>
            </div>

            <div class="col-md-10 p-5 bg-light">
                <div class="tab-content" id="v-pills-tabContent">

                    <div class="tab-pane fade show active" id="tab-resumo">
                        <h2 class="fw-bold mb-4">Bem-vindo CEO!</h2>
                        <p class="text-muted">Use o menu lateral para gerenciar todo o seu restaurante em tempo real.</p>
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card card-custom p-4 text-center bg-primary text-white">
                                    <h1 class="fw-bold"><?= count($produtos) ?></h1><span>Produtos Ativos</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-custom p-4 text-center bg-success text-white">
                                    <h1 class="fw-bold"><?= count($mesas) ?></h1><span>Mesas</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-custom p-4 text-center bg-warning text-dark">
                                    <h1 class="fw-bold"><?= count($categorias) ?></h1><span>Categorias</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card card-custom p-4 text-center bg-danger text-white">
                                    <h1 class="fw-bold"><?= count($funcionarios) ?></h1><span>Funcionários</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-produtos">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold m-0">Gestão de Produtos</h3>
                            <button type="button" class="btn fw-bold" style="background-color: #D32F2F; color: white;" data-bs-toggle="modal" data-bs-target="#modalNovoProduto">
                                <i class="ph ph-plus-circle"></i> Cadastrar Produto
                            </button>
                        </div>

                        <div class="card card-custom p-0 overflow-hidden">
                            <table class="table table-hover bg-white align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Nome do Produto</th>
                                        <th>Categoria</th>
                                        <th>Preço</th>
                                        <th class="text-center pe-4">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produtos as $p): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold"><?= htmlspecialchars($p['nome']) ?></td>

                                            <td>
                                                <span class="badge bg-secondary">
                                                    <?= htmlspecialchars($p['categoria_nome'] ?? 'Sem Categoria') ?>
                                                </span>
                                            </td>

                                            <td class="text-success fw-bold">
                                                <?php if (!empty($p['tem_tamanhos'])): ?>
                                                    Múltiplos Tamanhos
                                                <?php else: ?>
                                                    R$ <?= number_format((float)$p['preco'], 2, ',', '.') ?>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center pe-4">
                                                <a href="index.php?controller=produto&action=deletar&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?')"><i class="ph ph-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-categorias">
                        <h3 class="fw-bold mb-4">Gestão de Categorias</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-custom p-3">
                                    <h5>Nova Categoria</h5>
                                    <form action="index.php?controller=categoria&action=store" method="POST">
                                        <input type="text" name="nome" class="form-control mb-3" placeholder="Ex: Novidades da Casa" required>
                                        <button type="submit" class="btn w-100" style="background-color: #D32F2F; color: white;">Adicionar Categoria</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <table class="table bg-white card-custom p-3">
                                    <thead>
                                        <tr>
                                            <th>Nome da Categoria</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categorias as $cat): ?>
                                            <tr>
                                                <td class="fw-bold"><?= htmlspecialchars($cat['nome']) ?></td>
                                                <td>
                                                    <?php if (!in_array($cat['id'], [1, 2, 3])): ?>
                                                        <a href="index.php?controller=categoria&action=deletar&id=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Excluir esta categoria?')"><i class="ph ph-trash"></i></a>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Padrão do Sistema</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-produtos">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold m-0">Gestão de Produtos</h3>
                            <button type="button" class="btn fw-bold" style="background-color: #D32F2F; color: white;" data-bs-toggle="modal" data-bs-target="#modalNovoProduto">
                                <i class="ph ph-plus-circle"></i> Cadastrar Produto
                            </button>
                        </div>

                        <div class="card card-custom p-0 overflow-hidden">
                            <table class="table table-hover bg-white align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Nome do Produto</th>
                                        <th>Categoria</th>
                                        <th>Preço</th>
                                        <th class="text-center pe-4">Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produtos as $p): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold"><?= htmlspecialchars($p['nome']) ?></td>

                                            <td>
                                                <span class="badge bg-secondary">
                                                    <?= htmlspecialchars($p['categoria_nome'] ?? 'Sem Categoria') ?>
                                                </span>
                                            </td>

                                            <td class="text-success fw-bold">
                                                <?php if (!empty($p['tem_tamanhos'])): ?>
                                                    Múltiplos Tamanhos
                                                <?php else: ?>
                                                    R$ <?= number_format((float)$p['preco'], 2, ',', '.') ?>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center pe-4">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button class="btn btn-sm btn-outline-primary" title="Editar Produto" onclick="alert('Funcionalidade de edição em desenvolvimento. Para alterar um produto, exclua e cadastre novamente por enquanto.')">
                                                        <i class="ph ph-pencil-simple"></i>
                                                    </button>

                                                    <a href="index.php?controller=produto&action=deletar&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" title="Excluir Produto" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                                        <i class="ph ph-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="tab-funcionarios">
                        <h3 class="fw-bold mb-4">Equipe e Funcionários</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-custom p-3">
                                    <h5>Novo Funcionário</h5>
                                    <form action="index.php?controller=funcionarios&action=store" method="POST">
                                        <input type="text" name="nome" class="form-control mb-2" placeholder="Nome Completo" required>
                                        <input type="email" name="email" class="form-control mb-2" placeholder="E-mail" required>
                                        <input type="password" name="senha" class="form-control mb-2" placeholder="Senha" required>
                                        <select name="nivel_acesso" class="form-select mb-3">
                                            <option value="garcom">Garçom</option>
                                            <option value="caixa">Caixa</option>
                                            <option value="admin">Administrador</option>
                                        </select>
                                        <button type="submit" class="btn w-100" style="background-color: #D32F2F; color: white;">Cadastrar Acesso</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <table class="table bg-white card-custom p-3 align-middle">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Nível</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($funcionarios as $f): ?>
                                            <tr>
                                                <td class="fw-bold">
                                                    <?= htmlspecialchars($f['nome']) ?><br>
                                                    <small class="text-muted fw-normal"><?= htmlspecialchars($f['email']) ?></small>
                                                </td>
                                                <td><span class="badge bg-dark"><?= strtoupper($f['nivel_acesso']) ?></span></td>
                                                <td>
                                                    <?php if ($f['id'] != 1): ?>
                                                        <a href="index.php?controller=funcionarios&action=delete&id=<?= $f['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remover o acesso deste funcionário?')"><i class="ph ph-trash"></i></a>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">CEO</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-funcionarios">
                        <h3 class="fw-bold mb-4">Equipe e Funcionários</h3>
                        <div class="alert alert-info">Gerencie o acesso da sua equipe ao sistema.</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalNovoProduto" tabindex="-1" aria-labelledby="modalNovoProdutoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">

                <div class="modal-header" style="background-color: #2B2D42; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="modal-title fw-bold" id="modalNovoProdutoLabel"><i class="ph ph-hamburger me-2"></i>Novo Produto</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <form action="index.php?controller=produto&action=store" method="POST" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nome do Produto *</label>
                            <input type="text" name="nome" class="form-control" placeholder="Ex: Hambúrguer Duplo" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Categoria *</label>
                            <select name="categoria_id" class="form-select" required>
                                <option value="">Selecione...</option>
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="border p-3 mb-3 rounded" style="background-color: #f8f9fa;">
                            <label class="form-label fw-bold small text-primary">Preço Único (Lanches normais)</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-white">R$</span>
                                <input type="text" name="preco" class="form-control" placeholder="Ex: 25.90">
                            </div>

                            <hr class="my-3 border-secondary">

                            <label class="form-check-label mb-2 fw-bold text-danger user-select-none" style="cursor: pointer;">
                                <input type="checkbox" name="tem_tamanhos" value="1" class="form-check-input me-1"> Ativar tamanhos (P, M, G)
                            </label>
                            <div class="row g-2">
                                <div class="col-4">
                                    <input type="text" name="preco_p" class="form-control form-control-sm text-center" placeholder="Valor P">
                                </div>
                                <div class="col-4">
                                    <input type="text" name="preco_m" class="form-control form-control-sm text-center" placeholder="Valor M">
                                </div>
                                <div class="col-4">
                                    <input type="text" name="preco_g" class="form-control form-control-sm text-center" placeholder="Valor G">
                                </div>
                            </div>
                            <small class="text-muted" style="font-size: 0.7rem;">Use pontos nos centavos. Deixe em branco se não usar o tamanho.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Descrição (Opcional)</label>
                            <textarea name="descricao" class="form-control" rows="2" placeholder="Ingredientes do lanche..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small">Foto do Produto</label>
                            <input type="file" name="imagem" class="form-control form-control-sm">
                        </div>

                        <button class="btn btn-lg w-100 fw-bold" style="background-color: #D32F2F; color: white;">Salvar Produto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1. Quando a página carregar, verifica se tem uma aba salva na memória
            let abaSalva = localStorage.getItem('aba_ativa_ceo');
            if (abaSalva) {
                // Procura o botão da aba salva e "clica" nele via código
                let botaoAba = document.querySelector('button[data-bs-target="' + abaSalva + '"]');
                if (botaoAba) {
                    let tab = new bootstrap.Tab(botaoAba);
                    tab.show();
                }
            }

            // 2. Toda vez que o CEO clicar em uma aba nova, salva o nome dela na memória
            let todosOsBotoes = document.querySelectorAll('button[data-bs-toggle="pill"]');
            todosOsBotoes.forEach(function(botao) {
                botao.addEventListener('shown.bs.tab', function(event) {
                    let qualAbaFoiClicada = event.target.getAttribute('data-bs-target');
                    localStorage.setItem('aba_ativa_ceo', qualAbaFoiClicada);
                });
            });
        });
    </script>
</body>

</html>