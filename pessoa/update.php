<?php

require_once "service/Pessoa.php";

$id = $_REQUEST["id"] ?? null;
$nome = $_REQUEST["nome"] ?? null;
$idade = $_REQUEST["idade"] ?? null;

header('Content-Type: application/json');
$data = [];

if ($id !== null || $nome !== null || $idade !== null) {
    $p = new Pessoa;
    $p->setId($id);
    $p->setNome($nome);
    $p->setIdade($idade);
    if ($p->update()) {
        $data["pessoa"] = $p->show();
    }
}

die(json_encode($data));
