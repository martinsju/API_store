<?php

require_once "service/Pessoa.php";

$id = $_REQUEST["id"] ?? null;

header('Content-Type: application/json');
$data = [];

if ($id !== null) {
    $p = new Pessoa;
    $p->setId($id);
    $result = $p->show();
    if ($p->delete()) {
        $data["pessoa"] = $result;
    }
}

die(json_encode($data));
