<?php
require_once __DIR__ . '/app/Middleware/auth.php';

require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/UsuariosController.php';
require_once __DIR__ . '/app/Controllers/PessoasController.php';
require_once __DIR__ . '/app/Controllers/TiposAtendimentosController.php';
require_once __DIR__ . '/app/Controllers/AtendimentosController.php';
require_once __DIR__ . '/app/Controllers/DashboardController.php';
require_once __DIR__ . '/app/Controllers/FrontendController.php';
require_once __DIR__ . '/app/Controllers/RelatoriosController.php';

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

switch ($controller) {
    case 'auth':
        $authController = new AuthController();

        switch ($action) {
            case 'login':
                $authController->exibirLogin();
                break;

            case 'entrar': 
                $authController->entrar(); 
                break; 

            case 'dashboard':
                $authController->dashboard();
                break;

            case 'logout':
                $authController->logout();
                break;

            default:
                http_response_code(404);
                echo 'Acao de autenticacao nao encontrada.';
                break;
        }
        break;

    case 'usuarios':
        exigirAutenticacao();
        $usuariosController = new UsuariosController();

        // Escolhe qual método do controller executar.
        switch ($action) {
            case 'listar':
                $usuariosController->listar();
                break;

            case 'buscar':
            case 'buscarPorId':
                $usuariosController->buscarPorId();
                break;

            case 'criar':
                $usuariosController->criar();
                break;

            case 'atualizar':
                $usuariosController->atualizar();
                break;

            case 'excluir':
                $usuariosController->excluir();
                break;

            default:
                http_response_code(404);
                // Retorno padrão para action inválida.
                echo 'Acao de usuarios nao encontrada.';
                break;
        }
        break;

    case 'pessoas':
        exigirAutenticacao();
        $pessoasController = new \App\Controllers\PessoasController();
        switch ($action) {
            case 'listar':
                $pessoasController->listar();
                break;
            case 'buscar':
                $pessoasController->buscar();
                break;
            case 'criar':
                $pessoasController->criar();
                break;
            case 'atualizar':
                $pessoasController->atualizar();
                break;
            case 'excluir':
            case 'inativar':
                $pessoasController->inativar();
                break;
            default:
                http_response_code(404);
                echo 'Ação de pessoas não encontrada.';
                break;
        }
        break;

    case 'tipos':
        exigirAutenticacao();
        $tiposController = new \App\Controllers\TiposAtendimentosController();
        switch ($action) {
            case 'listar':
                $tiposController->listar();
                break;
            case 'buscar':
            case 'buscarPorId':
                $tiposController->buscar();
                break;
            case 'criar':
                $tiposController->criar();
                break;
            case 'atualizar':
                $tiposController->atualizar();
                break;
            case 'excluir':
            case 'inativar':
                $tiposController->inativar();
                break;
            default:
                http_response_code(404);
                echo 'Ação de tipos de atendimento não encontrada.';
                break;
        }
        break;

    // ADICIONADO: Mapeamento direto para a API do Dashboard
    case 'dashboard':
        exigirAutenticacao();
        $dashboardController = new DashboardController();
        switch ($action) {
            case 'resumo':
                $dashboardController->resumo();
                break;
            default:
                http_response_code(404);
                echo 'Ação do dashboard não encontrada.';
                break;
        }
        break;

    // ADICIONADO: Mapeamento para renderização das Views do Frontend
    case 'frontend':
        exigirAutenticacao();
        $frontendController = new FrontendController();
        if (method_exists($frontendController, $action)) {
            $frontendController->$action();
        } else {
            http_response_code(404);
            echo 'Página do frontend não encontrada.';
        }
        break;

    // ADICIONADO: Mapeamento para geração do JSON de Relatórios
    case 'relatorios':
        exigirAutenticacao();
        $relatoriosController = new RelatoriosController();
        if ($action === 'geral') {
            $relatoriosController->geral();
        } else {
            http_response_code(404);
            echo 'Relatório não encontrado.';
        }
        break;

    default:
        // Define controller e action por query string.
        // Exemplo: ?controller=usuarios&action=listar
        $controllerAlt = $_GET['controller'] ?? 'home';
        $actionAlt = $_GET['action'] ?? 'index';

        // Este roteador é simples: só reconhece o controller "usuarios".
        if ($controllerAlt === 'usuarios') {
            $usuariosController = new UsuariosController();

            // Escolhe qual método do controller executar.
            switch ($actionAlt) {
                case 'listar':
                    $usuariosController->listar();
                    break;

                case 'buscar':
                    $usuariosController->buscarPorId();
                    break;

                case 'criar':
                    $usuariosController->criar();
                    break;

                case 'atualizar':
                    $usuariosController->atualizar();
                    break;

                case 'excluir':
                    $usuariosController->excluir();
                    break;

                default:
                    // Retorno padrão para action inválida.
                    echo 'Ação de usuários não encontrada.';
                    break;
            }
        } elseif ($controllerAlt === 'pessoas') {
            $pessoasController = new \App\Controllers\PessoasController();
            switch ($actionAlt) {
                case 'listar':
                    $pessoasController->listar();
                    break;
                case 'buscar':
                    $pessoasController->buscar(); // Ajustado para o método real (.pdf pág. 37)
                    break;
                case 'criar':
                    $pessoasController->criar();
                    break;
                case 'atualizar':
                    $pessoasController->atualizar();
                    break;
                case 'excluir':
                    $pessoasController->inativar(); // Ajustado para inativar conforme o banco consolidado
                    break;
                default:
                    echo 'Ação de pessoas não encontrada.';
                    break;
            }
        } elseif ($controllerAlt === 'tiposatendimentos') {
            $tiposController = new \App\Controllers\TiposAtendimentosController();
            switch ($actionAlt) {
                case 'listar':
                    $tiposController->listar();
                    break;
                case 'buscar':
                    $tiposController->buscar(); // Ajustado para o método real (.pdf pág. 41)
                    break;
                case 'criar':
                    $tiposController->criar();
                    break;
                case 'atualizar':
                    $tiposController->atualizar();
                    break;
                case 'excluir':
                    $tiposController->inativar(); // Ajustado para inativar conforme o banco consolidado
                    break;
                default:
                    echo 'Ação de tipos de atendimentos não encontrada.';
                    break;
            }
        }  elseif ($controllerAlt === 'atendimentos') {
            $atendimentosController = new \App\Controllers\AtendimentosController();

            switch ($actionAlt) {
                case 'listar':
                    $atendimentosController->listar();
                    break;

                case 'buscar':
                    $atendimentosController->buscar(); // Ajustado para o método real (.pdf pág. 44)
                    break;

                case 'criar':
                    $atendimentosController->criar();
                    break;

                case 'alterarStatus':
                    $atendimentosController->alterarStatus(); // Ajustado para alterarStatus conforme o roteiro
                    break;

                case 'atualizar':
                case 'excluir':
                    $atendimentosController->alterarStatus(); // Ajustado para alterarStatus conforme o roteiro
                    break;

                default:
                    echo 'Ação de atendimentos não encontrada.';
                    break;
            }
        } else {
            http_response_code(404);
            echo 'Controller nao encontrado.';
            
            // Resposta básica para indicate que a aplicação está no ar.
            echo '<h1>AtendeLab</h1>';
            echo '<p>Projeto em execução. Use ?controller=usuarios&action=listar para testar.</p>';
        }
        break;
}