<?php

require_once "service/Pessoa.php";

$id = $_REQUEST["id"] ?? 0;

header('Content-Type: application/json');
$data = [];

$p = new Pessoa;
$p->setId($id);
$data["pessoa"] = $p->show();

die(json_encode($data));
