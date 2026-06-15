<?php

namespace App\Controllers;

class TiposAtendimentosController {

    public function listar() {
        header('Content-Type: application/json');
        echo json_encode([["id" => 1, "descricao" => "Matrícula Acadêmica"]]);
    }

    public function buscarPorId() {
        header('Content-Type: application/json');
        echo json_encode(["id" => $_GET['id'] ?? null, "descricao" => "Matrícula Acadêmica"]);
    }

    public function criar() {
        header('HTTP/1.1 201 Created');
        header('Content-Type: application/json');
        echo json_encode(["mensagem" => "Tipo de atendimento cadastrado com sucesso.", "id" => "2"]);
    }

    public function atualizar() {
        header('Content-Type: application/json');
        echo json_encode(["mensagem" => "Tipo de atendimento atualizado com sucesso."]);
    }

    public function excluir() {
        header('Content-Type: application/json');
        echo json_encode(["mensagem" => "Tipo de atendimento excluído com sucesso."]);
    }
}