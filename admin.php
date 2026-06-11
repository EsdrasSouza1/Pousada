<?php
session_start();
require_once 'db.php';

$senha_correta = 'admin123';

// Processar login
if (isset($_POST['login'])) {
    if ($_POST['senha'] === $senha_correta) {
        $_SESSION['admin_logado'] = true;
        header('Location: admin.php');
        exit;
    }
    $erro_login = 'Senha incorreta. Tente novamente.';
}

// Processar logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

// Tela de login
if (!isset($_SESSION['admin_logado'])) {
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administração Pousada Barão</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans','sans-serif'] }, colors: { primary: '#2F4F4F', accent: '#C96A2A' } } } }</script>
</head>
<body class="bg-slate-50 font-sans flex items-center justify-center min-h-screen relative overflow-hidden">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-accent/20 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="relative z-10 w-full max-w-[420px] px-4">
        <div class="bg-white/70 backdrop-blur-xl p-10 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white">
            <div class="text-center mb-10">
                <div class="mx-auto mb-5 flex justify-center">
                    <img src="img/logo fundo removido.png" alt="Logo Pousada Barão" class="h-20 w-auto">
                </div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Gestão Barão</h1>
                <p class="text-slate-500 mt-2 font-medium">Acesse seu painel administrativo</p>
            </div>
            <?php if (isset($erro_login)): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="font-semibold text-sm"><?= htmlspecialchars($erro_login) ?></span>
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Senha de Acesso</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7z"/></svg>
                        </div>
                        <input type="password" name="senha" placeholder="••••••••" required
                               class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 bg-white/50 focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all duration-200 shadow-sm font-medium">
                    </div>
                </div>
                <button type="submit" name="login" class="w-full bg-slate-900 text-white font-bold py-3.5 rounded-xl hover:bg-primary hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 flex items-center justify-center gap-2">
                    Entrar no Painel
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>
            <div class="mt-8 text-center">
                <a href="index.php" class="text-sm font-semibold text-slate-400 hover:text-slate-600 transition-colors">← Voltar para o site</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    exit;
}

// ——— Ações Administrativas ———

// Excluir reserva
if (isset($_GET['excluir'])) {
    deleteReserva((int)$_GET['excluir']);
    header('Location: admin.php?msg=excluido');
    exit;
}

// Alterar status da reserva
if (isset($_GET['status']) && isset($_GET['id'])) {
    $novoStatus = $_GET['status'];
    $rid = (int)$_GET['id'];
    updateStatusReserva($rid, $novoStatus);
    if ($novoStatus === 'confirmada') {
        header('Location: admin.php?msg=confirmada&notificar_id=' . $rid);
    } else {
        header('Location: admin.php?msg=status');
    }
    exit;
}

// Filtros e dados
$filtro_data   = $_GET['data']   ?? '';
$filtro_status = $_GET['filtro'] ?? '';

$reservas_filtradas = getReservas($filtro_data);

// Filtro por status
if ($filtro_status) {
    $reservas_filtradas = array_filter($reservas_filtradas, fn($r) => ($r['status'] ?? 'pendente') === $filtro_status);
    $reservas_filtradas = array_values($reservas_filtradas);
}

$todas_reservas = getReservas();

$total_reservas   = count($todas_reservas);
$hoje             = date('Y-m-d');
$checkins_futuros = 0;
$hospedes_futuros = 0;
$pendentes        = 0;

foreach ($todas_reservas as $r) {
    if ($r['data_entrada'] >= $hoje) {
        $checkins_futuros++;
        $hospedes_futuros += $r['quantidade_pessoas'];
    }
    if (($r['status'] ?? 'pendente') === 'pendente') $pendentes++;
}

