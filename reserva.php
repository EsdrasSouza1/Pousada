<?php
require_once 'db.php';

$mensagem = '';
$sucesso  = false;
$erros    = [];

// Pré-seleção de campos via GET (vindo da página de detalhe)
$pre_quarto    = isset($_GET['quarto_id'])        ? (int)$_GET['quarto_id']          : '';
$pre_entrada   = $_GET['data_entrada'] ?? '';
$pre_saida     = $_GET['data_saida']   ?? '';
$pre_pessoas   = isset($_GET['quantidade_pessoas']) ? (int)$_GET['quantidade_pessoas'] : 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome             = trim($_POST['nome']             ?? '');
    $telefone         = trim($_POST['telefone']         ?? '');
    $quarto_id        = (int)($_POST['quarto_id']       ?? 0);
    $data_entrada     = $_POST['data_entrada']          ?? '';
    $data_saida       = $_POST['data_saida']            ?? '';
    $quantidade_pessoas = (int)($_POST['quantidade_pessoas'] ?? 1);

    // Validações
    if (!$nome)         $erros[] = 'O nome completo é obrigatório.';
    if (!$telefone)     $erros[] = 'O WhatsApp/telefone é obrigatório.';
    if (!$quarto_id)    $erros[] = 'Selecione uma acomodação.';
    if (!$data_entrada) $erros[] = 'Informe a data de entrada (check-in).';
    if (!$data_saida)   $erros[] = 'Informe a data de saída (check-out).';

    if ($data_entrada && $data_saida) {
        if ($data_entrada >= $data_saida) {
            $erros[] = 'A data de saída deve ser posterior à data de entrada.';
        }
        if ($data_entrada < date('Y-m-d')) {
            $erros[] = 'A data de entrada não pode ser no passado.';
        }
    }

    $quarto_selecionado = $quarto_id ? getQuarto($quarto_id) : null;
    if ($quarto_selecionado && $quantidade_pessoas > $quarto_selecionado['capacidade']) {
        $erros[] = "Este quarto acomoda no máximo {$quarto_selecionado['capacidade']} pessoas.";
    }

    if (empty($erros) && checkDisponibilidade($quarto_id, $data_entrada, $data_saida)) {
        $erros[] = 'Este quarto já está reservado para o período selecionado. Por favor, escolha outras datas ou outro quarto.';
    }

    if (empty($erros)) {
        addReserva($nome, $telefone, $quarto_id, $data_entrada, $data_saida, $quantidade_pessoas);
        $mensagem = 'Sua solicitação de reserva foi enviada com sucesso! Entraremos em contato pelo WhatsApp em breve.';
        $sucesso  = true;
    }
}

