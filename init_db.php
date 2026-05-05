<?php
// init_db.php

try {
    // Connect to SQLite database (creates the file if it doesn't exist)
    $db = new PDO('sqlite:banco.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create 'quartos' table
    $db->exec("CREATE TABLE IF NOT EXISTS quartos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        capacidade INTEGER NOT NULL
    )");

    // Create 'reservas' table
    $db->exec("CREATE TABLE IF NOT EXISTS reservas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome_cliente TEXT NOT NULL,
        telefone TEXT NOT NULL,
        quarto_id INTEGER NOT NULL,
        data_entrada TEXT NOT NULL,
        data_saida TEXT NOT NULL,
        quantidade_pessoas INTEGER NOT NULL,
        FOREIGN KEY (quarto_id) REFERENCES quartos(id)
    )");

    // Seed the database with rooms if it's empty
    $stmt = $db->query("SELECT COUNT(*) FROM quartos");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        $quartosData = [
            ['nome' => 'Quarto 1 (Até 8 pessoas)', 'capacidade' => 8],
            ['nome' => 'Quarto 2 (Até 8 pessoas)', 'capacidade' => 8],
            ['nome' => 'Quarto 3 (Até 8 pessoas)', 'capacidade' => 8],
            ['nome' => 'Quarto 4 (Até 8 pessoas)', 'capacidade' => 8],
            ['nome' => 'Quarto 5 (Até 8 pessoas)', 'capacidade' => 8],
            ['nome' => 'Quarto Master (Até 10 pessoas)', 'capacidade' => 10],
        ];

        $insertStmt = $db->prepare("INSERT INTO quartos (nome, capacidade) VALUES (:nome, :capacidade)");
        
        foreach ($quartosData as $quarto) {
            $insertStmt->execute([
                ':nome' => $quarto['nome'],
                ':capacidade' => $quarto['capacidade']
            ]);
        }
        echo "Banco de dados inicializado com sucesso e quartos adicionados!";
    } else {
        echo "Banco de dados já estava inicializado.";
    }

} catch (PDOException $e) {
    die("Erro ao conectar ou inicializar o banco de dados: " . $e->getMessage());
}
?>
