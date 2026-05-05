<?php
require_once 'db.php';

// Buscar quartos para o formulário e listagem
$quartos = getQuartos();

$mensagem = '';
$sucesso = false;

// Processar formulário de reserva
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reservar') {
    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $quarto_id = (int)($_POST['quarto_id'] ?? 0);
    $data_entrada = $_POST['data_entrada'] ?? '';
    $data_saida = $_POST['data_saida'] ?? '';
    $quantidade_pessoas = (int)($_POST['quantidade_pessoas'] ?? 0);

    if ($nome && $telefone && $quarto_id && $data_entrada && $data_saida && $quantidade_pessoas) {
        
        // Validar data (saída deve ser após entrada)
        if ($data_saida <= $data_entrada) {
            $mensagem = "A data de saída deve ser posterior à data de entrada.";
        } else {
            // Validar capacidade
            $quarto = getQuarto($quarto_id);

            if ($quarto && $quantidade_pessoas > $quarto['capacidade']) {
                $mensagem = "A quantidade de pessoas excede a capacidade do quarto escolhido (Máx: {$quarto['capacidade']}).";
            } else {
                // Verificar disponibilidade
                $conflito = checkDisponibilidade($quarto_id, $data_entrada, $data_saida);

                if ($conflito) {
                    $mensagem = "Este quarto já está reservado para as datas selecionadas. Por favor, escolha outra data ou quarto.";
                } else {
                    // Inserir reserva
                    addReserva($nome, $telefone, $quarto_id, $data_entrada, $data_saida, $quantidade_pessoas);
                    $mensagem = "Reserva realizada com sucesso!";
                    $sucesso = true;
                }
            }
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pousada Barão - Conforto e Natureza em Araras</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#2F4F4F',
                        'brand-light-green': '#8FBC8F',
                        'brand-orange': '#D2691E',
                        'brand-bg': '#FDFBF7'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FDFBF7; }
        .hero-pattern {
            background-image: linear-gradient(rgba(47, 79, 79, 0.7), rgba(47, 79, 79, 0.7)), url('https://images.unsplash.com/photo-1587061949409-02df41d5e562?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
        }
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="text-gray-800 antialiased">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <?php if(file_exists('img/Logo P.png')): ?>
                        <img class="h-12 w-auto" src="img/Logo P.png" alt="Pousada Barão Logo">
                    <?php else: ?>
                        <div class="h-10 w-10 bg-brand-green rounded-full flex items-center justify-center text-white font-bold text-xl">B</div>
                    <?php endif; ?>
                    <span class="font-bold text-2xl text-brand-green tracking-tight">Pousada Barão</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-600 hover:text-brand-green font-medium transition">Início</a>
                    <a href="#sobre" class="text-gray-600 hover:text-brand-green font-medium transition">Sobre</a>
                    <a href="#quartos" class="text-gray-600 hover:text-brand-green font-medium transition">Quartos</a>
                    <a href="#reservas" class="bg-brand-orange text-white px-5 py-2 rounded-full font-medium hover:bg-orange-700 transition shadow-md hover:shadow-lg">Reservar Agora</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-pattern h-screen flex items-center justify-center pt-20">
        <div class="text-center px-4 max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 tracking-tight drop-shadow-lg leading-tight">
                Seu Refúgio de Paz <br/><span class="text-brand-light-green">no Coração de Araras</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-100 mb-10 drop-shadow max-w-2xl mx-auto font-light">
                Conforto, simplicidade e o calor humano que faz você se sentir em casa. Uma experiência autêntica e acolhedora.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#reservas" class="bg-brand-orange hover:bg-orange-700 text-white px-8 py-4 rounded-full text-lg font-bold transition duration-300 transform hover:-translate-y-1 shadow-xl">
                    Faça sua Reserva
                </a>
                <a href="#quartos" class="bg-white/20 hover:bg-white/30 backdrop-blur text-white px-8 py-4 rounded-full text-lg font-bold transition duration-300 transform hover:-translate-y-1 border border-white/50">
                    Conheça os Quartos
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="sobre" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-sm font-bold text-brand-orange uppercase tracking-wider mb-2">Sobre Nós</h2>
                    <h3 class="text-4xl font-bold text-brand-green mb-6 leading-tight">Simplicidade que Aconchega</h3>
                    <p class="text-gray-600 text-lg mb-6 leading-relaxed">
                        Localizada estrategicamente no centro de Araras, a Pousada Barão é uma alternativa de hospedagem que prioriza o acolhimento. Nosso principal atrativo reside na atmosfera familiar e no tratamento personalizado, proporcionando uma sensação de estar em casa.
                    </p>
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        Desfrute do nosso quintal arborizado, um verdadeiro oásis urbano com visitas frequentes de pássaros e araras, ideal para momentos de relaxamento.
                    </p>
                    <div class="flex gap-4">
                        <div class="bg-brand-bg p-4 rounded-2xl border border-gray-100 shadow-sm flex-1">
                            <h4 class="font-bold text-brand-green text-xl mb-1">Localização</h4>
                            <p class="text-sm text-gray-500">Centro de Araras, perto de tudo.</p>
                        </div>
                        <div class="bg-brand-bg p-4 rounded-2xl border border-gray-100 shadow-sm flex-1">
                            <h4 class="font-bold text-brand-green text-xl mb-1">Atendimento</h4>
                            <p class="text-sm text-gray-500">Equipe adorável e prestativa.</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Pousada Relaxante" class="rounded-3xl shadow-2xl object-cover h-[500px] w-full">
                    <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-xl border border-gray-50">
                        <p class="text-3xl font-bold text-brand-orange mb-1">100%</p>
                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Acolhimento</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section id="quartos" class="py-24 bg-brand-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-sm font-bold text-brand-orange uppercase tracking-wider mb-2">Nossas Acomodações</h2>
                <h3 class="text-4xl font-bold text-brand-green">Conforto para toda família</h3>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto text-lg">Quartos limpos, organizados e pensados para o seu descanso.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($quartos as $quarto): ?>
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                    <div class="h-56 overflow-hidden relative">
                        <?php 
                        // Imagens mockadas
                        $imgUrl = $quarto['capacidade'] == 10 
                            ? 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' 
                            : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80';
                        ?>
                        <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($quarto['nome']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-sm font-bold text-brand-green shadow">
                            Até <?= $quarto['capacidade'] ?> Pessoas
                        </div>
                    </div>
                    <div class="p-8">
                        <h4 class="text-2xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($quarto['nome']) ?></h4>
                        <p class="text-gray-500 mb-6 line-clamp-2">Acomodações simples e aconchegantes. Equipado com o essencial para uma ótima estadia no coração de Araras.</p>
                        <a href="#reservas" onclick="document.getElementById('quarto_id').value='<?= $quarto['id'] ?>';" class="block w-full text-center bg-brand-green/10 text-brand-green hover:bg-brand-green hover:text-white px-4 py-3 rounded-xl font-semibold transition duration-300">
                            Selecionar Quarto
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Reservation Section -->
    <section id="reservas" class="py-24 bg-white relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <div class="bg-brand-green p-10 text-center">
                    <h3 class="text-3xl font-bold text-white mb-2">Faça sua Reserva</h3>
                    <p class="text-brand-light-green">Garanta seus dias de descanso com facilidade.</p>
                </div>
                
                <div class="p-10">
                    <?php if ($mensagem): ?>
                        <div class="p-4 mb-8 rounded-xl <?= $sucesso ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200' ?>">
                            <p class="font-medium text-center"><?= htmlspecialchars($mensagem) ?></p>
                        </div>
                    <?php endif; ?>

                    <form action="#reservas" method="POST" class="space-y-6">
                        <input type="hidden" name="action" value="reservar">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nome Completo</label>
                                <input type="text" name="nome" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand-green focus:border-transparent transition outline-none" placeholder="Seu nome">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Telefone / WhatsApp</label>
                                <input type="text" name="telefone" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand-green focus:border-transparent transition outline-none" placeholder="(00) 00000-0000">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quarto</label>
                            <select name="quarto_id" id="quarto_id" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand-green focus:border-transparent transition outline-none bg-white">
                                <option value="">Selecione um quarto</option>
                                <?php foreach ($quartos as $quarto): ?>
                                    <option value="<?= $quarto['id'] ?>"><?= htmlspecialchars($quarto['nome']) ?> (Capacidade: <?= $quarto['capacidade'] ?> pessoas)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Data de Entrada</label>
                                <input type="date" name="data_entrada" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand-green focus:border-transparent transition outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Data de Saída</label>
                                <input type="date" name="data_saida" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand-green focus:border-transparent transition outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Qtd. de Pessoas</label>
                                <input type="number" name="quantidade_pessoas" min="1" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand-green focus:border-transparent transition outline-none" placeholder="Ex: 2">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-brand-orange hover:bg-orange-700 text-white font-bold py-4 px-8 rounded-xl transition duration-300 shadow-md hover:shadow-xl text-lg mt-4">
                            Confirmar Reserva
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-green pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-10 w-10 bg-white rounded-full flex items-center justify-center text-brand-green font-bold text-xl">B</div>
                        <span class="font-bold text-2xl text-white">Pousada Barão</span>
                    </div>
                    <p class="text-brand-light-green mb-6">Seu refúgio de paz, conforto e simplicidade no coração de Araras.</p>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6 text-lg">Contato</h4>
                    <ul class="space-y-4 text-brand-light-green">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Rua Nunes Machado, Centro, Araras - SP
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            (00) 00000-0000
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6 text-lg">Links Rápidos</h4>
                    <ul class="space-y-3 text-brand-light-green">
                        <li><a href="#home" class="hover:text-white transition">Início</a></li>
                        <li><a href="#sobre" class="hover:text-white transition">Sobre a Pousada</a></li>
                        <li><a href="#quartos" class="hover:text-white transition">Nossos Quartos</a></li>
                        <li><a href="admin.php" class="hover:text-white transition">Área Restrita (Admin)</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-brand-light-green/30 pt-8 text-center text-sm text-brand-light-green">
                <p>&copy; <?= date('Y') ?> Pousada Barão. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/5500000000000" target="_blank" class="fixed bottom-6 right-6 bg-[#25D366] text-white p-4 rounded-full shadow-2xl hover:scale-110 transition transform z-50 flex items-center justify-center">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>

</body>
</html>
