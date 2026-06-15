<?php
// Carrega o controller responsável pelos endpoints de usuários.
// Observação: o arquivo no projeto está no singular (UsuarioController.php).
require_once __DIR__ . '/app/controllers/UsuariosController.php';
require_once __DIR__ . '/app/controllers/PessoasController.php';
require_once __DIR__ . '/app/controllers/TiposAtendimentosController.php';
require_once __DIR__ . '/app/controllers/AtendimentosController.php';
// Define controller e action por query string.
// Exemplo: ?controller=usuarios&action=listar
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Este roteador é simples: só reconhece o controller "usuarios".
if ($controller === 'usuarios') {
    $usuariosController = new UsuariosController();

    // Escolhe qual método do controller executar.
    switch ($action) {
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
} elseif ($controller === 'pessoas') {
    $pessoasController = new \App\Controllers\PessoasController();
    switch ($action) {
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
} elseif ($controller === 'tiposatendimentos') {
    $tiposController = new \App\Controllers\TiposAtendimentosController();
    switch ($action) {
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
} elseif ($controller === 'atendimentos') {
    $atendimentosController = new \App\Controllers\AtendimentosController();
    switch ($action) {
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
    // Resposta básica para indicar que a aplicação está no ar.
    echo '<h1>AtendeLab</h1>';
    echo '<p>Projeto em execução. Use ?controller=usuarios&action=listar para testar.</p>';
}