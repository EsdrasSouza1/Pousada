<?php
require_once 'db.php';
header('Content-Type: application/json');
header('Cache-Control: no-cache');

$quarto_id = isset($_GET['quarto_id']) ? (int)$_GET['quarto_id'] : 0;
if (!$quarto_id) { echo json_encode([]); exit; }

$db = lerBanco();
$bloqueados = [];

foreach ($db['reservas'] as $r) {
    if ($r['quarto_id'] != $quarto_id) continue;
    if (($r['status'] ?? 'pendente') === 'cancelada') continue;
    $bloqueados[] = [
        'data_entrada' => $r['data_entrada'],
        'data_saida'   => $r['data_saida'],
    ];
}

echo json_encode($bloqueados);
