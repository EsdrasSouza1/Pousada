<?php
require_once 'db.php';
header('Content-Type: application/json');
header('Cache-Control: no-cache');

$quarto_id = isset($_GET['quarto_id']) ? (int)$_GET['quarto_id'] : 0;
if (!$quarto_id) { echo json_encode([]); exit; }

$bloqueados = [];
foreach (getReservasPorQuarto($quarto_id) as $r) {
    $bloqueados[] = [
        'data_entrada' => $r['data_entrada'],
        'data_saida'   => $r['data_saida'],
    ];
}

echo json_encode($bloqueados);
