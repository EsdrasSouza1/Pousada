<?php
require_once 'db.php';

$mensagem = '';
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $quarto_id = $_POST['quarto_id'] ?? '';
    $data_entrada = $_POST['data_entrada'] ?? '';
    $data_saida = $_POST['data_saida'] ?? '';
    $quantidade_pessoas = $_POST['quantidade_pessoas'] ?? 1;

    if ($nome && $telefone && $quarto_id && $data_entrada && $data_saida) {
        // Sem verificar conflito no momento, apenas salvando a solicitação (como o usuário quer ver "quem quer alugar")
        addReserva($nome, $telefone, $quarto_id, $data_entrada, $data_saida, $quantidade_pessoas);
        $mensagem = "Sua solicitação de reserva foi enviada com sucesso! Entraremos em contato em breve.";
        $sucesso = true;
    } else {
        $mensagem = "Por favor, preencha todos os campos obrigatórios.";
    }
}

$quartos = getQuartos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Reserva - Pousada Barão</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray">

    <!-- NAVBAR -->
    <nav class="nav">
        <div class="nav-inner">
            <a href="index.php" class="nav-logo">
                <img src="img/Logo P.png" alt="Logo Pousada Barão">
            </a>
            <div class="nav-links">
                <a href="index.php">Início</a>
                <a href="infraestrutura.php">Infraestrutura</a>
                <a href="quartos.php">Acomodações</a>
                <a href="contato.php">Contato</a>
                <a href="reserva.php" class="btn-nav" style="color:#fff;">Reservar Agora</a>
            </div>
        </div>
    </nav>

    <div class="section" style="padding-top: 120px;">
        <div class="section-inner" style="max-width: 900px;">
            
            <a href="javascript:history.back()" style="display:flex; align-items:center; gap:8px; color:var(--gray-800); font-weight:600; margin-bottom: 32px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Voltar
            </a>

            <div style="background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); overflow: hidden;">
                <div style="background: var(--green); padding: 40px; text-align: center;">
                    <h1 style="font-family:'Playfair Display', serif; color: #fff; font-size: 2.2rem; margin-bottom: 8px;">Conclua sua Reserva</h1>
                    <p style="color: var(--green-pale);">Estamos quase lá. Preencha seus dados para solicitar sua estadia.</p>
                </div>

                <div style="padding: 40px;">
                    <?php if ($mensagem): ?>
                        <div style="padding: 16px; margin-bottom: 24px; border-radius: 8px; <?php echo $sucesso ? 'background: #d1fae5; color: #065f46; border: 1px solid #34d399;' : 'background: #fee2e2; color: #991b1b; border: 1px solid #f87171;'; ?>">
                            <?php echo htmlspecialchars($mensagem); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!$sucesso): ?>
                    <!-- Formulário de Reserva -->
                    <form action="reserva.php" method="POST" class="form-grid">
                        
                        <div class="form-group full" style="margin-bottom: 16px;">
                            <h3 style="font-size: 1.2rem; color: var(--green); border-bottom: 1px solid var(--gray-200); padding-bottom: 8px;">Dados Pessoais</h3>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nome Completo</label>
                            <input type="text" name="nome" class="form-input" placeholder="Ex: João da Silva" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">WhatsApp / Telefone</label>
                            <input type="text" name="telefone" class="form-input" placeholder="(00) 00000-0000" required>
                        </div>

                        <div class="form-group full" style="margin-bottom: 16px; margin-top: 16px;">
                            <h3 style="font-size: 1.2rem; color: var(--green); border-bottom: 1px solid var(--gray-200); padding-bottom: 8px;">Detalhes da Estadia</h3>
                        </div>

                        <div class="form-group full">
                            <label class="form-label">Quarto Selecionado</label>
                            <select name="quarto_id" class="form-select" required>
                                <option value="">Selecione a acomodação</option>
                                <?php foreach($quartos as $quarto): ?>
                                    <option value="<?php echo $quarto['id']; ?>"><?php echo htmlspecialchars($quarto['nome']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Data de Entrada (Check-in)</label>
                            <input type="date" name="data_entrada" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Data de Saída (Check-out)</label>
                            <input type="date" name="data_saida" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Quantidade de Pessoas</label>
                            <input type="number" name="quantidade_pessoas" class="form-input" min="1" value="2" required>
                        </div>
                        <div class="form-group" style="display:flex; flex-direction:column; justify-content:flex-end;">
                            <button type="submit" class="btn-reserve">Confirmar e Enviar</button>
                        </div>
                    </form>
                    <?php else: ?>
                        <div style="text-align: center; margin-top: 20px;">
                            <a href="index.php" class="btn-reserve" style="display: inline-block; padding: 12px 24px; text-decoration: none;">Voltar para o Início</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="nav-logo" style="color:#fff">
                        <img src="img/Logo P.png" alt="Logo Pousada Barão">
                    </div>
                    <p>O melhor padrão de descanso do interior paulista. Hospedagem de alta qualidade e conforto.</p>
                </div>
                
                <div class="footer-col">
                    <h4>Painel e Navegação</h4>
                    <ul>
                        <li><a href="index.php">Página Inicial</a></li>
                        <li><a href="quartos.php">Planos (Quartos)</a></li>
                        <li><a href="infraestrutura.php">Infraestrutura</a></li>
                        <li><a href="admin.php">Área do Cliente (Admin)</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Atendimento 24/7</h4>
                    <ul>
                        <li><a href="https://wa.me/5519996544617"><i class="fa-brands fa-whatsapp"></i> (19) 99654-4617</a></li>
                        <li><i class="fa-solid fa-envelope"></i> contato@pousadabarao.com.br</li>
                        <li><i class="fa-solid fa-location-dot"></i> Rua Nunes Machado, Centro, Araras - SP</li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Políticas</h4>
                    <ul>
                        <li><a href="#">Termos de Uso</a></li>
                        <li><a href="#">Política de Privacidade</a></li>
                        <li><a href="#">Política de Cancelamento</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2026 Pousada Barão. Todos os direitos reservados.</p>
                <p>Ambiente Seguro <i class="fa-solid fa-lock"></i></p>
            </div>
        </div>
    </footer>

    <!-- WHATSAPP FLOAT -->
    <a href="https://wa.me/5519996544617" class="whatsapp-float" target="_blank" title="Fale conosco no WhatsApp">
        <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>

</body>
</html>
