<?php

require_once "service/Pessoa.php";

$nome = $_REQUEST["nome"] ?? null;
$idade = $_REQUEST["idade"] ?? null;

header('Content-Type: application/json');
$data = [];

if ($nome !== null && $idade !== null) {
    $p = new Pessoa;
    $p->setNome($nome);
    $p->setIdade($idade);
    if (($id = $p->create()) > 0) {
        $p->setId($id);
        $data["pessoa"] = $p->show();
    }
}

die(json_encode($data));
