<?php
// db.php - Camada de dados MySQL (PDO)
// Mantém a mesma interface das funções usadas pelas páginas:
// getQuartos(), getQuarto(), addReserva(), checkDisponibilidade(),
// getReservas(), deleteReserva(), updateStatusReserva().
//
// Conexão configurada por variáveis de ambiente (Railway injeta automaticamente):
//   MYSQLHOST, MYSQLPORT, MYSQLUSER, MYSQLPASSWORD, MYSQLDATABASE
// Para rodar localmente, defina-as ou ajuste os defaults abaixo.

function getPDO(): PDO {
    static $pdo = null;
    if ($pdo !== null) return $pdo;

    $host = getenv('MYSQLHOST')     ?: '127.0.0.1';
    $port = getenv('MYSQLPORT')     ?: '3306';
    $user = getenv('MYSQLUSER')     ?: 'root';
    $pass = getenv('MYSQLPASSWORD') ?: '';
    $name = getenv('MYSQLDATABASE') ?: 'pousada';

    $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    ensureSchema($pdo);
    return $pdo;
}

// Cria tabelas, triggers e seed apenas se ainda não existirem.
// Roda de forma leve: se a tabela 'quartos' já existe, não faz nada.
function ensureSchema(PDO $pdo): void {
    try {
        $pdo->query("SELECT 1 FROM quartos LIMIT 1");
        return; // já inicializado
    } catch (PDOException $e) {
        // tabela ainda não existe -> inicializa
    }

    $pdo->exec("CREATE TABLE IF NOT EXISTS quartos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(120) NOT NULL,
        tipo VARCHAR(40) NOT NULL,
        descricao TEXT NOT NULL,
        descricao_longa TEXT NOT NULL,
        preco DECIMAL(10,2) NOT NULL,
        capacidade INT NOT NULL,
        imagem VARCHAR(255) NOT NULL,
        avaliacao DECIMAL(3,1) NOT NULL DEFAULT 0,
        total_avaliacoes INT NOT NULL DEFAULT 0,
        amenidades JSON NOT NULL,
        badge VARCHAR(80) NOT NULL DEFAULT ''
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS reservas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome_cliente VARCHAR(150) NOT NULL,
        telefone VARCHAR(40) NOT NULL,
        quarto_id INT NOT NULL,
        data_entrada DATE NOT NULL,
        data_saida DATE NOT NULL,
        quantidade_pessoas INT NOT NULL,
        status ENUM('pendente','confirmada','cancelada') NOT NULL DEFAULT 'pendente',
        data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT fk_reserva_quarto FOREIGN KEY (quarto_id) REFERENCES quartos(id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Tabela de auditoria preenchida pelos triggers
    $pdo->exec("CREATE TABLE IF NOT EXISTS reservas_log (
        id INT AUTO_INCREMENT PRIMARY KEY,
        reserva_id INT NOT NULL,
        acao VARCHAR(40) NOT NULL,
        status_antigo VARCHAR(20) NULL,
        status_novo VARCHAR(20) NULL,
        data_evento DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // ---- TRIGGERS ----
    // PDO::exec executa um statement por chamada, então não usamos DELIMITER.
    $pdo->exec("DROP TRIGGER IF EXISTS trg_reservas_before_insert");
    $pdo->exec("CREATE TRIGGER trg_reservas_before_insert
        BEFORE INSERT ON reservas
        FOR EACH ROW
        BEGIN
            IF NEW.status IS NULL OR NEW.status = '' THEN
                SET NEW.status = 'pendente';
            END IF;
            IF NEW.data_criacao IS NULL THEN
                SET NEW.data_criacao = NOW();
            END IF;
        END");

    $pdo->exec("DROP TRIGGER IF EXISTS trg_reservas_after_insert");
    $pdo->exec("CREATE TRIGGER trg_reservas_after_insert
        AFTER INSERT ON reservas
        FOR EACH ROW
        BEGIN
            INSERT INTO reservas_log (reserva_id, acao, status_antigo, status_novo)
            VALUES (NEW.id, 'criada', NULL, NEW.status);
        END");

    $pdo->exec("DROP TRIGGER IF EXISTS trg_reservas_after_update");
    $pdo->exec("CREATE TRIGGER trg_reservas_after_update
        AFTER UPDATE ON reservas
        FOR EACH ROW
        BEGIN
            IF NEW.status <> OLD.status THEN
                INSERT INTO reservas_log (reserva_id, acao, status_antigo, status_novo)
                VALUES (NEW.id, 'status_alterado', OLD.status, NEW.status);
            END IF;
        END");

    // ---- SEED ----
    $count = (int)$pdo->query("SELECT COUNT(*) FROM quartos")->fetchColumn();
    if ($count === 0) {
        $stmt = $pdo->prepare("INSERT INTO quartos
            (id, nome, tipo, descricao, descricao_longa, preco, capacidade, imagem, avaliacao, total_avaliacoes, amenidades, badge)
            VALUES (:id,:nome,:tipo,:descricao,:descricao_longa,:preco,:capacidade,:imagem,:avaliacao,:total_avaliacoes,:amenidades,:badge)");

        $stmt->execute([
            ':id' => 1, ':nome' => 'Quarto Coletivo', ':tipo' => 'coletivo',
            ':descricao' => 'Quarto amplo com 6 camas de solteiro. Ideal para grupos, equipes corporativas ou turmas que precisam de espaço com economia.',
            ':descricao_longa' => 'O Quarto Coletivo é a escolha certa para grupos que precisam de espaço sem abrir mão do conforto. Com 6 camas de solteiro em ambiente organizado e arejado, é excelente para equipes de trabalho, turmas ou grupos de amigos. Ventilador e frigobar completam a estadia.',
            ':preco' => 400, ':capacidade' => 6, ':imagem' => 'img/quartocom6.webp',
            ':avaliacao' => 4.8, ':total_avaliacoes' => 8,
            ':amenidades' => json_encode(['6 Camas de Solteiro','Ventilador','Frigobar','Wi-Fi rápido e gratuito','Banheiro Privativo','Espelho'], JSON_UNESCAPED_UNICODE),
            ':badge' => 'Ideal para Grupos',
        ]);

        $stmt->execute([
            ':id' => 2, ':nome' => 'Quarto Duplo', ':tipo' => 'duplo',
            ':descricao' => 'Quarto com 2 camas de solteiro e ventilador. Ótima opção para dois amigos ou colegas que viajam juntos.',
            ':descricao_longa' => 'O Quarto Duplo oferece praticidade e ótima relação custo-benefício para duplas. Com 2 camas de solteiro confortáveis e ventilador, é perfeito para quem busca o essencial com qualidade. Ambiente limpo, silencioso e com acesso ao quintal arborizado da pousada.',
            ':preco' => 150, ':capacidade' => 2, ':imagem' => 'img/quartocom2.webp',
            ':avaliacao' => 4.7, ':total_avaliacoes' => 6,
            ':amenidades' => json_encode(['2 Camas de Solteiro','Ventilador','Wi-Fi rápido e gratuito','Banheiro Privativo'], JSON_UNESCAPED_UNICODE),
            ':badge' => '',
        ]);
    }
}

// Normaliza uma linha de quarto vinda do banco para o formato usado pelas páginas.
function mapQuarto(array $row): array {
    $row['id']               = (int)$row['id'];
    $row['preco']            = (float)$row['preco'];
    $row['capacidade']       = (int)$row['capacidade'];
    $row['avaliacao']        = (float)$row['avaliacao'];
    $row['total_avaliacoes'] = (int)$row['total_avaliacoes'];
    $row['amenidades']       = json_decode($row['amenidades'] ?? '[]', true) ?: [];
    return $row;
}

function getQuartos(): array {
    $rows = getPDO()->query("SELECT * FROM quartos ORDER BY id")->fetchAll();
    return array_map('mapQuarto', $rows);
}

function getQuarto($id) {
    $stmt = getPDO()->prepare("SELECT * FROM quartos WHERE id = ?");
    $stmt->execute([(int)$id]);
    $row = $stmt->fetch();
    return $row ? mapQuarto($row) : null;
}

function addReserva($nome_cliente, $telefone, $quarto_id, $data_entrada, $data_saida, $quantidade_pessoas) {
    $stmt = getPDO()->prepare("INSERT INTO reservas
        (nome_cliente, telefone, quarto_id, data_entrada, data_saida, quantidade_pessoas, status)
        VALUES (?, ?, ?, ?, ?, ?, 'pendente')");
    return $stmt->execute([
        htmlspecialchars(trim($nome_cliente), ENT_QUOTES, 'UTF-8'),
        htmlspecialchars(trim($telefone), ENT_QUOTES, 'UTF-8'),
        (int)$quarto_id,
        $data_entrada,
        $data_saida,
        (int)$quantidade_pessoas,
    ]);
}

// Retorna true se houver conflito de datas para o quarto (ignora canceladas).
function checkDisponibilidade($quarto_id, $data_entrada, $data_saida) {
    $stmt = getPDO()->prepare("SELECT COUNT(*) FROM reservas
        WHERE quarto_id = ?
          AND status <> 'cancelada'
          AND data_entrada < ?
          AND data_saida > ?");
    $stmt->execute([(int)$quarto_id, $data_saida, $data_entrada]);
    return ((int)$stmt->fetchColumn()) > 0;
}

function getReservas($filtro_data = '') {
    $sql = "SELECT r.*, q.nome AS quarto_nome
            FROM reservas r
            LEFT JOIN quartos q ON q.id = r.quarto_id";
    $params = [];
    if ($filtro_data) {
        $sql .= " WHERE ? BETWEEN r.data_entrada AND r.data_saida";
        $params[] = $filtro_data;
    }
    $sql .= " ORDER BY r.data_entrada ASC";

    $stmt = getPDO()->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();
    foreach ($rows as &$r) {
        $r['id']                 = (int)$r['id'];
        $r['quarto_id']          = (int)$r['quarto_id'];
        $r['quantidade_pessoas'] = (int)$r['quantidade_pessoas'];
        $r['quarto_nome']        = $r['quarto_nome'] ?? 'Quarto Desconhecido';
    }
    return $rows;
}

// Reservas ativas (não canceladas) de um quarto — usado pela API de disponibilidade.
function getReservasPorQuarto($quarto_id): array {
    $stmt = getPDO()->prepare("SELECT data_entrada, data_saida
        FROM reservas
        WHERE quarto_id = ? AND status <> 'cancelada'");
    $stmt->execute([(int)$quarto_id]);
    return $stmt->fetchAll();
}

function deleteReserva($id) {
    $stmt = getPDO()->prepare("DELETE FROM reservas WHERE id = ?");
    $stmt->execute([(int)$id]);
    return $stmt->rowCount() > 0;
}

function updateStatusReserva($id, $status) {
    $statuses_validos = ['pendente', 'confirmada', 'cancelada'];
    if (!in_array($status, $statuses_validos, true)) return false;

    $stmt = getPDO()->prepare("UPDATE reservas SET status = ? WHERE id = ?");
    $stmt->execute([$status, (int)$id]);
    return $stmt->rowCount() > 0;
}
?>
