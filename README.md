# Projeto Integrador - Pousada Barão

## Sobre o Projeto
O **Pousada Barão** é um sistema web desenvolvido como Projeto Integrador (PI) acadêmico. O projeto consiste em uma plataforma completa para a divulgação de uma pousada e o gerenciamento de reservas, projetada para ser ágil, responsiva e de fácil manutenção.

O sistema foi concebido para resolver o problema de gestão de hospitalidade de pequenos negócios, oferecendo uma vitrine elegante para os clientes (Front-end) e um painel de controle funcional para os administradores (Back-end), eliminando a necessidade de anotações em papel ou planilhas desorganizadas.

## Objetivos
- **Para os Hóspedes:** Proporcionar uma interface moderna, intuitiva e amigável onde eles possam conhecer a infraestrutura, visualizar fotos e detalhes dos quartos, tirar dúvidas comuns e solicitar reservas facilmente (inclusive com integração ágil para o WhatsApp).
- **Para a Administração:** Fornecer um painel administrativo seguro e simples onde é possível visualizar, filtrar e gerenciar as solicitações de reserva feitas pelo site.

## Tecnologias Utilizadas
O projeto adota uma arquitetura clássica e leve, sem a dependência de pesados frameworks front-end ou drivers complexos de banco de dados, o que garante estabilidade e facilidade na hora de subir (deploy) em qualquer serviço de hospedagem padrão.

- **Front-end:** HTML5, CSS3 (Vanilla com uso intensivo de variáveis CSS/Custom Properties para tematização) e JavaScript básico para interatividade no menu móvel.
- **Back-end:** PHP moderno, atuando no roteamento, processamento de formulários, validação e lógica de negócios.
- **Banco de Dados (SQL):** MySQL relacional acessado via PDO. O `db.php` centraliza todo o acesso a dados e cria automaticamente as tabelas (`quartos`, `reservas`, `reservas_log`), a chave estrangeira e os **triggers** de auditoria na primeira execução. O esquema completo também está documentado em `schema.sql`. A conexão é configurada por variáveis de ambiente (`MYSQLHOST`, `MYSQLUSER`, etc.).
- **Ícones e Tipografia:** FontAwesome para a iconografia e Google Fonts (Plus Jakarta Sans para clareza e Playfair Display para elegância).

## Estrutura de Páginas e Navegação
O site possui 5 páginas navegáveis principais para os usuários (cumprindo requisitos técnicos), além da área administrativa:

1. **Início (`index.php`):** A página principal de atração. Apresenta um banner chamativo (Hero Section), resumo da infraestrutura, prova social e atalhos de navegação.
2. **Infraestrutura (`infraestrutura.php`):** Página dedicada a detalhar os diferenciais da pousada, como segurança 24h, Wi-Fi de alta velocidade e protocolos de limpeza rigorosos.
3. **Acomodações (`quartos.php`):** Um catálogo visual com todos os quartos disponíveis, seus diferenciais, capacidade e preços.
4. **Detalhes do Quarto (`quarto-detalhe.php`):** Uma visão aprofundada de uma acomodação específica, com galeria de fotos descritiva, lista completa de comodidades e widget de agendamento.
5. **Contato (`contato.php`):** FAQ (Perguntas Frequentes) para retirar dúvidas de forma rápida e chamadas diretas para atendimento humanizado via WhatsApp.
6. **Reservar Agora (`reserva.php`):** Formulário de captação de dados do cliente e datas desejadas, que são processados e diretamente salvos no banco de dados.

### Painel Administrativo (`admin.php`)
Área restrita por senha de acesso único, que permite aos administradores do estabelecimento:
- Listar todas as reservas e solicitações de quartos feitas pelo site.
- Filtrar reservas por data de check-in/check-out e quartos.
- Ver detalhes do hóspede, telefone (com link que abre direto a conversa no WhatsApp do cliente) e informações da estadia.
- Excluir, liberar e gerenciar o histórico de reservas.

## Como Executar o Projeto Localmente
Por ser baseado em arquivos e não necessitar de um SGBD externo complexo, rodar o projeto é extremamente simples, ideal para bancas de avaliação.

### Requisitos:
- PHP 7.4 ou superior com a extensão `pdo_mysql` (XAMPP, WAMP, Laragon, ou PHP nativo).
- Um servidor MySQL (local ou na nuvem).

### Passos Rápidos:
1. Clone ou extraia a pasta do projeto para o seu computador.
2. Crie um banco MySQL vazio (ex.: `pousada`).
3. Defina as variáveis de conexão e inicie o servidor embutido do PHP:
   ```bash
   export MYSQLHOST=127.0.0.1 MYSQLPORT=3306 MYSQLUSER=root MYSQLPASSWORD= MYSQLDATABASE=pousada
   php -S localhost:8000
   ```
   (No PowerShell use `$env:MYSQLHOST="127.0.0.1"`, etc.)
4. Acesse `http://localhost:8000` no seu navegador.

*Nota Técnica: as tabelas, os triggers e os quartos iniciais são criados automaticamente pelo `db.php` na primeira execução. Para deploy gratuito na nuvem (Railway + MySQL), veja `DEPLOY.md`.*

## Design e UI/UX
O design e a interface foram construídos para transmitir uma sensação "Premium Boutique" aliada a segurança e paz. As diretrizes visuais são:
- **Verde Escuro (`#2F4F4F`):** Traz seriedade, segurança, natureza e sofisticação.
- **Laranja Terroso (`#C96A2A`):** Funciona como cor de destaque (Call to Actions) para atrair os cliques, gerando aquecimento e energia no layout.
- **Off-White / Cinza Claro (`#FCFBF9`):** Fundo principal das páginas, dá um ar de limpeza muito superior ao branco puro e garante maior conforto na leitura das informações textuais.

## Autoria e Propósito
Desenvolvido como software acadêmico para compor avaliação na disciplina de Projeto Integrador (PI). Todo o código foi escrito e estruturado de forma a aplicar, na prática, os conceitos de lógica de programação, desenvolvimento web responsivo (mobile-first), persistência de dados e experiência do usuário (UX) estudados ao longo da graduação.
