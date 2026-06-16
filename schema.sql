-- =====================================================================
--  Pousada Barão — Esquema do Banco de Dados (MySQL 8+)
--  Tabelas, chave estrangeira, triggers de auditoria e dados iniciais.
--
--  Importação manual (cliente mysql):
--      mysql -h HOST -P PORTA -u USUARIO -p NOME_DO_BANCO < schema.sql
--  Ou cole o conteúdo no phpMyAdmin / MySQL Workbench.
--
--  Observação: a aplicação (db.php) também cria tudo isto automaticamente
--  na primeira execução. Este arquivo serve como documentação/entregável
--  e para importação manual quando desejado.
-- =====================================================================

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------
-- Tabela: quartos
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS quartos (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Tabela: reservas (FK -> quartos)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS reservas (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Tabela: reservas_log (auditoria — preenchida pelos triggers)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS reservas_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reserva_id INT NOT NULL,
    acao VARCHAR(40) NOT NULL,
    status_antigo VARCHAR(20) NULL,
    status_novo VARCHAR(20) NULL,
    data_evento DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
--  TRIGGERS
-- =====================================================================
DELIMITER //

-- BEFORE INSERT: garante status e data_criacao padrão
DROP TRIGGER IF EXISTS trg_reservas_before_insert//
CREATE TRIGGER trg_reservas_before_insert
BEFORE INSERT ON reservas
FOR EACH ROW
BEGIN
    IF NEW.status IS NULL OR NEW.status = '' THEN
        SET NEW.status = 'pendente';
    END IF;
    IF NEW.data_criacao IS NULL THEN
        SET NEW.data_criacao = NOW();
    END IF;
END//

-- AFTER INSERT: registra a criação da reserva no log
DROP TRIGGER IF EXISTS trg_reservas_after_insert//
CREATE TRIGGER trg_reservas_after_insert
AFTER INSERT ON reservas
FOR EACH ROW
BEGIN
    INSERT INTO reservas_log (reserva_id, acao, status_antigo, status_novo)
    VALUES (NEW.id, 'criada', NULL, NEW.status);
END//

-- AFTER UPDATE: registra mudança de status no log
DROP TRIGGER IF EXISTS trg_reservas_after_update//
CREATE TRIGGER trg_reservas_after_update
AFTER UPDATE ON reservas
FOR EACH ROW
BEGIN
    IF NEW.status <> OLD.status THEN
        INSERT INTO reservas_log (reserva_id, acao, status_antigo, status_novo)
        VALUES (NEW.id, 'status_alterado', OLD.status, NEW.status);
    END IF;
END//

DELIMITER ;

-- =====================================================================
--  DADOS INICIAIS (seed)
-- =====================================================================
INSERT INTO quartos
    (id, nome, tipo, descricao, descricao_longa, preco, capacidade, imagem, avaliacao, total_avaliacoes, amenidades, badge)
VALUES
    (1, 'Quarto Coletivo', 'coletivo',
     'Quarto amplo com 6 camas de solteiro. Ideal para grupos, equipes corporativas ou turmas que precisam de espaço com economia.',
     'O Quarto Coletivo é a escolha certa para grupos que precisam de espaço sem abrir mão do conforto. Com 6 camas de solteiro em ambiente organizado e arejado, é excelente para equipes de trabalho, turmas ou grupos de amigos. Ventilador e frigobar completam a estadia.',
     400.00, 6, 'img/quartocom6.webp', 4.8, 8,
     JSON_ARRAY('6 Camas de Solteiro','Ventilador','Frigobar','Wi-Fi rápido e gratuito','Banheiro Privativo','Espelho'),
     'Ideal para Grupos'),
    (2, 'Quarto Duplo', 'duplo',
     'Quarto com 2 camas de solteiro e ventilador. Ótima opção para dois amigos ou colegas que viajam juntos.',
     'O Quarto Duplo oferece praticidade e ótima relação custo-benefício para duplas. Com 2 camas de solteiro confortáveis e ventilador, é perfeito para quem busca o essencial com qualidade. Ambiente limpo, silencioso e com acesso ao quintal arborizado da pousada.',
     150.00, 2, 'img/quartocom2.webp', 4.7, 6,
     JSON_ARRAY('2 Camas de Solteiro','Ventilador','Wi-Fi rápido e gratuito','Banheiro Privativo'),
     '')
ON DUPLICATE KEY UPDATE nome = VALUES(nome);

-- Reserva de exemplo (migrada do antigo database.json)
INSERT INTO reservas
    (nome_cliente, telefone, quarto_id, data_entrada, data_saida, quantidade_pessoas, status, data_criacao)
VALUES
    ('Jonas', '19999151678', 1, '2026-06-10', '2026-06-11', 1, 'confirmada', '2026-06-09 22:34:17');
