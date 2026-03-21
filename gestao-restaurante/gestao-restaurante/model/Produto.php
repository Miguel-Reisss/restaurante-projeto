<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/conexao.php';

class Produto
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexao::getConnection();
    }

    /**
     * Cria um novo produto.
     *
     * @param array<string, mixed> $dados
     */
    public function criar(array $dados): int
    {
        $sql = 'INSERT INTO produtos (nome, descricao, preco, categoria_id, ativo)
                VALUES (:nome, :descricao, :preco, :categoria_id, :ativo)';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':nome', $dados['nome'] ?? '');
        $stmt->bindValue(':descricao', $dados['descricao'] ?? '');
        $stmt->bindValue(':preco', $dados['preco'] ?? 0);
        $stmt->bindValue(':categoria_id', $dados['categoria_id'] ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':ativo', isset($dados['ativo']) ? (int) $dados['ativo'] : 1, PDO::PARAM_INT);

        $stmt->execute();

        return (int) $this->conn->lastInsertId();
    }

    /**
     * Retorna um produto pelo ID.
     */
    public function buscarPorId(int $id): ?array
    {
        $sql  = 'SELECT * FROM produtos WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $produto = $stmt->fetch();

        return $produto ?: null;
    }

    /**
     * Lista todos os produtos (pode ser refinado com filtros depois).
     *
     * @return array<int, array<string, mixed>>
     */
    public function listarTodos(): array
    {
        $sql  = 'SELECT * FROM produtos ORDER BY nome';
        $stmt = $this->conn->query($sql);

        return $stmt->fetchAll();
    }

    /**
     * Atualiza os dados de um produto.
     *
     * @param array<string, mixed> $dados
     */
    public function atualizar(int $id, array $dados): bool
    {
        $sql = 'UPDATE produtos
                SET nome = :nome,
                    descricao = :descricao,
                    preco = :preco,
                    categoria_id = :categoria_id,
                    ativo = :ativo
                WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':nome', $dados['nome'] ?? '');
        $stmt->bindValue(':descricao', $dados['descricao'] ?? '');
        $stmt->bindValue(':preco', $dados['preco'] ?? 0);
        $stmt->bindValue(':categoria_id', $dados['categoria_id'] ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':ativo', isset($dados['ativo']) ? (int) $dados['ativo'] : 1, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Essa função irá criar um registro na base de dados, caso o produto tenha tamanho. Tabela para valores de tamanhos de produtos.  
    public function criarValoresTamanho(array $dados){
        $sql = 'INSERT valores_produtos_tamanho VALUES(:produto_id, :valor_p, :valor_m, :valor_g)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':produto_id', $dados['produto_id'] ?? '');
        $stmt->bindValue(':valor_p', $dados['valor_p'] ?? '');
        $stmt->bindValue(':valor_m', $dados['valor_m'] ?? '');
        $stmt->bindValue(':valor_g', $dados['valor_g'] ?? '');
        
        return $stmt->execute();
    }

    public function criarTamanhoProduto(array $dados){
        $sql = 'INSERT tamahos_produto VALUES(:produto_id, :tamanho)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':produto_id', $dados['produto_id']);
        $stmt->bindValue(':tamanho', $dados['tamanho']);
    }

    /**
     * Remove um produto (remoção física por enquanto).
     */
    public function deletar(int $id): bool
    {
        $sql  = 'DELETE FROM produtos WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

