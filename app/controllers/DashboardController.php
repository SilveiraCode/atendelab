<?php
declare(strict_types=1);

class DashboardController
{
    private PDO $db;

    public function __construct()
    {
        // Recupera a instância de conexão com o banco de dados configurada globalmente
        $this->db = Database::getInstance();
    }

    /**
     * GET: ?controller=dashboard&action=resumo
     * Retorna os indicadores consolidados para o JavaScript do Frontend.
     * Evita múltiplas requisições assíncronas separadas.
     */
    public function resumo(): void
    {
        // Define o cabeçalho para resposta JSON
        header('Content-Type: application/json; charset=utf-8');

        try {
            // 1. Conta o total de pessoas cadastradas
            $stmtPessoas = $this->db->query("SELECT COUNT(*) as total FROM pessoas");
            $totalPessoas = $stmtPessoas->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

            // 2. Conta o total de tipos de atendimento cadastrados
            $stmtTipos = $this->db->query("SELECT COUNT(*) as total FROM tipos_atendimentos");
            $totalTipos = $stmtTipos->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

            // 3. Conta o total de atendimentos gerais registrados no sistema
            $stmtAtendimentos = $this->db->query("SELECT COUNT(*) as total FROM atendimentos");
            $totalAtendimentos = $stmtAtendimentos->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

            // Monta a estrutura de resposta idêntica à esperada pelo AtendeLabApi.get()
            echo json_encode([
                'status' => 'success',
                'indicadores' => [
                    'total_pessoas' => (int) $totalPessoas,
                    'total_tipos' => (int) $totalTipos,
                    'total_atendimentos' => (int) $totalAtendimentos
                ]
            ], JSON_UNESCAPED_UNICODE);

        } catch (PDOException $e) {
            // Em caso de falha no banco de dados, retorna o código de erro HTTP 500
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao processar indicadores do painel: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }
}