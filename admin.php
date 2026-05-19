<?php
session_start();
require_once 'db.php';

$senha_correta = 'admin123'; // Senha hardcoded para simplicidade

// Processar login
if (isset($_POST['login'])) {
    if ($_POST['senha'] === $senha_correta) {
        $_SESSION['admin_logado'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $erro_login = "Senha incorreta.";
    }
}

// Processar logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Se não estiver logado, mostrar formulário de login premium
if (!isset($_SESSION['admin_logado'])) {
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administração Pousada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { primary: '#2F4F4F', accent: '#C96A2A' }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 font-sans flex items-center justify-center min-h-screen relative overflow-hidden">
    <!-- Efeitos de Fundo -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-accent/20 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-[420px] px-4">
        <div class="bg-white/70 backdrop-blur-xl p-10 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white">
            <div class="text-center mb-10">
                <div class="mx-auto mb-5 flex justify-center">
                    <img src="img/Logo P.png" alt="Logo Pousada Barão" class="h-20 w-auto">
                </div>
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Gestão Barão</h1>
                <p class="text-slate-500 mt-2 font-medium">Acesse seu painel administrativo</p>
            </div>
            
            <?php if (isset($erro_login)): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex items-center animate-pulse">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                        <input type="password" name="senha" placeholder="••••••••" required class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 bg-white/50 focus:bg-white focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all duration-200 shadow-sm font-medium">
                    </div>
                </div>
                <button type="submit" name="login" class="w-full bg-slate-900 text-white font-bold py-3.5 rounded-xl hover:bg-primary hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 flex items-center justify-center gap-2">
                    Entrar no Painel
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
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

// Processar Exclusão
if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    deleteReserva($id);
    header("Location: admin.php?msg=excluido");
    exit;
}

// Filtro de data
$filtro_data = $_GET['data'] ?? '';

// Buscar reservas
$reservas_filtradas = getReservas($filtro_data);
$todas_reservas = getReservas(); // Para as estatísticas

// Calcular estatísticas
$total_reservas = count($todas_reservas);
$hoje = date('Y-m-d');
$checkins_futuros = 0;
$hospedes_futuros = 0;

foreach ($todas_reservas as $r) {
    if ($r['data_entrada'] >= $hoje) {
        $checkins_futuros++;
        $hospedes_futuros += $r['quantidade_pessoas'];
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Pousada Barão</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { primary: '#2F4F4F', accent: '#C96A2A' }
                }
            }
        }
    </script>
    <style>
        /* Custom scrollbar para a tabela */
        ::-webkit-scrollbar { height: 8px; width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50/50 font-sans text-slate-800 min-h-screen">

    <!-- Top Navbar Premium -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-3">
                    <img src="img/Logo P.png" alt="Logo Pousada Barão" class="h-10 w-auto">
                    <div>
                        <h1 class="font-extrabold text-xl leading-tight text-slate-900">Pousada Barão</h1>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Painel de Gestão</p>
                    </div>
                </div>
                <div class="flex gap-4 items-center">
                    <a href="index.php" target="_blank" class="hidden sm:flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-primary transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Ver Site
                    </a>
                    <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-slate-800">Administrador</p>
                            <p class="text-xs text-green-600 font-medium flex items-center gap-1 justify-end"><span class="w-2 h-2 rounded-full bg-green-500"></span> Online</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden">
                            <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        </div>
                        <a href="?logout=1" class="ml-2 bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 p-2 rounded-lg transition-colors" title="Sair do sistema">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'excluido'): ?>
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm mb-6 animate-[bounce_1s_ease-in-out_1]">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="font-semibold text-sm">Reserva removida com sucesso.</span>
            </div>
        <?php endif; ?>

        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
             <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-[0_2px_10px_rgb(0,0,0,0.02)] flex items-center justify-between hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-shadow">
                <div>
                   <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Total de Solicitações</p>
                   <h3 class="text-4xl font-extrabold text-slate-900"><?= $total_reservas ?></h3>
                </div>
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
             </div>
             
             <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-[0_2px_10px_rgb(0,0,0,0.02)] flex items-center justify-between hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-shadow">
                <div>
                   <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Check-ins Futuros</p>
                   <h3 class="text-4xl font-extrabold text-slate-900"><?= $checkins_futuros ?></h3>
                </div>
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
             </div>

             <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-[0_2px_10px_rgb(0,0,0,0.02)] flex items-center justify-between hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-shadow">
                <div>
                   <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-1">Hóspedes Esperados</p>
                   <h3 class="text-4xl font-extrabold text-slate-900"><?= $hospedes_futuros ?></h3>
                </div>
                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
             </div>
        </div>

        <!-- Main Table Card -->
        <div class="bg-white rounded-[2rem] shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-200 flex flex-col md:flex-row justify-between items-center gap-6 bg-slate-50/30">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900">Reservas Solicitadas</h2>
                    <p class="text-sm text-slate-500 font-medium mt-1">Gerencie quem tem interesse em se hospedar.</p>
                </div>
                
                <form class="flex w-full md:w-auto items-center gap-3">
                    <div class="relative flex-1 md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="date" name="data" value="<?= htmlspecialchars($filtro_data) ?>" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary focus:border-transparent outline-none text-sm font-semibold text-slate-700 bg-white">
                    </div>
                    <button type="submit" class="bg-slate-900 text-white px-5 py-2.5 rounded-xl hover:bg-primary transition-colors font-bold text-sm shadow-sm">
                        Filtrar
                    </button>
                    <?php if ($filtro_data): ?>
                        <a href="admin.php" class="bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl hover:bg-slate-200 transition-colors font-bold text-sm">Limpar</a>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-200 text-slate-500 text-xs uppercase tracking-widest font-extrabold">
                            <th class="px-8 py-5">Hóspede Solicitante</th>
                            <th class="px-6 py-5">Quarto Desejado</th>
                            <th class="px-6 py-5">Check-in</th>
                            <th class="px-6 py-5">Check-out</th>
                            <th class="px-6 py-5">Qtd.</th>
                            <th class="px-8 py-5 text-right">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (count($reservas_filtradas) === 0): ?>
                            <tr>
                                <td colspan="6" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <svg class="w-16 h-16 mb-4 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        <p class="text-lg font-bold text-slate-500">Nenhuma reserva encontrada</p>
                                        <p class="text-sm mt-1">Tente remover os filtros ou aguarde novas solicitações.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($reservas_filtradas as $reserva): 
                                $letra = strtoupper(substr(trim($reserva['nome_cliente']), 0, 1));
                                $status = ($reserva['data_entrada'] >= $hoje) ? 'Futura' : 'Passada';
                                $status_color = ($status == 'Futura') ? 'bg-primary/10 text-primary border-primary/20' : 'bg-slate-100 text-slate-500 border-slate-200';
                            ?>
                                <tr class="hover:bg-slate-50/80 transition-colors duration-200 group">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-primary to-emerald-400 text-white flex items-center justify-center font-bold shadow-md shadow-primary/20 shrink-0">
                                                <?= $letra ?>
                                            </div>
                                            <div>
                                                <p class="font-extrabold text-slate-900 text-sm"><?= htmlspecialchars($reserva['nome_cliente']) ?></p>
                                                <p class="text-xs text-slate-500 font-medium mt-0.5 flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                    <a href="https://wa.me/55<?= preg_replace('/[^0-9]/', '', $reserva['telefone']) ?>" target="_blank" class="hover:text-primary transition-colors"><?= htmlspecialchars($reserva['telefone']) ?></a>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200/50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                            <?= htmlspecialchars($reserva['quarto_nome']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full <?= ($status=='Futura') ? 'bg-green-500' : 'bg-slate-300' ?>"></span>
                                            <span class="text-sm font-bold text-slate-700"><?= date('d/m/Y', strtotime($reserva['data_entrada'])) ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-700">
                                        <?= date('d/m/Y', strtotime($reserva['data_saida'])) ?>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-1.5 text-slate-600 font-bold text-sm bg-slate-100 w-fit px-2.5 py-1 rounded-md">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            <?= $reserva['quantidade_pessoas'] ?>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <a href="?excluir=<?= $reserva['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta solicitação?')" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:bg-red-50 hover:text-red-600 transition-all duration-200" title="Excluir Registro">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-8 text-center text-sm font-semibold text-slate-400">
            &copy; <?= date('Y') ?> Pousada Barão. Painel Administrativo.
        </div>
    </main>

</body>
</html>
