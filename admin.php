<?php
session_start();
require_once 'db.php';

$senha_correta = 'admin123'; // Senha hardcoded para simplicidade

// Processar login
if (isset($_POST['login'])) {
    if ($_POST['senha'] === $senha_correta) {
        $_SESSION['admin_logado'] = true;
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

// Se não estiver logado, mostrar formulário de login
if (!isset($_SESSION['admin_logado'])) {
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administração Pousada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { background-color: #FDFBF7; }</style>
</head>
<body class="flex items-center justify-center h-screen">
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-md border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-[#2F4F4F]">Painel Administrativo</h1>
            <p class="text-gray-500 mt-2">Pousada Barão</p>
        </div>
        
        <?php if (isset($erro_login)): ?>
            <div class="bg-red-50 text-red-700 p-3 rounded mb-4 text-center"><?= htmlspecialchars($erro_login) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Senha de Acesso</label>
                <input type="password" name="senha" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-[#2F4F4F] outline-none">
                <p class="text-xs text-gray-400 mt-2">Dica: a senha é admin123</p>
            </div>
            <button type="submit" name="login" class="w-full bg-[#D2691E] text-white font-bold py-3 rounded-xl hover:bg-orange-700 transition">Entrar</button>
        </form>
        <div class="mt-4 text-center">
            <a href="index.php" class="text-sm text-gray-500 hover:text-[#2F4F4F]">Voltar para o site</a>
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
$reservas = getReservas($filtro_data);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Pousada Barão</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand': '#2F4F4F',
                        'brand-light': '#8FBC8F',
                        'brand-accent': '#D2691E'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">

    <nav class="bg-brand text-white p-4 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="font-bold text-xl">Gestão de Reservas - Pousada Barão</div>
            <div class="flex gap-4 items-center">
                <a href="index.php" class="text-brand-light hover:text-white transition">Ver Site</a>
                <a href="?logout=1" class="bg-white text-brand px-4 py-2 rounded-lg font-bold text-sm hover:bg-gray-100 transition">Sair</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 mt-6">
        
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'excluido'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">Reserva excluída com sucesso!</span>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="text-2xl font-bold text-gray-800">Todas as Reservas</h2>
                
                <form class="flex gap-2 w-full md:w-auto">
                    <input type="date" name="data" value="<?= htmlspecialchars($filtro_data) ?>" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-brand outline-none flex-1">
                    <button type="submit" class="bg-brand text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition font-medium">Filtrar</button>
                    <?php if ($filtro_data): ?>
                        <a href="admin.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition font-medium flex items-center">Limpar</a>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                            <th class="p-4 font-medium border-b">Cliente</th>
                            <th class="p-4 font-medium border-b">Contato</th>
                            <th class="p-4 font-medium border-b">Quarto</th>
                            <th class="p-4 font-medium border-b">Entrada</th>
                            <th class="p-4 font-medium border-b">Saída</th>
                            <th class="p-4 font-medium border-b">Hóspedes</th>
                            <th class="p-4 font-medium border-b">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (count($reservas) === 0): ?>
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500">Nenhuma reserva encontrada.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($reservas as $reserva): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 font-medium text-gray-800"><?= htmlspecialchars($reserva['nome_cliente']) ?></td>
                                    <td class="p-4 text-gray-600"><?= htmlspecialchars($reserva['telefone']) ?></td>
                                    <td class="p-4 text-gray-600">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <?= htmlspecialchars($reserva['quarto_nome']) ?>
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-600"><?= date('d/m/Y', strtotime($reserva['data_entrada'])) ?></td>
                                    <td class="p-4 text-gray-600"><?= date('d/m/Y', strtotime($reserva['data_saida'])) ?></td>
                                    <td class="p-4 text-gray-600"><?= $reserva['quantidade_pessoas'] ?></td>
                                    <td class="p-4">
                                        <a href="?excluir=<?= $reserva['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir esta reserva?')" class="text-red-500 hover:text-red-700 font-medium transition flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Excluir
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
