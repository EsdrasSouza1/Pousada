<?php
// db.php - Camada de dados JSON (sem necessidade de drivers PDO)

$dbFile = __DIR__ . '/database.json';
$dbVersion = 4;

$defaultDb = [
    '_version' => $dbVersion,
    'quartos' => [
        [
            'id' => 1,
            'nome' => 'Quarto Coletivo',
            'tipo' => 'coletivo',
            'descricao' => 'Quarto amplo com 6 camas de solteiro. Ideal para grupos, equipes corporativas ou turmas que precisam de espaço com economia.',
            'descricao_longa' => 'O Quarto Coletivo é a escolha certa para grupos que precisam de espaço sem abrir mão do conforto. Com 6 camas de solteiro em ambiente organizado e arejado, é excelente para equipes de trabalho, turmas ou grupos de amigos. Ventilador e frigobar completam a estadia.',
            'preco' => 400,
            'capacidade' => 6,
            'imagem' => 'img/quartocom6.webp',
            'avaliacao' => 4.8,
            'total_avaliacoes' => 8,
            'amenidades' => ['6 Camas de Solteiro', 'Ventilador', 'Frigobar', 'Wi-Fi rápido e gratuito', 'Banheiro Privativo', 'Espelho'],
            'badge' => 'Ideal para Grupos'
        ],
        [
            'id' => 2,
            'nome' => 'Quarto Duplo',
            'tipo' => 'duplo',
            'descricao' => 'Quarto com 2 camas de solteiro e ventilador. Ótima opção para dois amigos ou colegas que viajam juntos.',
            'descricao_longa' => 'O Quarto Duplo oferece praticidade e ótima relação custo-benefício para duplas. Com 2 camas de solteiro confortáveis e ventilador, é perfeito para quem busca o essencial com qualidade. Ambiente limpo, silencioso e com acesso ao quintal arborizado da pousada.',
            'preco' => 150,
            'capacidade' => 2,
            'imagem' => 'img/quartocom2.webp',
            'avaliacao' => 4.7,
            'total_avaliacoes' => 6,
            'amenidades' => ['2 Camas de Solteiro', 'Ventilador', 'Wi-Fi rápido e gratuito', 'Banheiro Privativo'],
            'badge' => ''
        ],
    ],
    'reservas' => [],
    'next_reserva_id' => 1
];

// Criar ou atualizar banco se necessário
if (!file_exists($dbFile)) {
    file_put_contents($dbFile, json_encode($defaultDb, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
} else {
    $existing = json_decode(file_get_contents($dbFile), true);
    if (!isset($existing['_version']) || $existing['_version'] < $dbVersion) {
        // Preserva reservas existentes ao atualizar estrutura dos quartos
        $defaultDb['reservas'] = $existing['reservas'] ?? [];
        $defaultDb['next_reserva_id'] = $existing['next_reserva_id'] ?? 1;
        file_put_contents($dbFile, json_encode($defaultDb, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

function lerBanco() {
    global $dbFile;
    return json_decode(file_get_contents($dbFile), true);
}

function salvarBanco($dados) {
    global $dbFile;
    file_put_contents($dbFile, json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
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
        'id'                => $db['next_reserva_id']++,
        'nome_cliente'      => htmlspecialchars(trim($nome_cliente), ENT_QUOTES, 'UTF-8'),
        'telefone'          => htmlspecialchars(trim($telefone), ENT_QUOTES, 'UTF-8'),
        'quarto_id'         => (int)$quarto_id,
        'data_entrada'      => $data_entrada,
        'data_saida'        => $data_saida,
        'quantidade_pessoas'=> (int)$quantidade_pessoas,
        'status'            => 'pendente',
        'data_criacao'      => date('Y-m-d H:i:s')
    ];
    $db['reservas'][] = $novaReserva;
    salvarBanco($db);
    return true;
}

// Retorna true se houver conflito de datas para o quarto
function checkDisponibilidade($quarto_id, $data_entrada, $data_saida) {
    $db = lerBanco();
    foreach ($db['reservas'] as $r) {
        if ($r['quarto_id'] != $quarto_id) continue;
        if (($r['status'] ?? 'pendente') === 'cancelada') continue;
        if ($data_entrada < $r['data_saida'] && $data_saida > $r['data_entrada']) {
            return true;
        }
    }
    return false;
}

function getReservas($filtro_data = '') {
    $db = lerBanco();
    $quartos = array_column($db['quartos'], null, 'id');

    $resultado = [];
    foreach ($db['reservas'] as $r) {
        if ($filtro_data) {
            if ($filtro_data < $r['data_entrada'] || $filtro_data > $r['data_saida']) {
                continue;
            }
        }
        $r['quarto_nome'] = $quartos[$r['quarto_id']]['nome'] ?? 'Quarto Desconhecido';
        $resultado[] = $r;
    }

    usort($resultado, fn($a, $b) => strtotime($a['data_entrada']) - strtotime($b['data_entrada']));
    return $resultado;
}

function deleteReserva($id) {
    $db = lerBanco();
    foreach ($db['reservas'] as $key => $r) {
        if ($r['id'] == $id) {
            unset($db['reservas'][$key]);
            $db['reservas'] = array_values($db['reservas']);
            salvarBanco($db);
            return true;
        }
    }
    return false;
}

function updateStatusReserva($id, $status) {
    $statuses_validos = ['pendente', 'confirmada', 'cancelada'];
    if (!in_array($status, $statuses_validos)) return false;

    $db = lerBanco();
    foreach ($db['reservas'] as &$r) {
        if ($r['id'] == $id) {
            $r['status'] = $status;
            salvarBanco($db);
            return true;
        }
    }
    return false;
}
?>
