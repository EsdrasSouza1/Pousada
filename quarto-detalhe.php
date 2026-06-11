<?php
require_once 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$quarto = getQuarto($id);

// Redireciona para o primeiro quarto se ID inválido
if (!$quarto) {
    header('Location: quartos.php');
    exit;
}

// Ícones por amenidade
$icones = [
    'Wi-Fi rápido e gratuito' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>',
    'Ar Condicionado Split'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>',
    'TV Smart'                 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
    'Frigobar'                 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>',
    'Cama Queen Size'          => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
    'Banheiro Privativo'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>',
    'Ventilador de Teto'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>',
    'Ventilador'               => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>',
    '3 Camas de Solteiro'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
    '1 Cama de Solteiro'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
    'Vista para o Quintal'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    'Mesa de Trabalho'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>',
    'Tomadas USB'              => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
];

$icone_padrao = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';

// Galeria de imagens adicionais por quarto
$galerias = [
    1 => ['img/quintal.png' => 'Quintal Arborizado', 'img/araras.png' => 'Vista da Cidade'],
    2 => ['img/quintal.png' => 'Quintal Arborizado', 'img/araras.png' => 'Vista da Cidade'],
];
$galeria = $galerias[$quarto['id']] ?? ['img/quintal.png' => 'Quintal Arborizado', 'img/araras.png' => 'Vista da Cidade'];

