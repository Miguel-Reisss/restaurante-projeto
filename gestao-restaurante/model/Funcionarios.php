<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/conexao.php';

class Funcionarios
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Conexao::getConnection();
    }

    public function criar(array $dados): int
    {
        $sql = 'INSERT INTO funcionarios (nome, email, senha_hash, nivel_acesso, ativo)
                VALUES (:nome, :email, :senha_hash, :nivel_acesso, :ativo)';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':nome', $dados['nome'] ?? '');
        $stmt->bindValue(':email', $dados['email'] ?? '');
        $stmt->bindValue(':senha_hash', $dados['senha_hash'] ?? '');
        $stmt->bindValue(':nivel_acesso', $dados['nivel_acesso'] ?? 'garcom');
        $stmt->bindValue(':ativo', isset($dados['ativo']) ? (int) $dados['ativo'] : 1, PDO::PARAM_INT);

        $stmt->execute();

        return (int) $this->conn->lastInsertId();
    }

    public function buscarPorId(int $id): ?array
    {
        $sql  = 'SELECT * FROM funcionarios WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $funcionario = $stmt->fetch();

        return $funcionario ?: null;
    }

    public function buscarPorEmail(string $email): ?array
    {
        $sql  = 'SELECT * FROM funcionarios WHERE email = :email LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $funcionario = $stmt->fetch();

        return $funcionario ?: null;
    }

    public function listarTodos(): array
    {
        $sql  = 'SELECT * FROM funcionarios ORDER BY nome';
        $stmt = $this->conn->query($sql);

        return $stmt->fetchAll();
    }

    public function atualizar(int $id, array $dados): bool
    {
        $campos = [
            'nome'         => ':nome',
            'email'        => ':email',
            'nivel_acesso' => ':nivel_acesso',
            'ativo'        => ':ativo',
        ];

        $set = [];
        foreach ($campos as $campo => $placeholder) {
            $set[] = "{$campo} = {$placeholder}";
        }

        if (!empty($dados['senha_hash'])) {
            $set[] = 'senha_hash = :senha_hash';
        }

        $sql = 'UPDATE funcionarios SET ' . implode(', ', $set) . ' WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':nome', $dados['nome'] ?? '');
        $stmt->bindValue(':email', $dados['email'] ?? '');
        $stmt->bindValue(':nivel_acesso', $dados['nivel_acesso'] ?? 'garcom');
        $stmt->bindValue(':ativo', isset($dados['ativo']) ? (int) $dados['ativo'] : 1, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if (!empty($dados['senha_hash'])) {
            $stmt->bindValue(':senha_hash', $dados['senha_hash']);
        }

        return $stmt->execute();
    }

    public function deletar(int $id): bool
    {
        $sql  = 'DELETE FROM funcionarios WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

