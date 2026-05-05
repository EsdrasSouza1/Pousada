<?php
// db.php - JSON Database (Sem necessidade de drivers PDO)

$dbFile = __DIR__ . '/database.json';

// Estrutura inicial do banco de dados
$defaultDb = [
    'quartos' => [
        ['id' => 1, 'nome' => 'Quarto 1 (Até 8 pessoas)', 'capacidade' => 8],
        ['id' => 2, 'nome' => 'Quarto 2 (Até 8 pessoas)', 'capacidade' => 8],
        ['id' => 3, 'nome' => 'Quarto 3 (Até 8 pessoas)', 'capacidade' => 8],
        ['id' => 4, 'nome' => 'Quarto 4 (Até 8 pessoas)', 'capacidade' => 8],
        ['id' => 5, 'nome' => 'Quarto 5 (Até 8 pessoas)', 'capacidade' => 8],
        ['id' => 6, 'nome' => 'Quarto Master (Até 10 pessoas)', 'capacidade' => 10],
    ],
    'reservas' => [],
    'next_reserva_id' => 1
];

// Criar o arquivo se não existir
if (!file_exists($dbFile)) {
    file_put_contents($dbFile, json_encode($defaultDb, JSON_PRETTY_PRINT));
}

// Funções de manipulação do banco de dados
function lerBanco() {
    global $dbFile;
    $conteudo = file_get_contents($dbFile);
    return json_decode($conteudo, true);
}

function salvarBanco($dados) {
    global $dbFile;
    file_put_contents($dbFile, json_encode($dados, JSON_PRETTY_PRINT));
}

function getQuartos() {
    $db = lerBanco();
    return $db['quartos'];
}

function getQuarto($id) {
    $db = lerBanco();
    foreach ($db['quartos'] as $q) {
        if ($q['id'] == $id) return $q;
    }
    return null;
}

function addReserva($nome_cliente, $telefone, $quarto_id, $data_entrada, $data_saida, $quantidade_pessoas) {
    $db = lerBanco();
    $novaReserva = [
        'id' => $db['next_reserva_id']++,
        'nome_cliente' => $nome_cliente,
        'telefone' => $telefone,
        'quarto_id' => $quarto_id,
        'data_entrada' => $data_entrada,
        'data_saida' => $data_saida,
        'quantidade_pessoas' => $quantidade_pessoas,
        'data_criacao' => date('Y-m-d H:i:s')
    ];
    $db['reservas'][] = $novaReserva;
    salvarBanco($db);
    return true;
}

function checkDisponibilidade($quarto_id, $data_entrada, $data_saida) {
    $db = lerBanco();
    $conflitos = 0;
    
    foreach ($db['reservas'] as $r) {
        if ($r['quarto_id'] == $quarto_id) {
            // Verifica sobreposição de datas
            if ($data_entrada < $r['data_saida'] && $data_saida > $r['data_entrada']) {
                $conflitos++;
            }
        }
    }
    return $conflitos > 0; // True se houver conflito
}

function getReservas($filtro_data = '') {
    $db = lerBanco();
    $reservas = $db['reservas'];
    $quartos = array_column($db['quartos'], 'nome', 'id');
    
    $resultado = [];
    foreach ($reservas as $r) {
        // Aplica filtro de data
        if ($filtro_data) {
            if ($filtro_data < $r['data_entrada'] || $filtro_data > $r['data_saida']) {
                if ($filtro_data != $r['data_entrada'] && $filtro_data != $r['data_saida']) {
                    continue; // Pula se não bater a data
                }
            }
        }
        
        $r['quarto_nome'] = $quartos[$r['quarto_id']] ?? 'Quarto Desconhecido';
        $resultado[] = $r;
    }
    
    // Ordenar por data de entrada
    usort($resultado, function($a, $b) {
        return strtotime($a['data_entrada']) - strtotime($b['data_entrada']);
    });
    
    return $resultado;
}

function deleteReserva($id) {
    $db = lerBanco();
    foreach ($db['reservas'] as $key => $r) {
        if ($r['id'] == $id) {
            unset($db['reservas'][$key]);
            $db['reservas'] = array_values($db['reservas']); // Re-indexar array
            salvarBanco($db);
            return true;
        }
    }
    return false;
}
?>