$todos_quartos = getQuartos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($quarto['nome']) ?> - Pousada Barão</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <a href="quartos.php" style="color:var(--green)">Acomodações</a>
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
        <div class="section-inner">
            <div class="breadcrumb" style="justify-content: flex-start; margin-bottom: 24px;">
                <a href="index.php" style="color:var(--gray-500)">Início</a>
                <span style="color:var(--gray-400)">/</span>
                <a href="quartos.php" style="color:var(--gray-500)">Acomodações</a>
                <span style="color:var(--gray-400)">/</span>
                <span style="color:var(--green); font-weight: 600;"><?= htmlspecialchars($quarto['nome']) ?></span>
            </div>

            <!-- Navegação entre quartos -->
            <div style="display:flex; gap:8px; margin-bottom:32px; flex-wrap:wrap;">
                <?php foreach ($todos_quartos as $q): ?>
                    <a href="quarto-detalhe.php?id=<?= $q['id'] ?>"
                       style="padding: 6px 16px; border-radius: 20px; font-size:0.8rem; font-weight:700; border: 1px solid var(--border-color);
                              background: <?= $q['id'] === $quarto['id'] ? 'var(--green)' : '#fff' ?>;
                              color: <?= $q['id'] === $quarto['id'] ? '#fff' : 'var(--text-muted)' ?>;">
                        <?= htmlspecialchars($q['nome']) ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="detail-grid">
                <!-- Lado Esquerdo: Info -->
                <div>
                    <div class="detail-info">
                        <h1><?= htmlspecialchars($quarto['nome']) ?></h1>
                        <div class="detail-meta">
                            <span style="display:flex; align-items:center; gap:4px; font-weight:700;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="var(--orange)"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <?= number_format($quarto['avaliacao'], 1) ?> (<?= $quarto['total_avaliacoes'] ?> Avaliações)
                            </span>
                            <span style="color:var(--gray-400)">•</span>
                            <span style="color:var(--gray-600); text-decoration: underline;">Araras, São Paulo, Brasil</span>
                        </div>
                    </div>

                    <div class="detail-photos">
                        <div class="main-photo">
                            <img src="<?= htmlspecialchars($quarto['imagem']) ?>" alt="<?= htmlspecialchars($quarto['nome']) ?>">
                        </div>
                        <?php foreach (array_values($galeria) as $idx => $alt):
                            $src = array_keys($galeria)[$idx];
                        ?>
                        <div>
                            <img src="<?= $src ?>" alt="<?= htmlspecialchars($alt) ?>" style="width:100%;height:100%;object-fit:cover;border-radius:var(--radius);">
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div style="margin-top: 40px; padding-bottom: 32px; border-bottom: 1px solid var(--gray-200);">
                        <h2 style="font-size: 1.4rem; color: var(--green); margin-bottom: 8px;">Quarto em Pousada Boutique</h2>
                        <p style="color: var(--gray-500);">
                            Acomoda <?= $quarto['capacidade'] ?> <?= $quarto['capacidade'] === 1 ? 'hóspede' : 'hóspedes' ?> ·
                            <?php if ($quarto['tipo'] === 'casal'): ?>
                                1 cama queen · Banheiro privativo
                            <?php elseif ($quarto['tipo'] === 'familia'): ?>
                                3 camas de solteiro · Banheiro privativo
                            <?php else: ?>
                                1 cama de solteiro · Banheiro privativo
                            <?php endif; ?>
                        </p>
                    </div>

                    <!-- Amenidades -->
                    <div style="margin-top: 32px; padding-bottom: 32px; border-bottom: 1px solid var(--gray-200);">
                        <h3 style="font-size: 1.2rem; color: var(--gray-800); margin-bottom: 20px;">O que esse lugar oferece</h3>
                        <div class="detail-amenities" style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <?php foreach ($quarto['amenidades'] as $amenidade):
                                $path = $icones[$amenidade] ?? $icone_padrao;
                            ?>
                            <div class="detail-amenity">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="22" height="22"><?= $path ?></svg>
                                <?= htmlspecialchars($amenidade) ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Descrição longa -->
                    <div style="margin-top: 32px;">
                        <h3 style="font-size: 1.2rem; color: var(--gray-800); margin-bottom: 16px;">Sobre este espaço</h3>
                        <p style="color: var(--gray-600); line-height: 1.7;"><?= htmlspecialchars($quarto['descricao_longa']) ?></p>
                    </div>
                </div>

                <!-- Lado Direito: Widget Reserva -->
                <div>
                    <div class="booking-card" style="position: sticky; top: 110px;">
                        <div class="booking-card-price">
                            R$ <?= number_format($quarto['preco'], 0, ',', '.') ?> <span>/ noite</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:4px; margin-top:4px; margin-bottom:20px;">
                            <i class="fa-solid fa-star" style="color:var(--orange); font-size:0.8rem;"></i>
                            <span style="font-size:0.85rem; font-weight:700;"><?= number_format($quarto['avaliacao'], 1) ?></span>
                            <span style="font-size:0.8rem; color:var(--gray-500);">(<?= $quarto['total_avaliacoes'] ?> avaliações)</span>
                        </div>

                        <form action="reserva.php" method="GET">
                            <input type="hidden" name="quarto_id" value="<?= $quarto['id'] ?>">
                            <div style="border: 1px solid var(--gray-300); border-radius: 12px; overflow: hidden; margin-bottom: 16px;">
                                <div style="display:flex; border-bottom: 1px solid var(--gray-300);">
                                    <div style="flex:1; padding:12px; border-right: 1px solid var(--gray-300);">
                                        <label class="form-label" style="font-size: 0.65rem;">Check-in</label>
                                        <input type="date" name="data_entrada" id="detalhe_checkin" required
                                               style="width:100%; border:none; outline:none; font-family:inherit; font-size: 0.9rem; color: var(--gray-800);">
                                    </div>
                                    <div style="flex:1; padding:12px;">
                                        <label class="form-label" style="font-size: 0.65rem;">Check-out</label>
                                        <input type="date" name="data_saida" id="detalhe_checkout" required
                                               style="width:100%; border:none; outline:none; font-family:inherit; font-size: 0.9rem; color: var(--gray-800);">
                                    </div>
                                </div>
                                <div style="padding:12px;">
                                    <label class="form-label" style="font-size: 0.65rem;">Hóspedes</label>
                                    <select name="quantidade_pessoas" style="width:100%; border:none; outline:none; font-family:inherit; font-size: 0.9rem; color: var(--gray-800);">
                                        <?php for ($i = 1; $i <= $quarto['capacidade']; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?> <?= $i === 1 ? 'Hóspede' : 'Hóspedes' ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn-reserve" style="width:100%; display:block; text-align:center;">
                                Reservar este Quarto
                            </button>
                            <p style="text-align:center; font-size:0.8rem; color:var(--gray-500); margin-top:12px;">
                                <i class="fa-solid fa-lock" style="font-size:0.7rem;"></i> Você não será cobrado agora
                            </p>
                        </form>

                        <div class="price-summary" id="priceSummary" style="display:none;">
                            <div class="price-row">
                                <span>R$ <?= $quarto['preco'] ?> x <span id="numNoites">0</span> noites</span>
                                <span id="subtotal">R$ 0</span>
                            </div>
                            <div class="price-row">
                                <span>Taxa de serviço</span>
                                <span>R$ 0</span>
                            </div>
                            <div class="price-row total">
                                <span>Total</span>
                                <span id="totalPrice">R$ 0</span>
                            </div>
                        </div>
                    </div>
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

    <script>
        // Mobile nav
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('open');
        });

        // Calcula total de noites ao alterar datas
        const precoPorNoite = <?= $quarto['preco'] ?>;
        const checkin  = document.getElementById('detalhe_checkin');
        const checkout = document.getElementById('detalhe_checkout');
        const summary  = document.getElementById('priceSummary');

        function calcularTotal() {
            if (!checkin.value || !checkout.value) { summary.style.display = 'none'; return; }
            const d1 = new Date(checkin.value);
            const d2 = new Date(checkout.value);
            const noites = Math.round((d2 - d1) / 86400000);
            if (noites <= 0) { summary.style.display = 'none'; return; }
            const total = noites * precoPorNoite;
            document.getElementById('numNoites').textContent = noites;
            document.getElementById('subtotal').textContent  = 'R$ ' + total.toLocaleString('pt-BR');
            document.getElementById('totalPrice').textContent = 'R$ ' + total.toLocaleString('pt-BR');
            summary.style.display = 'block';
        }

        // Define data mínima como hoje
        const hoje = new Date().toISOString().split('T')[0];
        checkin.min  = hoje;
        checkout.min = hoje;

        checkin.addEventListener('change', function() {
            checkout.min = this.value;
            if (checkout.value && checkout.value <= this.value) checkout.value = '';
            calcularTotal();
        });
        checkout.addEventListener('change', calcularTotal);
    </script>
</body>
</html>
