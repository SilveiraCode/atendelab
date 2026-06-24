<?php

namespace App\Controllers;

use PDO;
use PDOException;

class AtendimentosController 
{
    private PDO $pdo;

    public function __construct() 
    {
        require __DIR__ . '/../../config/database.php';
        $this->pdo = $pdo;
    }

    private function json(array $dados, int $status = 200): void 
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }

    public function listar(): void 
    {
        $sql = "SELECT a.id, p.nome AS pessoa_nome, t.nome AS tipo_nome, u.nome AS responsavel_nome, 
                       a.descricao, a.status, a.data_atendimento, a.horario_atendimento, a.observacao_final 
                FROM atendimentos a 
                INNER JOIN pessoas p ON p.id = a.pessoa_id 
                INNER JOIN tipos_atendimentos t ON t.id = a.tipo_atendimento_id 
                INNER JOIN usuarios u ON u.id = a.usuario_id 
                ORDER BY a.id DESC";
        $this->json($this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC));
    }

    public function buscar(): void 
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $this->json(['erro' => 'ID inválido.'], 400);
            return;
        }

        $stmt = $this->pdo->prepare("SELECT a.*, p.nome AS pessoa_nome, t.nome AS tipo_nome, u.nome AS responsavel_nome 
                                     FROM atendimentos a 
                                     INNER JOIN pessoas p ON p.id = a.pessoa_id 
                                     INNER JOIN tipos_atendimentos t ON t.id = a.tipo_atendimento_id 
                                     INNER JOIN usuarios u ON u.id = a.usuario_id 
                                     WHERE a.id = :id");
        $stmt->execute(['id' => $id]);
        $atendimento = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$atendimento) {
            $this->json(['erro' => 'Atendimento não encontrado.'], 404);
            return;
        }
        $this->json($atendimento);
    }

    public function criar(): void 
    {
        $pessoa_id = filter_var($_POST['pessoa_id'] ?? null, FILTER_VALIDATE_INT);
        $tipo_atendimento_id = filter_var($_POST['tipo_atendimento_id'] ?? null, FILTER_VALIDATE_INT);
        $usuario_id = filter_var($_POST['usuario_id'] ?? null, FILTER_VALIDATE_INT);
        $descricao = trim($_POST['descricao'] ?? '');
        $data_atendimento = $_POST['data_atendimento'] ?? '';
        $horario_atendimento = $_POST['horario_atendimento'] ?? '';
        $status = $_POST['status'] ?? 'aberto';

        if (!$pessoa_id || !$tipo_atendimento_id || !$usuario_id || $descricao === '' || $data_atendimento === '' || $horario_atendimento === '') {
            $this->json(['erro' => 'Todos os campos obrigatórios devem ser preenchidos.'], 422);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO atendimentos (pessoa_id, tipo_atendimento_id, usuario_id, descricao, data_atendimento, horario_atendimento, status) 
                                         VALUES (:pessoa_id, :tipo_atendimento_id, :usuario_id, :descricao, :data_atendimento, :horario_atendimento, :status)");
            $stmt->execute(compact('pessoa_id', 'tipo_atendimento_id', 'usuario_id', 'descricao', 'data_atendimento', 'horario_atendimento', 'status'));
            $this->json(['mensagem' => 'Atendimento registrado com sucesso.'], 201);
        } catch (PDOException $e) {
            $this->json(['erro' => 'Não foi possível registrar o atendimento.'], 400);
        }
    }

    public function alterarStatus(): void 
    {
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        $status = $_POST['status'] ?? '';
        $observacao_final = trim($_POST['observacao_final'] ?? '');

        if (!$id || !in_array($status, ['aberto', 'em_andamento', 'concluido'], true)) {
            $this->json(['erro' => 'Dados inválidos ou status incorreto.'], 422);
            return;
        }

        if ($status === 'concluido' && $observacao_final === '') {
            $this->json(['erro' => 'A conclusão exige uma observação final.'], 422);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE atendimentos SET status = :status, observacao_final = :observacao_final WHERE id = :id");
            $stmt->execute(compact('id', 'status', 'observacao_final'));
            $this->json(['mensagem' => 'Status atualizado com sucesso.']);
        } catch (PDOException $e) {
            $this->json(['erro' => 'Não foi possível alterar o status.'], 400);
        }
    }
}