$status_config = [
    'pendente'   => ['label' => 'Pendente',   'bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'border' => 'border-amber-200'],
    'confirmada' => ['label' => 'Confirmada', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200'],
    'cancelada'  => ['label' => 'Cancelada',  'bg' => 'bg-red-50',     'text' => 'text-red-700',     'border' => 'border-red-200'],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Gestão - Pousada Barão</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans','sans-serif'] }, colors: { primary: '#2F4F4F', accent: '#C96A2A' } } } }</script>
    <style>
        ::-webkit-scrollbar { height: 8px; width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50/50 font-sans text-slate-800 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <img src="img/logo fundo removido.png" alt="Logo Pousada Barão" class="h-10 w-auto">
                    <div>
                        <h1 class="font-extrabold text-xl leading-tight text-slate-900">Pousada Barão</h1>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Painel de Gestão</p>
                    </div>
                </div>
                <div class="flex gap-4 items-center">
                    <a href="index.php" target="_blank" class="hidden sm:flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-primary transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        Ver Site
                    </a>
                    <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-800">Administrador</p>
                            <p class="text-xs text-green-600 font-medium flex items-center gap-1 justify-end"><span class="w-2 h-2 rounded-full bg-green-500"></span> Online</p>
                        </div>
                        <a href="?logout=1" class="ml-2 bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 p-2 rounded-lg transition-colors" title="Sair do sistema">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Mensagens de feedback -->
        <?php if (isset($_GET['msg'])): ?>
            <?php $msgs = ['excluido' => ['Reserva removida com sucesso.', 'emerald'], 'status' => ['Status da reserva atualizado.', 'emerald'], 'confirmada' => ['Reserva confirmada com sucesso!', 'emerald']]; ?>
            <?php if (isset($msgs[$_GET['msg']])): [$txt, $cor] = $msgs[$_GET['msg']]; ?>
            <div class="bg-<?= $cor ?>-50 border border-<?= $cor ?>-200 text-<?= $cor ?>-800 px-4 py-4 rounded-xl flex flex-wrap items-center gap-3 shadow-sm mb-6">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="font-semibold text-sm"><?= htmlspecialchars($txt) ?></span>
                <?php if ($_GET['msg'] === 'confirmada' && isset($_GET['notificar_id'])): ?>
                    <?php
                    $rid_n = (int)$_GET['notificar_id'];
                    $reserva_n = null;
                    foreach (getReservas() as $r) { if ($r['id'] == $rid_n) { $reserva_n = $r; break; } }
                    if ($reserva_n):
                        $msg_wa = urlencode(
                            "Olá, " . $reserva_n['nome_cliente'] . "! 🎉\n" .
                            "Sua reserva na *Pousada Barão* foi *confirmada*!\n\n" .
                            "🏠 Quarto: " . $reserva_n['quarto_nome'] . "\n" .
                            "📅 Check-in: " . date('d/m/Y', strtotime($reserva_n['data_entrada'])) . "\n" .
                            "📅 Check-out: " . date('d/m/Y', strtotime($reserva_n['data_saida'])) . "\n" .
                            "👥 Hóspedes: " . $reserva_n['quantidade_pessoas'] . "\n\n" .
                            "Check-in a partir das 14h. Qualquer dúvida, estamos à disposição! Até lá! 😊"
                        );
                        $tel_wa = preg_replace('/[^0-9]/', '', $reserva_n['telefone']);
                    ?>
                    <a href="https://wa.me/55<?= $tel_wa ?>?text=<?= $msg_wa ?>" target="_blank"
                       class="ml-auto flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-green-700 transition-colors shrink-0">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Enviar confirmação para <?= htmlspecialchars($reserva_n['nome_cliente']) ?>
                    </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if ($pendentes > 0): ?>
        <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm mb-6">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span class="font-semibold text-sm"><?= $pendentes ?> reserva<?= $pendentes > 1 ? 's' : '' ?> aguardando confirmação.</span>
        </div>
        <?php endif; ?>

        <!-- Cards de estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-[0_2px_10px_rgb(0,0,0,0.02)] flex items-center justify-between hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-shadow">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total de Reservas</p>
                    <h3 class="text-4xl font-extrabold text-slate-900"><?= $total_reservas ?></h3>
                </div>
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-[0_2px_10px_rgb(0,0,0,0.02)] flex items-center justify-between hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-shadow">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Pendentes</p>
                    <h3 class="text-4xl font-extrabold text-amber-600"><?= $pendentes ?></h3>
                </div>
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-[0_2px_10px_rgb(0,0,0,0.02)] flex items-center justify-between hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-shadow">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Check-ins Futuros</p>
                    <h3 class="text-4xl font-extrabold text-slate-900"><?= $checkins_futuros ?></h3>
                </div>
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-[0_2px_10px_rgb(0,0,0,0.02)] flex items-center justify-between hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-shadow">
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Hóspedes Esperados</p>
                    <h3 class="text-4xl font-extrabold text-slate-900"><?= $hospedes_futuros ?></h3>
                </div>
                <div class="w-14 h-14 bg-violet-50 text-violet-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Tabela de Reservas -->
        <div class="bg-white rounded-[2rem] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-200 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 bg-slate-50/30">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900">Reservas Solicitadas</h2>
                    <p class="text-sm text-slate-500 font-medium mt-1">Gerencie e confirme as solicitações de hospedagem.</p>
                </div>
                <form class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <input type="date" name="data" value="<?= htmlspecialchars($filtro_data) ?>"
                               class="pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary focus:border-transparent outline-none text-sm font-semibold text-slate-700 bg-white">
                    </div>
                    <select name="filtro" class="py-2.5 px-3 rounded-xl border border-slate-200 text-sm font-semibold text-slate-700 bg-white outline-none focus:ring-2 focus:ring-primary">
                        <option value="" <?= !$filtro_status ? 'selected' : '' ?>>Todos os Status</option>
                        <option value="pendente"   <?= $filtro_status === 'pendente'   ? 'selected' : '' ?>>Pendentes</option>
                        <option value="confirmada" <?= $filtro_status === 'confirmada' ? 'selected' : '' ?>>Confirmadas</option>
                        <option value="cancelada"  <?= $filtro_status === 'cancelada'  ? 'selected' : '' ?>>Canceladas</option>
                    </select>
                    <button type="submit" class="bg-slate-900 text-white px-5 py-2.5 rounded-xl hover:bg-primary transition-colors font-bold text-sm shadow-sm">Filtrar</button>
                    <?php if ($filtro_data || $filtro_status): ?>
                        <a href="admin.php" class="bg-slate-100 text-slate-600 px-4 py-2.5 rounded-xl hover:bg-slate-200 transition-colors font-bold text-sm">Limpar</a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-widest font-extrabold">
                            <th class="px-8 py-5">Hóspede</th>
                            <th class="px-6 py-5">Quarto</th>
                            <th class="px-6 py-5">Check-in</th>
                            <th class="px-6 py-5">Check-out</th>
                            <th class="px-6 py-5">Qtd.</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-8 py-5 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($reservas_filtradas)): ?>
                            <tr>
                                <td colspan="7" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <svg class="w-16 h-16 mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        <p class="text-lg font-bold text-slate-500">Nenhuma reserva encontrada</p>
                                        <p class="text-sm mt-1">Ajuste os filtros ou aguarde novas solicitações.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($reservas_filtradas as $r):
                                $letra  = strtoupper(substr(trim($r['nome_cliente']), 0, 1));
                                $status = $r['status'] ?? 'pendente';
                                $sc     = $status_config[$status] ?? $status_config['pendente'];
                            ?>
                            <tr class="hover:bg-slate-50/80 transition-colors duration-200">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-primary to-emerald-400 text-white flex items-center justify-center font-bold shadow-md shrink-0">
                                            <?= htmlspecialchars($letra) ?>
                                        </div>
                                        <div>
                                            <p class="font-extrabold text-slate-900 text-sm"><?= htmlspecialchars($r['nome_cliente']) ?></p>
                                            <a href="https://wa.me/55<?= preg_replace('/[^0-9]/', '', $r['telefone']) ?>" target="_blank"
                                               class="text-xs text-slate-500 font-medium hover:text-primary transition-colors flex items-center gap-1 mt-0.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                                <?= htmlspecialchars($r['telefone']) ?>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        <?= htmlspecialchars($r['quarto_nome']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full <?= $r['data_entrada'] >= $hoje ? 'bg-green-500' : 'bg-slate-300' ?>"></span>
                                        <span class="text-sm font-bold text-slate-700"><?= date('d/m/Y', strtotime($r['data_entrada'])) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-700">
                                    <?= date('d/m/Y', strtotime($r['data_saida'])) ?>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-1.5 text-slate-600 font-bold text-sm bg-slate-100 w-fit px-2.5 py-1 rounded-md">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                        <?= $r['quantidade_pessoas'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border <?= $sc['bg'] ?> <?= $sc['text'] ?> <?= $sc['border'] ?>">
                                        <?= $sc['label'] ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <?php if ($status !== 'confirmada'): ?>
                                        <a href="?status=confirmada&id=<?= $r['id'] ?>"
                                           class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:bg-emerald-50 hover:text-emerald-600 transition-all duration-200" title="Confirmar Reserva">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </a>
                                        <?php endif; ?>
                                        <?php if ($status !== 'cancelada'): ?>
                                        <a href="?status=cancelada&id=<?= $r['id'] ?>"
                                           onclick="return confirm('Cancelar esta reserva?')"
                                           class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:bg-orange-50 hover:text-orange-600 transition-all duration-200" title="Cancelar Reserva">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </a>
                                        <?php endif; ?>
                                        <a href="?excluir=<?= $r['id'] ?>"
                                           onclick="return confirm('Excluir permanentemente esta reserva?')"
                                           class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:bg-red-50 hover:text-red-600 transition-all duration-200" title="Excluir Registro">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 text-center text-sm font-semibold text-slate-400">
            &copy; <?= date('Y') ?> Pousada Barão &mdash; Painel Administrativo
        </div>
    </main>

</body>
</html>
