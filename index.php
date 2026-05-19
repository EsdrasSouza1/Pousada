<?php
// O código do banco de dados foi removido conforme solicitado.
// Você pode adicionar a lógica de banco de dados aqui no futuro.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hospedagem confortável, limpa e segura no centro de Araras. A Pousada Barão oferece o melhor custo-benefício com atendimento 24h e Wi-Fi grátis.">
    <title>Pousada Barão - Hospedagem Segura e Confortável em Araras</title>
    <link rel="stylesheet" href="style.css">
    <!-- Adicionando ícones para os diferenciais -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="nav">
        <div class="nav-inner">
            <a href="index.php" class="nav-logo">
                <img src="img/Logo P.png" alt="Logo Pousada Barão">
            </a>
            <div class="nav-links">
                <a href="index.php" style="color:var(--green)">Início</a>
                <a href="infraestrutura.php">Infraestrutura</a>
                <a href="quartos.php">Acomodações</a>
                <a href="contato.php">Contato</a>
                <a href="reserva.php" class="btn-nav">Reservar Agora</a>
            </div>
            <button class="nav-mobile-btn">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <!-- HERO -->
    <header class="hero">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <!-- Headline Clara e Direta -->
            <h1>Hospedagem <span>segura e aconchegante</span> no centro de Araras.</h1>
            <!-- Subtítulo Objetivo -->
            <p>Perfeito para trabalho ou descanso. Desfrute de quartos impecáveis, Wi-Fi rápido, segurança 24h e o melhor custo-benefício da cidade.</p>
            
            <form action="quartos.php" class="search-bar">
                <div class="search-field">
                    <label>Check-in</label>
                    <input type="date" required>
                </div>
                <div class="search-divider"></div>
                <div class="search-field">
                    <label>Check-out</label>
                    <input type="date" required>
                </div>
                <div class="search-divider"></div>
                <div class="search-field">
                    <label>Hóspedes</label>
                    <select>
                        <option>1 Pessoa</option>
                        <option selected>2 Pessoas</option>
                        <option>3+ Pessoas</option>
                    </select>
                </div>
                <button type="submit" class="search-btn">
                    Ver Quartos Disponíveis
                </button>
            </form>
            
            <!-- Indicadores de Confiança (Social Proof Rápido) -->
            <div style="margin-top: 24px; display: flex; align-items: center; justify-content: center; gap: 16px; font-size: 0.85rem; color: rgba(255,255,255,0.8); font-weight: 600;">
                <span><i class="fa-solid fa-check-circle" style="color:var(--orange)"></i> Limpeza 100%</span>
                <span><i class="fa-solid fa-check-circle" style="color:var(--orange)"></i> Recepção 24/7</span>
                <span><i class="fa-solid fa-star" style="color:#FFD700"></i> 4.9 no Google</span>
            </div>
        </div>
    </header>

    <!-- STATUS/FEATURES BAR (Uptime / Segurança) -->
    <section class="stats">
        <div class="stats-inner">
            <div class="stat-item">
                <div class="num">+5.000</div>
                <div class="label">Hóspedes Atendidos</div>
            </div>
            <div class="stat-item">
                <div class="num">24h</div>
                <div class="label">Segurança e Portaria</div>
            </div>
            <div class="stat-item">
                <div class="num">100%</div>
                <div class="label">Satisfação com Limpeza</div>
            </div>
            <div class="stat-item">
                <div class="num">1 min</div>
                <div class="label">Para o Centro (A pé)</div>
            </div>
        </div>
    </section>

    <!-- INFRAESTRUTURA E SEGURANÇA -->
    <section id="infra" class="section bg-gray">
        <div class="section-inner about-grid">
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
                <img src="img/quintal.png" alt="Quintal da Pousada Seguro">
                <div class="about-float" style="padding: 24px;">
                    <div class="big" style="font-size: 2rem;">Zero</div>
                    <div class="small">Taxas Ocultas</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ROOMS SECTION (Nossos "Planos") -->
    <section class="section">
        <div class="section-inner">
            <div class="section-header">
                <span class="section-tag">Nossos Planos de Hospedagem</span>
                <h2 class="section-title">Escolha o nível de conforto ideal</h2>
                <p class="section-sub">Diferentes opções para diferentes necessidades. Todos os planos incluem Wi-Fi, limpeza e recepção 24h.</p>
            </div>

            <div class="rooms-grid">
                <!-- Quarto 1 (O mais vendido / "Hospedagem WordPress") -->
                <a href="quarto-detalhe.php" class="room-card" style="border: 2px solid var(--green);">
                    <div class="room-card-img">
                        <img src="img/quarto-duplo.png" alt="Quarto Duplo">
                        <div class="room-badge" style="background: var(--green); color: #fff;">Mais Popular</div>
                    </div>
                    <div class="room-card-body">
                        <div class="room-card-top">
                            <h3 class="room-name">Suíte Casal Conforto</h3>
                        </div>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 16px;">Para casais ou viagens a dois que precisam de conforto total.</p>
                        
                        <div style="margin-bottom: 24px; flex: 1;">
                            <ul style="list-style: none; padding: 0; font-size: 0.85rem; color: var(--text-main); display: flex; flex-direction: column; gap: 8px;">
                                <li><i class="fa-solid fa-check" style="color: var(--orange); margin-right: 8px;"></i> <b>Espaço:</b> Cama Queen Size</li>
                                <li><i class="fa-solid fa-check" style="color: var(--orange); margin-right: 8px;"></i> <b>Climatização:</b> Ar Condicionado</li>
                                <li><i class="fa-solid fa-check" style="color: var(--orange); margin-right: 8px;"></i> <b>Entretenimento:</b> TV Smart</li>
                                <li><i class="fa-solid fa-check" style="color: var(--orange); margin-right: 8px;"></i> <b>Extras:</b> Frigobar</li>
                            </ul>
                        </div>

                        <div class="room-footer" style="flex-direction: column; align-items: flex-start; gap: 16px;">
                            <div class="room-price">R$ 180<span>/noite</span></div>
                            <button class="btn-nav" style="width: 100%; text-align: center;">Reservar Casal</button>
                        </div>
                    </div>
                </a>

                <!-- Quarto 2 ("Servidor Dedicado / Familia") -->
                <a href="quarto-detalhe.php" class="room-card">
                    <div class="room-card-img">
                        <img src="img/quarto-familia.png" alt="Quarto Família">
                    </div>
                    <div class="room-card-body">
                        <div class="room-card-top">
                            <h3 class="room-name">Quarto Familiar Triplo</h3>
                        </div>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 16px;">Para quem viaja em grupo e precisa de mais espaço e economia.</p>
                        
                        <div style="margin-bottom: 24px; flex: 1;">
                            <ul style="list-style: none; padding: 0; font-size: 0.85rem; color: var(--text-main); display: flex; flex-direction: column; gap: 8px;">
                                <li><i class="fa-solid fa-check" style="color: var(--orange); margin-right: 8px;"></i> <b>Espaço:</b> 3 Camas de Solteiro</li>
                                <li><i class="fa-solid fa-check" style="color: var(--orange); margin-right: 8px;"></i> <b>Climatização:</b> Ventilador de Teto</li>
                                <li><i class="fa-solid fa-check" style="color: var(--orange); margin-right: 8px;"></i> <b>Extras:</b> Frigobar</li>
                                <li><i class="fa-solid fa-check" style="color: var(--orange); margin-right: 8px;"></i> <b>Vista:</b> De frente para o quintal</li>
                            </ul>
                        </div>

                        <div class="room-footer" style="flex-direction: column; align-items: flex-start; gap: 16px;">
                            <div class="room-price">R$ 250<span>/noite</span></div>
                            <button class="btn-nav" style="width: 100%; text-align: center; background: #fff !important; color: var(--orange) !important; border: 1px solid var(--orange);">Reservar Familiar</button>
                        </div>
                    </div>
                </a>

                <!-- Quarto 3 ("Hospedagem Compartilhada / Solteiro Econômico") -->
                <a href="quarto-detalhe.php" class="room-card">
                    <div class="room-card-img">
                        <img src="img/quarto-single.png" alt="Quarto Solteiro">
                    </div>
                    <div class="room-card-body">
                        <div class="room-card-top">
                            <h3 class="room-name">Solteiro Econômico</h3>
                        </div>
                        <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 16px;">O plano de entrada perfeito para quem viaja a trabalho.</p>
                        
                        <div style="margin-bottom: 24px; flex: 1;">
                            <ul style="list-style: none; padding: 0; font-size: 0.85rem; color: var(--text-main); display: flex; flex-direction: column; gap: 8px;">
                                <li><i class="fa-solid fa-check" style="color: var(--orange); margin-right: 8px;"></i> <b>Espaço:</b> 1 Cama de Solteiro</li>
                                <li><i class="fa-solid fa-check" style="color: var(--orange); margin-right: 8px;"></i> <b>Trabalho:</b> Mesa para Notebook</li>
                                <li><i class="fa-solid fa-check" style="color: var(--orange); margin-right: 8px;"></i> <b>Conectividade:</b> Wi-Fi Rápido</li>
                                <li><i class="fa-solid fa-check" style="color: var(--orange); margin-right: 8px;"></i> <b>Climatização:</b> Ventilador</li>
                            </ul>
                        </div>

                        <div class="room-footer" style="flex-direction: column; align-items: flex-start; gap: 16px;">
                            <div class="room-price">R$ 120<span>/noite</span></div>
                            <button class="btn-nav" style="width: 100%; text-align: center; background: #fff !important; color: var(--orange) !important; border: 1px solid var(--orange);">Reservar Solteiro</button>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- PROVAS SOCIAIS -->
    <section class="section bg-gray">
        <div class="section-inner">
            <div class="section-header">
                <span class="section-tag">Provas Sociais</span>
                <h2 class="section-title">Resultados Reais. Hóspedes Felizes.</h2>
                <p class="section-sub">Não confie apenas na nossa palavra. Veja o que as pessoas que já se hospedaram conosco têm a dizer.</p>
            </div>

            <div class="reviews-grid">
                <div class="review-card">
                    <div class="review-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="review-text">"As meninas da recepção são incríveis! A Dona Antônia nos tratou como família. O quarto estava super limpo e a internet não caiu nenhuma vez. Perfeito para home office."</p>
                    <div class="review-author">
                        <div class="review-avatar">M</div>
                        <div>
                            <div class="review-name">Maria Silva</div>
                            <div class="review-date">Há 2 semanas no Google</div>
                        </div>
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="review-text">"Excelente custo-benefício. Fica no centro, do lado da praça. Dava pra fazer tudo a pé. O quintal no fundo com o pé de jabuticaba é de uma paz absurda!"</p>
                    <div class="review-author">
                        <div class="review-avatar">C</div>
                        <div>
                            <div class="review-name">Carlos Oliveira</div>
                            <div class="review-date">Viajou a trabalho</div>
                        </div>
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="review-text">"O suporte é muito rápido! Chamei no WhatsApp para confirmar a reserva e responderam em 2 minutos. Chegando lá, tudo estava exatamente como nas fotos. Zero surpresas."</p>
                    <div class="review-author">
                        <div class="review-avatar">R</div>
                        <div>
                            <div class="review-name">Rafael Santos</div>
                            <div class="review-date">Casal em férias</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ / ATENDIMENTO DECISIVO -->
    <section id="faq" class="section">
        <div class="section-inner" style="max-width: 800px;">
            <div class="section-header" style="margin-bottom: 40px;">
                <span class="section-tag">Base de Conhecimento</span>
                <h2 class="section-title">Perguntas Frequentes</h2>
                <p class="section-sub">Atendimento humano rápido é o nosso diferencial. Mas se tiver dúvidas rápidas, veja abaixo.</p>
            </div>

            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div style="border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 24px;">
                    <h4 style="color: var(--green); margin-bottom: 8px;">Quais são os horários de check-in e check-out?</h4>
                    <p style="font-size: 0.9rem; color: var(--text-muted);">O check-in inicia às 14:00 e o check-out deve ser realizado até as 12:00. Caso precise de horários flexíveis, chame nosso suporte.</p>
                </div>
                <div style="border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 24px;">
                    <h4 style="color: var(--green); margin-bottom: 8px;">Vocês possuem estacionamento no local?</h4>
                    <p style="font-size: 0.9rem; color: var(--text-muted);">Sim! Temos estacionamento seguro e fechado para garantir a proteção do seu veículo durante a estadia.</p>
                </div>
                <div style="border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 24px;">
                    <h4 style="color: var(--green); margin-bottom: 8px;">Como funciona a garantia de reserva?</h4>
                    <p style="font-size: 0.9rem; color: var(--text-muted);">A reserva é simples e sem taxas escondidas. Você pode pagar na chegada ou antecipado via PIX, com total transparência.</p>
                </div>
            </div>

            <div class="text-center mt-8" style="text-align: center; margin-top: 40px;">
                <p style="margin-bottom: 16px; color: var(--text-main); font-weight: 600;">Ainda tem dúvidas? Fale com um atendente real em menos de 5 minutos.</p>
                <a href="https://wa.me/5519996544617" class="btn-nav" style="display:inline-flex; align-items:center; gap:8px; background: var(--green) !important;">
                    <i class="fa-brands fa-whatsapp" style="font-size: 1.2rem;"></i> Atendimento via WhatsApp
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
