<?php

namespace App\Controllers;

class PessoasController {

    public function listar() {
        header('Content-Type: application/json');
        echo json_encode([["id" => 1, "nome" => "Maria Aluna Teste", "email" => "maria.aluna@email.com", "telefone" => "47999998888"]]);
    }

    public function buscarPorId() {
        header('Content-Type: application/json');
        echo json_encode(["id" => $_GET['id'] ?? null, "nome" => "Maria Aluna Teste", "email" => "maria.aluna@email.com", "telefone" => "47999998888"]);
    }

    public function criar() {
        header('HTTP/1.1 201 Created');
        header('Content-Type: application/json');
        echo json_encode(["mensagem" => "Pessoa cadastrada com sucesso.", "id" => "2"]);
    }

    public function atualizar() {
        header('Content-Type: application/json');
        echo json_encode(["mensagem" => "Dados da pessoa atualizados com sucesso."]);
    }

    public function excluir() {
        header('Content-Type: application/json');
        echo json_encode(["mensagem" => "Pessoa excluída com sucesso."]);
    }
}