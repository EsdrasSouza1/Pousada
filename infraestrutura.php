<?php
// infraestrutura.php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infraestrutura - Pousada Barão</title>
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
                <a href="infraestrutura.php" style="color:var(--green)">Infraestrutura</a>
                <a href="quartos.php">Acomodações</a>
                <a href="contato.php">Contato</a>
                <a href="reserva.php" class="btn-nav">Reservar Agora</a>
            </div>
            <button class="nav-mobile-btn">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <!-- PAGE HERO -->
    <header class="page-hero">
        <div class="breadcrumb">
            <a href="index.php">Início</a> <span>/</span> Infraestrutura
        </div>
        <h1>Nossa Estrutura</h1>
        <p>Conheça tudo o que a Pousada Barão oferece para sua estadia.</p>
    </header>

    <div style="padding-top: 40px; padding-bottom: 80px;">
        <div class="section-inner about-grid" style="background:#fff; padding:40px; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
            <div class="about-text">
                <div class="label">Infraestrutura e Segurança</div>
                <h2>Conforto e controle para uma estadia sem preocupações</h2>
                <p>Nós levamos a sua tranquilidade a sério. Assim como os melhores hotéis garantem excelência, nós garantimos que o seu descanso será impecável, seguro e silencioso.</p>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 32px;">
                    <div style="display: flex; gap: 12px; align-items: flex-start;">
                        <i class="fa-solid fa-shield-halved" style="color: var(--green); font-size: 1.5rem;"></i>
                        <div>
                            <h4 style="color: var(--green); margin-bottom: 4px;">Monitoramento 24h</h4>
                            <p style="font-size: 0.85rem; color: var(--text-muted);">Câmeras de segurança e equipe presente dia e noite.</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px; align-items: flex-start;">
                        <i class="fa-solid fa-wifi" style="color: var(--green); font-size: 1.5rem;"></i>
                        <div>
                            <h4 style="color: var(--green); margin-bottom: 4px;">Wi-Fi de Alta Velocidade</h4>
                            <p style="font-size: 0.85rem; color: var(--text-muted);">Trabalhe ou assista filmes sem interrupções em todos os quartos.</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px; align-items: flex-start;">
                        <i class="fa-solid fa-broom" style="color: var(--green); font-size: 1.5rem;"></i>
                        <div>
                            <h4 style="color: var(--green); margin-bottom: 4px;">Higienização Diária</h4>
                            <p style="font-size: 0.85rem; color: var(--text-muted);">Protocolos rigorosos de limpeza em lençóis, toalhas e ambientes.</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 12px; align-items: flex-start;">
                        <i class="fa-solid fa-leaf" style="color: var(--green); font-size: 1.5rem;"></i>
                        <div>
                            <h4 style="color: var(--green); margin-bottom: 4px;">Ambiente Arborizado</h4>
                            <p style="font-size: 0.85rem; color: var(--text-muted);">Um quintal com pé de jabuticaba isola o barulho da cidade.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about-img-wrap">
                <img src="img/quintal.png" alt="Quintal da Pousada Seguro" style="width: 100%; border-radius: var(--radius-lg);">
                <div class="about-float" style="padding: 24px;">
                    <div class="big" style="font-size: 2rem;">Zero</div>
                    <div class="small">Taxas Ocultas</div>
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

    <script>
        const mobileBtn = document.querySelector('.nav-mobile-btn');
        const navLinks = document.querySelector('.nav-links');
        mobileBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            mobileBtn.classList.toggle('active');
        });
    </script>
</body>
</html>
