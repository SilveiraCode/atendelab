<?php

namespace App\Controllers;

class AtendimentosController {

    public function listar() {
        header('Content-Type: application/json');
        echo json_encode([["id" => 1, "pessoa_id" => 1, "tipo_atendimento_id" => 1, "usuario_id" => 1, "observacao" => "Aluno solicitou ajuste na grade.", "data_atendimento" => "2026-06-15 13:27:02"]]);
    }

    public function buscarPorId() {
        header('Content-Type: application/json');
        echo json_encode(["id" => $_GET['id'] ?? null, "pessoa_id" => 1, "tipo_atendimento_id" => 1, "usuario_id" => 1, "observacao" => "Aluno solicitou ajuste na grade."]);
    }

    public function criar() {
        header('HTTP/1.1 201 Created');
        header('Content-Type: application/json');
        echo json_encode(["mensagem" => "Atendimento registrado com sucesso.", "id" => "2"]);
    }

    public function atualizar() {
        header('Content-Type: application/json');
        echo json_encode(["mensagem" => "Atendimento atualizado com sucesso."]);
    }

    public function excluir() {
        header('Content-Type: application/json');
        echo json_encode(["mensagem" => "Atendimento removido com sucesso."]);
    }
}