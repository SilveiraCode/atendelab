<?php
declare(strict_types=1);

class FrontendController
{
    /**
     * Redireciona ou renderiza a página do Dashboard principal
     */
    public function dashboard(): void
    {
        // Carrega o arquivo de visualização do índice do Dashboard
        require_once __DIR__ . '/../Views/dashboard/index.php';
    }

    /**
     * Renderiza a tela de listagem e gestão de Pessoas
     */
    public function pessoas(): void
    {
        // Carrega a view de pessoas onde os scripts JS farão a mágica do Fetch
        require_once __DIR__ . '/../Views/pessoas/index.php';
    }

    /**
     * Renderiza a tela de listagem e gestão de Tipos de Atendimento
     */
    public function tipos(): void
    {
        // Carrega a view de tipos de atendimentos (Categorias)
        require_once __DIR__ . '/../Views/tipos-atendimentos/index.php';
    }

    /**
     * Renderiza a tela de Atendimentos Acadêmicos
     */
    public function atendimentos(): void
    {
        // Carrega a view principal de registro e alteração de status de atendimentos
        require_once __DIR__ . '/../Views/atendimentos/index.php';
    }

    /**
     * Renderiza a tela de Relatórios e Estatísticas Gerais
     */
    public function relatorios(): void
    {
        // Carrega a view responsável por exibir os filtros e as tabelas de relatórios
        require_once __DIR__ . '/../Views/relatorios/index.php';
    }
}