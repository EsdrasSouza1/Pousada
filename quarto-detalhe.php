<?php
// Espaço reservado para futura integração com banco de dados
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suíte Casal Conforto - Pousada Barão</title>
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
                <a href="reserva.php" class="btn-nav">Reservar Agora</a>
            </div>
        </div>
    </nav>

    <div class="section" style="padding-top: 120px;">
        <div class="section-inner">
            <div class="breadcrumb" style="justify-content: flex-start; margin-bottom: 24px;">
                <a href="index.php" style="color:var(--gray-500)">Início</a> <span style="color:var(--gray-400)">/</span> 
                <a href="quartos.php" style="color:var(--gray-500)">Acomodações</a> <span style="color:var(--gray-400)">/</span> 
                <span style="color:var(--green); font-weight: 600;">Suíte Casal Conforto</span>
            </div>

            <div class="detail-grid">
                <!-- Lado Esquerdo: Info -->
                <div>
                    <div class="detail-info">
                        <h1>Suíte Casal Conforto</h1>
                        <div class="detail-meta">
                            <span style="display:flex; align-items:center; gap:4px; font-weight:700;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="var(--orange)"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                4.90 (12 Avaliações)
                            </span>
                            <span style="color:var(--gray-400)">•</span>
                            <span style="color:var(--gray-600); text-decoration: underline;">Araras, São Paulo, Brasil</span>
                        </div>
                    </div>

                    <div class="detail-photos">
                        <div class="main-photo">
                            <img src="img/quarto-duplo.png" alt="Foto Principal Quarto">
                        </div>
                        <div>
                            <img src="img/quintal.png" alt="Quintal">
                        </div>
                        <div>
                            <img src="img/araras.png" alt="Vista da Cidade">
                        </div>
                    </div>

                    <div style="margin-top: 40px; padding-bottom: 32px; border-bottom: 1px solid var(--gray-200);">
                        <h2 style="font-size: 1.4rem; color: var(--green); margin-bottom: 8px;">Quarto em Pousada Boutique</h2>
                        <p style="color: var(--gray-500);">Acomoda 2 hóspedes · 1 quarto · 1 cama queen · 1 banheiro privativo</p>
                    </div>

                    <div style="margin-top: 32px; padding-bottom: 32px; border-bottom: 1px solid var(--gray-200);">
                        <h3 style="font-size: 1.2rem; color: var(--gray-800); margin-bottom: 20px;">O que esse lugar oferece</h3>
                        <div class="detail-amenities" style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div class="detail-amenity">
                                <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                                Wi-Fi rápido e gratuito
                            </div>
                            <div class="detail-amenity">
                                <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                Smart TV
                            </div>
                            <div class="detail-amenity">
                                <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                Ar Condicionado Split
                            </div>
                            <div class="detail-amenity">
                                <svg fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                Frigobar
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 32px;">
                        <h3 style="font-size: 1.2rem; color: var(--gray-800); margin-bottom: 16px;">Sobre este espaço</h3>
                        <p style="color: var(--gray-600); line-height: 1.7;">O espaço ideal para casais que buscam conforto e praticidade no centro de Araras. A Suíte Casal Conforto foi pensada para proporcionar noites relaxantes após um dia inteiro de passeio ou trabalho.</p>
                        <p style="color: var(--gray-600); line-height: 1.7; margin-top: 12px;">Desfrute do nosso ambiente familiar, extremamente limpo e organizado. Você também terá acesso liberado ao nosso belo quintal arborizado, perfeito para tomar um café sentindo a brisa e observando os pássaros da região.</p>
                    </div>
                </div>

                <!-- Lado Direito: Widget Reserva -->
                <div>
                    <div class="booking-card">
                        <div class="booking-card-price">R$ 180 <span>/ noite</span></div>
                        
                        <form action="reserva.php" class="form-group gap-4" style="margin-top: 24px;">
                            <div style="border: 1px solid var(--gray-300); border-radius: 12px; overflow: hidden;">
                                <div style="display:flex; border-bottom: 1px solid var(--gray-300);">
                                    <div style="flex:1; padding:12px; border-right: 1px solid var(--gray-300);">
                                        <label class="form-label" style="font-size: 0.65rem;">Check-in</label>
                                        <input type="date" required style="width:100%; border:none; outline:none; font-family:'Inter'; font-size: 0.9rem; color: var(--gray-800);">
                                    </div>
                                    <div style="flex:1; padding:12px;">
                                        <label class="form-label" style="font-size: 0.65rem;">Check-out</label>
                                        <input type="date" required style="width:100%; border:none; outline:none; font-family:'Inter'; font-size: 0.9rem; color: var(--gray-800);">
                                    </div>
                                </div>
                                <div style="padding:12px;">
                                    <label class="form-label" style="font-size: 0.65rem;">Hóspedes</label>
                                    <select style="width:100%; border:none; outline:none; font-family:'Inter'; font-size: 0.9rem; color: var(--gray-800);">
                                        <option>1 Hóspede</option>
                                        <option selected>2 Hóspedes</option>
                                    </select>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn-reserve" style="margin-top: 16px;">Reservar Quarto</button>
                            <p style="text-align:center; font-size:0.8rem; color:var(--gray-500); margin-top:12px;">Você não será cobrado agora</p>
                        </form>

                        <div class="price-summary">
                            <div class="price-row">
                                <span>R$ 180 x 2 noites</span>
                                <span>R$ 360</span>
                            </div>
                            <div class="price-row">
                                <span>Taxa de serviço</span>
                                <span>R$ 0</span>
                            </div>
                            <div class="price-row total">
                                <span>Total</span>
                                <span>R$ 360</span>
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
