<?php
// Espaço reservado para futura integração com banco de dados
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nossas Acomodações - Pousada Barão</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

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
            <a href="index.php">Início</a> <span>/</span> Acomodações
        </div>
        <h1>Escolha seu conforto</h1>
        <p>Quartos aconchegantes no centro de Araras, pensados para o seu descanso.</p>
    </header>

    <!-- FILTERS -->
    <div class="filter-bar">
        <div class="filter-inner">
            <button class="filter-btn active">Todos os Quartos</button>
            <button class="filter-btn">
                <svg viewBox="0 0 24 24" fill="none"><path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke-width="2"/><path d="M12 8V16" stroke-width="2" stroke-linecap="round"/><path d="M8 12H16" stroke-width="2" stroke-linecap="round"/></svg>
                Para Casal
            </button>
            <button class="filter-btn">Para Família</button>
            <button class="filter-btn">Mais Econômicos</button>
            <div style="flex:1"></div>
            <span style="font-size:0.85rem; color:var(--gray-500); font-weight:600">3 Quartos disponíveis</span>
        </div>
    </div>

    <!-- ROOMS LIST -->
    <section class="section" style="padding-top: 40px;">
        <div class="section-inner">
            <div class="rooms-grid">
                <!-- Quarto 1 -->
                <a href="quarto-detalhe.php" class="room-card">
                    <div class="room-card-img">
                        <img src="img/quarto-duplo.png" alt="Quarto Duplo">
                        <div class="room-badge">Recomendado</div>
                        <button class="room-fav"><svg viewBox="0 0 24 24" fill="none"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                    </div>
                    <div class="room-card-body">
                        <div class="room-card-top">
                            <h3 class="room-name">Suíte Casal Conforto</h3>
                            <div class="room-stars"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> 4.9</div>
                        </div>
                        <div class="room-location">Pousada Barão - Térreo</div>
                        <div class="room-amenities">
                            <span class="amenity-pill">Cama Queen</span>
                            <span class="amenity-pill">Ar Condicionado</span>
                            <span class="amenity-pill">Wi-Fi</span>
                            <span class="amenity-pill">TV Smart</span>
                        </div>
                        <p style="font-size: 0.88rem; color: var(--gray-500); margin-bottom: 16px; line-height: 1.5;">O espaço ideal para casais que buscam conforto e praticidade. Equipada com ar condicionado e cama queen para garantir uma excelente noite de sono.</p>
                        <div class="room-footer">
                            <div class="room-price">R$ 180<span>/noite</span></div>
                            <span style="font-size: 0.8rem; font-weight: 700; color: var(--orange);">Até 2 pessoas</span>
                        </div>
                    </div>
                </a>

                <!-- Quarto 2 -->
                <a href="quarto-detalhe.php" class="room-card">
                    <div class="room-card-img">
                        <img src="img/quarto-familia.png" alt="Quarto Família">
                        <button class="room-fav"><svg viewBox="0 0 24 24" fill="none"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                    </div>
                    <div class="room-card-body">
                        <div class="room-card-top">
                            <h3 class="room-name">Quarto Familiar Triplo</h3>
                            <div class="room-stars"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> 4.8</div>
                        </div>
                        <div class="room-location">Pousada Barão - Térreo</div>
                        <div class="room-amenities">
                            <span class="amenity-pill">3 Camas Solteiro</span>
                            <span class="amenity-pill">Ventilador</span>
                            <span class="amenity-pill">Frigobar</span>
                        </div>
                        <p style="font-size: 0.88rem; color: var(--gray-500); margin-bottom: 16px; line-height: 1.5;">Perfeito para grupos ou famílias. Espaçoso e arejado, conta com três camas de solteiro super confortáveis e uma vista para o quintal arborizado.</p>
                        <div class="room-footer">
                            <div class="room-price">R$ 250<span>/noite</span></div>
                            <span style="font-size: 0.8rem; font-weight: 700; color: var(--orange);">Até 3 pessoas</span>
                        </div>
                    </div>
                </a>

                <!-- Quarto 3 -->
                <a href="quarto-detalhe.php" class="room-card">
                    <div class="room-card-img">
                        <img src="img/quarto-single.png" alt="Quarto Solteiro">
                        <button class="room-fav"><svg viewBox="0 0 24 24" fill="none"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                    </div>
                    <div class="room-card-body">
                        <div class="room-card-top">
                            <h3 class="room-name">Quarto Solteiro Econômico</h3>
                            <div class="room-stars"><svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg> 5.0</div>
                        </div>
                        <div class="room-location">Pousada Barão - Térreo</div>
                        <div class="room-amenities">
                            <span class="amenity-pill">1 Cama Solteiro</span>
                            <span class="amenity-pill">Mesa Trabalho</span>
                            <span class="amenity-pill">Wi-Fi Rápido</span>
                        </div>
                        <p style="font-size: 0.88rem; color: var(--gray-500); margin-bottom: 16px; line-height: 1.5;">Ideal para quem viaja a trabalho ou sozinho e busca o melhor custo-benefício. Quarto simples, silencioso, e com uma mesa pronta para seu notebook.</p>
                        <div class="room-footer">
                            <div class="room-price">R$ 120<span>/noite</span></div>
                            <span style="font-size: 0.8rem; font-weight: 700; color: var(--orange);">1 pessoa</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

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

</body>
</html>
