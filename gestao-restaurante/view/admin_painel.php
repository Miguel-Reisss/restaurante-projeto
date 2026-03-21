<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel CEO - Celestina Point</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { background-color: #F8F9FA; font-family: sans-serif; overflow-x: hidden; }
        .sidebar { background-color: #2B2D42; min-height: 100vh; color: white; padding-top: 20px; }
        .sidebar .nav-link { color: #adb5bd; margin-bottom: 5px; border-radius: 8px; font-weight: 500; }
        .sidebar .nav-link.active { background-color: #D32F2F; color: white; }
        .sidebar .nav-link:hover:not(.active) { background-color: rgba(255,255,255,0.1); }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .logo-area { font-size: 1.5rem; font-weight: bold; border-bottom: 1px solid #3f425c; padding-bottom: 20px; margin-bottom: 20px; text-align: center; }
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
                    <h2 class="fw-bold mb-4">Bem-vindo ao Centro de Comando</h2>
                    <p class="text-muted">Use o menu lateral para gerenciar todo o seu restaurante em tempo real.</p>
                    <div class="row mt-4">
                        <div class="col-md-3"><div class="card card-custom p-4 text-center bg-primary text-white"><h1 class="fw-bold"><?= count($produtos) ?></h1><span>Produtos Ativos</span></div></div>
                        <div class="col-md-3"><div class="card card-custom p-4 text-center bg-success text-white"><h1 class="fw-bold"><?= count($mesas) ?></h1><span>Mesas</span></div></div>
                        <div class="col-md-3"><div class="card card-custom p-4 text-center bg-warning text-dark"><h1 class="fw-bold"><?= count($categorias) ?></h1><span>Categorias</span></div></div>
                        <div class="col-md-3"><div class="card card-custom p-4 text-center bg-danger text-white"><h1 class="fw-bold"><?= count($funcionarios) ?></h1><span>Funcionários</span></div></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-produtos">
                    <h3 class="fw-bold mb-4">Gestão de Produtos</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-custom p-3">
                                <h5>Novo Produto</h5>
                                <form action="index.php?controller=produto&action=store" method="POST" enctype="multipart/form-data">
                                    <input type="text" name="nome" class="form-control mb-2" placeholder="Nome do Produto" required>
                                    
                                    <select name="categoria_id" class="form-select mb-3" required>
                                        <option value="">Selecione a Categoria...</option>
                                        <?php foreach($categorias as $cat): ?>
                                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <div class="border p-2 mb-2 rounded bg-white">
                                        <label class="form-label small fw-bold">Preço Único (Lanches normais)</label>
                                        <input type="text" name="preco" class="form-control mb-2" placeholder="Ex: 25.90">
                                        
                                        <hr>
                                        <label class="form-check-label mb-2 fw-bold text-danger">
                                            <input type="checkbox" name="tem_tamanhos"> Tem tamanhos (P, M, G)?
                                        </label>
                                        <div class="row g-2">
                                            <div class="col-4"><input type="text" name="preco_p" class="form-control form-control-sm" placeholder="Preço P"></div>
                                            <div class="col-4"><input type="text" name="preco_m" class="form-control form-control-sm" placeholder="Preço M"></div>
                                            <div class="col-4"><input type="text" name="preco_g" class="form-control form-control-sm" placeholder="Preço G"></div>
                                        </div>
                                    </div>
                                    
                                    <textarea name="descricao" class="form-control mb-2" placeholder="Descrição"></textarea>
                                    <input type="file" name="imagem" class="form-control mb-3">
                                    <button class="btn btn-danger w-100">Salvar Produto</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table bg-white card-custom p-3">
                                <thead><tr><th>Nome</th><th>Preço</th><th>Ação</th></tr></thead>
                                <tbody>
                                    <?php foreach($produtos as $p): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($p['nome']) ?></td>
                                        <td class="text-success fw-bold">
                                            <?php if ($p['tem_tamanhos']): ?>
                                                Múltiplos Tamanhos
                                            <?php else: ?>
                                                R$ <?= number_format((float)$p['preco'], 2, ',', '.') ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><a href="index.php?controller=produto&action=deletar&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger"><i class="ph ph-trash"></i></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-categorias">
                    <h3 class="fw-bold mb-4">Gestão de Categorias</h3>
                    <div class="alert alert-info">As categorias organizam o seu cardápio (Ex: Lanches, Bebidas, Sobremesas).</div>
                </div>

                <div class="tab-pane fade" id="tab-mesas">
                    <h3 class="fw-bold mb-4">Gestão de Mesas</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-custom p-3">
                                <h5>Nova Mesa</h5>
                                <form action="index.php?controller=mesa&action=store" method="POST">
                                    <input type="number" name="numero" class="form-control mb-2" placeholder="Número da Mesa" required>
                                    <input type="number" name="capacidade" class="form-control mb-3" placeholder="Lugares (Ex: 4)" required>
                                    <button class="btn btn-danger w-100">Adicionar Mesa</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table bg-white card-custom p-3">
                                <thead><tr><th>Mesa</th><th>Lugares</th><th>Ação</th></tr></thead>
                                <tbody>
                                    <?php foreach($mesas as $m): ?>
                                    <tr>
                                        <td class="fw-bold">Mesa <?= $m['numero'] ?></td>
                                        <td><?= $m['capacidade'] ?> Lugares</td>
                                        <td><a href="index.php?controller=mesa&action=deletar&id=<?= $m['id'] ?>" class="btn btn-sm btn-outline-danger"><i class="ph ph-trash"></i></a></td>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>