$quartos = getQuartos();
$hoje    = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Reserva - Pousada Barão</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-day.flatpickr-disabled { background: #fee2e2 !important; color: #f87171 !important; text-decoration: line-through; cursor: not-allowed; }
        .flatpickr-input { cursor: pointer; }
    </style>
</head>
<body class="bg-gray">

    <!-- NAVBAR -->
    <nav class="nav">
        <div class="nav-inner">
            <a href="index.php" class="nav-logo">
                <img src="img/logo fundo removido.png" alt="Logo Pousada Barão">
            </a>
            <div class="nav-links">
                <a href="index.php">Início</a>
                <a href="infraestrutura.php">Infraestrutura</a>
                <a href="quartos.php">Acomodações</a>
                <a href="contato.php">Contato</a>
                <a href="reserva.php" class="btn-nav" style="color:#fff;">Reservar Agora</a>
            </div>
            <button class="nav-mobile-btn" id="mobileMenuBtn" aria-label="Abrir menu">
                <span></span><span></span><span></span>
            </button>
        </div>
        <div class="nav-mobile" id="mobileMenu">
            <a href="index.php">Início</a>
            <a href="infraestrutura.php">Infraestrutura</a>
            <a href="quartos.php">Acomodações</a>
            <a href="contato.php">Contato</a>
            <a href="reserva.php">Reservar Agora</a>
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
                    <p style="color: var(--green-pale);">Preencha seus dados para solicitar sua estadia. Sem taxas ocultas.</p>
                </div>

                <div style="padding: 40px;">

                    <?php if (!empty($erros)): ?>
                        <div style="padding: 16px; margin-bottom: 24px; border-radius: 8px; background: #fee2e2; color: #991b1b; border: 1px solid #f87171;">
                            <strong><i class="fa-solid fa-triangle-exclamation"></i> Atenção:</strong>
                            <ul style="margin-top: 8px; padding-left: 20px;">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if ($sucesso): ?>
                        <div style="padding: 24px; margin-bottom: 24px; border-radius: 8px; background: #d1fae5; color: #065f46; border: 1px solid #34d399; text-align:center;">
                            <i class="fa-solid fa-circle-check" style="font-size:2.5rem; margin-bottom:12px;"></i>
                            <h3 style="font-size:1.3rem; margin-bottom:8px;">Reserva enviada com sucesso!</h3>
                            <p><?= htmlspecialchars($mensagem) ?></p>
                        </div>
                        <div style="text-align: center; margin-top: 20px; display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
                            <a href="index.php" class="btn-reserve" style="display:inline-flex; align-items:center; gap:8px; padding: 12px 24px; text-decoration:none;">
                                <i class="fa-solid fa-house"></i> Voltar para o Início
                            </a>
                            <a href="https://wa.me/5519996544617" target="_blank" class="btn-reserve"
                               style="display:inline-flex; align-items:center; gap:8px; padding:12px 24px; text-decoration:none; background: #25D366;">
                                <i class="fa-brands fa-whatsapp"></i> Confirmar pelo WhatsApp
                            </a>
                        </div>
                    <?php else: ?>

                    <!-- Formulário de Reserva -->
                    <form action="reserva.php" method="POST" class="form-grid" id="formReserva" novalidate>

                        <div class="form-group full" style="margin-bottom: 16px;">
                            <h3 style="font-size: 1.2rem; color: var(--green); border-bottom: 1px solid var(--gray-200); padding-bottom: 8px;">
                                <i class="fa-solid fa-user"></i> Dados Pessoais
                            </h3>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nome Completo <span style="color:red">*</span></label>
                            <input type="text" name="nome" class="form-input"
                                   placeholder="Ex: João da Silva"
                                   value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">WhatsApp / Telefone <span style="color:red">*</span></label>
                            <input type="tel" name="telefone" class="form-input"
                                   placeholder="(19) 99999-9999"
                                   value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" required>
                        </div>

                        <div class="form-group full" style="margin-bottom: 16px; margin-top: 16px;">
                            <h3 style="font-size: 1.2rem; color: var(--green); border-bottom: 1px solid var(--gray-200); padding-bottom: 8px;">
                                <i class="fa-solid fa-bed"></i> Detalhes da Estadia
                            </h3>
                        </div>

                        <div class="form-group full">
                            <label class="form-label">Acomodação Desejada <span style="color:red">*</span></label>
                            <select name="quarto_id" class="form-select" id="selectQuarto" required>
                                <option value="">Selecione a acomodação</option>
                                <?php foreach ($quartos as $q): ?>
                                    <option value="<?= $q['id'] ?>"
                                        data-preco="<?= $q['preco'] ?>"
                                        data-capacidade="<?= $q['capacidade'] ?>"
                                        <?= ((int)($_POST['quarto_id'] ?? $pre_quarto) === $q['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($q['nome']) ?> — R$ <?= number_format($q['preco'], 0, ',', '.') ?>/noite (até <?= $q['capacidade'] ?> pess.)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Data de Entrada (Check-in) <span style="color:red">*</span></label>
                            <input type="date" name="data_entrada" class="form-input" id="checkin"
                                   min="<?= $hoje ?>"
                                   value="<?= htmlspecialchars($_POST['data_entrada'] ?? $pre_entrada) ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Data de Saída (Check-out) <span style="color:red">*</span></label>
                            <input type="date" name="data_saida" class="form-input" id="checkout"
                                   min="<?= $hoje ?>"
                                   value="<?= htmlspecialchars($_POST['data_saida'] ?? $pre_saida) ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Quantidade de Pessoas <span style="color:red">*</span></label>
                            <input type="number" name="quantidade_pessoas" class="form-input" id="numPessoas"
                                   min="1" max="10"
                                   value="<?= (int)($_POST['quantidade_pessoas'] ?? $pre_pessoas) ?>" required>
                        </div>

                        <!-- Resumo dinâmico de preço -->
                        <div class="form-group" id="resumoPreco" style="display:none; background:var(--green-pale); border-radius:var(--radius); padding:16px; border: 1px solid var(--border-color);">
                            <p style="font-size:0.85rem; color:var(--text-muted); font-weight:600; margin-bottom:8px;">Resumo da Reserva</p>
                            <div style="display:flex; justify-content:space-between; font-size:0.9rem; margin-bottom:4px;">
                                <span id="resumoDesc">—</span>
                                <span id="resumoTotal" style="font-weight:700; color:var(--green);">—</span>
                            </div>
                        </div>

                        <div class="form-group" style="display:flex; flex-direction:column; justify-content:flex-end;">
                            <button type="submit" class="btn-reserve">
                                <i class="fa-solid fa-paper-plane"></i> Confirmar e Enviar Solicitação
                            </button>
                        </div>

                    </form>
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
                        <img src="img/logo fundo removido.png" alt="Logo Pousada Barão">
                    </div>
                    <p>O melhor padrão de descanso do interior paulista. Hospedagem de alta qualidade e conforto.</p>
                </div>
                <div class="footer-col">
                    <h4>Navegação</h4>
                    <ul>
                        <li><a href="index.php">Página Inicial</a></li>
                        <li><a href="quartos.php">Acomodações</a></li>
                        <li><a href="infraestrutura.php">Infraestrutura</a></li>
                        <li><a href="admin.php">Área Admin</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contato</h4>
                    <ul>
                        <li><a href="https://wa.me/5519996544617"><i class="fa-brands fa-whatsapp"></i> (19) 99654-4617</a></li>
                        <li><i class="fa-solid fa-envelope"></i> contato@pousadabarao.com.br</li>
                        <li><i class="fa-solid fa-location-dot"></i> Rua Nunes Machado, Centro, Araras - SP</li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Políticas</h4>
                    <ul>
                        <li><a href="termos.php">Termos de Uso</a></li>
                        <li><a href="privacidade.php">Política de Privacidade</a></li>
                        <li><a href="cancelamento.php">Política de Cancelamento</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> Pousada Barão. Todos os direitos reservados.</p>
                <p>Ambiente Seguro <i class="fa-solid fa-lock"></i></p>
            </div>
        </div>
    </footer>

    <!-- WHATSAPP FLOAT -->
    <a href="https://wa.me/5519996544617" class="whatsapp-float" target="_blank" title="Fale conosco no WhatsApp">
        <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
    <script>
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('open');
        });

        const selectQ  = document.getElementById('selectQuarto');
        const resumo   = document.getElementById('resumoPreco');
        const resumoD  = document.getElementById('resumoDesc');
        const resumoT  = document.getElementById('resumoTotal');

        function atualizarResumo() {
            const opt = selectQ.options[selectQ.selectedIndex];
            const ci  = fpCheckin  ? fpCheckin.input.value  : '';
            const co  = fpCheckout ? fpCheckout.input.value : '';
            if (!opt || !opt.value || !ci || !co) { resumo.style.display = 'none'; return; }
            const preco  = parseInt(opt.getAttribute('data-preco'));
            const noites = Math.round((new Date(co) - new Date(ci)) / 86400000);
            if (noites <= 0) { resumo.style.display = 'none'; return; }
            resumoD.textContent = `R$ ${preco.toLocaleString('pt-BR')} × ${noites} noite${noites > 1 ? 's' : ''}`;
            resumoT.textContent = `R$ ${(noites * preco).toLocaleString('pt-BR')}`;
            resumo.style.display = 'block';
            document.getElementById('numPessoas').max = parseInt(opt.getAttribute('data-capacidade'));
        }

        let reservasBloqueadas = [];
        let fpCheckin, fpCheckout;

        fpCheckin = flatpickr('#checkin', {
            dateFormat: 'Y-m-d',
            minDate: 'today',
            locale: 'pt',
            disable: [],
            onChange: function(_, dateStr) {
                if (dateStr) {
                    fpCheckout.set('minDate', dateStr);
                    atualizarLimitesCheckout(dateStr);
                }
                atualizarResumo();
            }
        });

        fpCheckout = flatpickr('#checkout', {
            dateFormat: 'Y-m-d',
            minDate: 'today',
            locale: 'pt',
            onChange: atualizarResumo
        });

        function atualizarLimitesCheckout(checkinDate) {
            let maxDate = null;
            for (const r of reservasBloqueadas) {
                if (r.data_entrada > checkinDate) {
                    if (!maxDate || r.data_entrada < maxDate) maxDate = r.data_entrada;
                }
            }
            fpCheckout.set('maxDate', maxDate || null);
            if (fpCheckout.selectedDates[0]) {
                const co = fpCheckout.selectedDates[0].toISOString().split('T')[0];
                if (maxDate && co > maxDate) fpCheckout.clear();
            }
        }

        async function carregarDisponibilidade(quartoId) {
            reservasBloqueadas = [];
            fpCheckin.set('disable', []);
            fpCheckout.set('maxDate', null);
            if (!quartoId) return;
            try {
                const resp = await fetch('api_disponibilidade.php?quarto_id=' + quartoId);
                reservasBloqueadas = await resp.json();
                const disabled = reservasBloqueadas.map(r => {
                    const saida = new Date(r.data_saida + 'T00:00:00');
                    saida.setDate(saida.getDate() - 1);
                    const saidaStr = saida.toISOString().split('T')[0];
                    return { from: r.data_entrada, to: saidaStr };
                }).filter(d => d.from <= d.to);
                fpCheckin.set('disable', disabled);
                const ci = fpCheckin.input.value;
                if (ci) atualizarLimitesCheckout(ci);
            } catch(e) {}
        }

        selectQ.addEventListener('change', function() {
            carregarDisponibilidade(this.value);
            atualizarResumo();
        });

        if (selectQ.value) carregarDisponibilidade(selectQ.value);
        atualizarResumo();
    </script>
</body>
</html>
