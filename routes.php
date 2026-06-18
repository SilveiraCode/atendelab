<?php

require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/UsuariosController.php';
require_once __DIR__ . '/app/Middleware/auth.php';

// Carrega o controller responsável pelos endpoints de usuários.
// Observação: o arquivo no projeto está no singular (UsuarioController.php).
require_once __DIR__ . '/app/controllers/UsuariosController.php';
require_once __DIR__ . '/app/controllers/PessoasController.php';
require_once __DIR__ . '/app/controllers/TiposAtendimentosController.php';
require_once __DIR__ . '/app/controllers/AtendimentosController.php';

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

            case 'buscarPorId':
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
                http_response_code(404);
                // Retorno padrão para action inválida.
                echo 'Acao de usuarios nao encontrada.';
                break;
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
                    $pessoasController->buscarPorId();
                    break;
                case 'criar':
                    $pessoasController->criar();
                    break;
                case 'atualizar':
                    $pessoasController->atualizar();
                    break;
                case 'excluir':
                    $pessoasController->excluir();
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
                    $tiposController->buscarPorId();
                    break;
                case 'criar':
                    $tiposController->criar();
                    break;
                case 'atualizar':
                    $tiposController->atualizar();
                    break;
                case 'excluir':
                    $tiposController->excluir();
                    break;
                default:
                    echo 'Ação de tipos de atendimentos não encontrada.';
                    break;
            }
        } elseif ($controllerAlt === 'atendimentos') {
            $atendimentosController = new \App\Controllers\AtendimentosController();
            switch ($actionAlt) {
                case 'listar':
                    $atendimentosController->listar();
                    break;
                case 'buscar':
                    $atendimentosController->buscarPorId();
                    break;
                case 'criar':
                    $atendimentosController->criar();
                    break;
                case 'atualizar':
                    $atendimentosController->atualizar();
                    break;
                case 'excluir':
                    $atendimentosController->excluir();
                    break;
                default:
                    echo 'Ação de atendimentos não encontrada.';
                    break;
            }
        } else {
            http_response_code(404);
            echo 'Controller nao encontrado.';
            
            // Resposta básica para indicar que a aplicação está no ar.
            echo '<h1>AtendeLab</h1>';
            echo '<p>Projeto em execução. Use ?controller=usuarios&action=listar para testar.</p>';
        }
        break;
}