<?php
declare(strict_types=1);

class RelatoriosController
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * GET/POST: ?controller=relatorios&action=geral
     * Filtra atendimentos cruzando informações do banco de dados com base em parâmetros
     */
    public function geral(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        // Captura os filtros enviados via requisição (Query String ou Post)
        $dataInicio = $_REQUEST['data_inicio'] ?? null;
        $dataFim    = $_REQUEST['data_fim'] ?? null;
        $status     = $_REQUEST['status'] ?? null;

        try {
            // Estrutura a query SQL base trazendo os relacionamentos necessários (JOINs)
            $sql = "SELECT a.id, 
                           p.nome AS pessoa_nome, 
                           t.nome AS tipo_nome, 
                           u.nome AS usuario_nome, 
                           a.data_atendimento, 
                           a.status,
                           a.observacao_final
                    FROM atendimentos a
                    INNER JOIN pessoas p ON a.pessoa_id = p.id
                    INNER JOIN tipos_atendimentos t ON a.tipo_atendimento_id = t.id
                    INNER JOIN usuarios u ON a.usuario_id = u.id
                    WHERE 1=1"; // Cláusula coringa para facilitar concatenações dinâmicas

            $params = [];

            // Aplica filtro de data inicial se fornecido
            if (!empty($dataInicio)) {
                $sql .= " AND a.data_atendimento >= :data_inicio";
                $params['data_inicio'] = $dataInicio;
            }

            // Aplica filtro de data limite se fornecido
            if (!empty($dataFim)) {
                $sql .= " AND a.data_atendimento <= :data_fim";
                $params['data_fim'] = $dataFim;
            }

            // Aplica filtro por situação/status do atendimento
            if (!empty($status) && $status !== 'todos') {
                $sql .= " AND a.status = :status";
                $params['status'] = $status;
            }

            // Ordena o resultado do mais recente para o mais antigo
            $sql .= " ORDER BY a.data_atendimento DESC, a.id DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                'status' => 'success',
                'data' => $resultados
            ], JSON_UNESCAPED_UNICODE);

        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro interno ao processar relatório: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }
}