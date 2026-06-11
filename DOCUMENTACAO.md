# DOCUMENTAÇÃO TÉCNICA — SISTEMA DE GESTÃO DE RESERVAS

---

> **Instruções de formatação ABNT para impressão:**  
> Margem superior e esquerda: 3 cm | Margem inferior e direita: 2 cm  
> Fonte: Times New Roman 12 pt ou Arial 12 pt | Espaçamento: 1,5 entre linhas  
> Parágrafos: 1,25 cm de recuo | Títulos de seção: negrito, numerados, maiúsculas  

---

<br>

<div align="center">

**FACULDADE / INSTITUIÇÃO DE ENSINO**  
CURSO DE TECNOLOGIA EM ANÁLISE E DESENVOLVIMENTO DE SISTEMAS  

<br><br>

**ESDRAS DE SOUZA**  

<br><br><br>

# POUSADA BARÃO: DESENVOLVIMENTO DE UM SISTEMA WEB DE GESTÃO E RESERVAS ONLINE PARA ESTABELECIMENTOS DE HOSPEDAGEM DE PEQUENO PORTE

<br><br><br>

Araras – SP  
2026

</div>

---

<br>

<div align="center">

**ESDRAS DE SOUZA**  

<br><br><br>

# POUSADA BARÃO: DESENVOLVIMENTO DE UM SISTEMA WEB DE GESTÃO E RESERVAS ONLINE PARA ESTABELECIMENTOS DE HOSPEDAGEM DE PEQUENO PORTE

<br><br>

Trabalho de Projeto Integrador apresentado como requisito parcial para conclusão do curso de Tecnologia em Análise e Desenvolvimento de Sistemas.

Orientador: Prof. [Nome do Orientador]

<br><br><br>

Araras – SP  
2026

</div>

---

## FOLHA DE APROVAÇÃO

<br>

**ESDRAS DE SOUZA**

**POUSADA BARÃO: DESENVOLVIMENTO DE UM SISTEMA WEB DE GESTÃO E RESERVAS ONLINE PARA ESTABELECIMENTOS DE HOSPEDAGEM DE PEQUENO PORTE**

<br>

Trabalho de Projeto Integrador apresentado e aprovado em: _____ / _____ / 2026.

<br>

**Banca Examinadora:**

---
Prof. ___________________________________  
Instituição de Ensino  
Orientador

---
Prof. ___________________________________  
Instituição de Ensino  
Avaliador

---

<br>

---

## DEDICATÓRIA

<br>

*Dedico este trabalho a todos que acreditam no poder da tecnologia em transformar pequenos negócios e tornar a hospitalidade mais acessível e eficiente.*

---

## AGRADECIMENTOS

<br>

Agradeço ao corpo docente do curso de Análise e Desenvolvimento de Sistemas pela orientação ao longo desta jornada acadêmica. À Pousada Barão, pela abertura para servir de estudo de caso real. Aos colegas de classe, pela troca de conhecimentos e apoio mútuo.

---

## EPÍGRAFE

<br>

*"Qualquer tecnologia suficientemente avançada é indistinguível da mágica."*  
— Arthur C. Clarke

---

## RESUMO

<br>

O presente trabalho descreve o desenvolvimento de um sistema web completo para gestão e reservas online da Pousada Barão, estabelecimento de hospedagem de pequeno porte localizado no centro de Araras, São Paulo. O sistema foi construído com PHP puro, HTML5, CSS3, JavaScript e banco de dados em formato JSON, dispensando o uso de frameworks ou servidores de banco de dados externos. O projeto abrange um portal público voltado ao hóspede, com páginas de apresentação dos quartos, formulário de reserva com validação de disponibilidade e um painel administrativo protegido por senha, com funcionalidades de confirmação, cancelamento e exclusão de reservas. O trabalho demonstra a viabilidade de uma solução funcional, de baixo custo operacional e fácil implantação para microempresas do setor hoteleiro.

**Palavras-chave:** Sistema de Reservas; Hospedagem Web; PHP; Gestão Hoteleira; Desenvolvimento Web; JSON.

---

## ABSTRACT

<br>

This paper describes the development of a complete web system for online reservation management of Pousada Barão, a small lodging establishment located in the center of Araras, São Paulo. The system was built using plain PHP, HTML5, CSS3, JavaScript, and a JSON-based data layer, eliminating the need for external frameworks or database servers. The project includes a public guest-facing portal with room presentation pages, a reservation form with availability validation, and a password-protected administrative dashboard with reservation confirmation, cancellation, and deletion features. The work demonstrates the feasibility of a functional, low-cost, easy-to-deploy solution for micro-enterprises in the hospitality sector.

**Keywords:** Reservation System; Web Hosting; PHP; Hotel Management; Web Development; JSON.

---

## LISTA DE FIGURAS

<br>

| N.º | Descrição | Página |
|-----|-----------|--------|
| Figura 1 | Arquitetura geral do sistema | 18 |
| Figura 2 | Diagrama de fluxo do processo de reserva | 20 |
| Figura 3 | Estrutura de dados JSON — entidade Quartos | 22 |
| Figura 4 | Estrutura de dados JSON — entidade Reservas | 23 |
| Figura 5 | Página inicial (Hero Section) | 26 |
| Figura 6 | Página de listagem de acomodações | 27 |
| Figura 7 | Página de detalhe do quarto com widget de reserva | 28 |
| Figura 8 | Formulário de reserva com validação | 29 |
| Figura 9 | Painel administrativo — tabela de reservas com status | 30 |
| Figura 10 | Tela de login do painel administrativo | 31 |
| Figura 11 | Fluxograma de validação de disponibilidade | 33 |
| Figura 12 | Layout responsivo em dispositivo móvel | 35 |

---

## LISTA DE TABELAS

<br>

| N.º | Descrição | Página |
|-----|-----------|--------|
| Tabela 1 | Tecnologias e ferramentas utilizadas | 17 |
| Tabela 2 | Funcionalidades do sistema — requisitos funcionais | 21 |
| Tabela 3 | Requisitos não funcionais | 22 |
| Tabela 4 | Tipos de acomodação e valores | 25 |
| Tabela 5 | Campos da entidade Reserva | 23 |
| Tabela 6 | Status possíveis de uma reserva | 33 |

---

## LISTA DE ABREVIATURAS E SIGLAS

<br>

| Sigla | Significado |
|-------|-------------|
| ABNT  | Associação Brasileira de Normas Técnicas |
| API   | Application Programming Interface |
| CSS   | Cascading Style Sheets |
| CRUD  | Create, Read, Update, Delete |
| HTML  | HyperText Markup Language |
| HTTP  | HyperText Transfer Protocol |
| IDE   | Integrated Development Environment |
| JSON  | JavaScript Object Notation |
| MVC   | Model-View-Controller |
| PHP   | Hypertext Preprocessor |
| PI    | Projeto Integrador |
| RNF   | Requisito Não Funcional |
| RF    | Requisito Funcional |
| SQL   | Structured Query Language |
| TI    | Tecnologia da Informação |
| UI    | User Interface |
| UX    | User Experience |
| URL   | Uniform Resource Locator |
| XAMPP | Cross-platform Apache MySQL PHP Perl |

---

## SUMÁRIO

<br>

1. INTRODUÇÃO ..........................................................................15
   1.1 Contextualização do Problema .............................................15
   1.2 Justificativa ........................................................................16
   1.3 Objetivos ..............................................................................16
      1.3.1 Objetivo Geral ...............................................................16
      1.3.2 Objetivos Específicos ....................................................17
   1.4 Estrutura do Trabalho ..........................................................17

2. REFERENCIAL TEÓRICO .......................................................18
   2.1 Sistemas de Informação na Hotelaria ..................................18
   2.2 Desenvolvimento Web com PHP ...........................................19
   2.3 Banco de Dados JSON como Alternativa Leve .....................20
   2.4 Usabilidade e Experiência do Usuário ..................................21
   2.5 Segurança em Aplicações Web ............................................22

3. METODOLOGIA .......................................................................23
   3.1 Tipo de Pesquisa ..................................................................23
   3.2 Ferramentas e Tecnologias ..................................................23
   3.3 Levantamento de Requisitos ................................................24
      3.3.1 Requisitos Funcionais ...................................................24
      3.3.2 Requisitos Não Funcionais ............................................25
   3.4 Modelagem de Dados ...........................................................25

4. DESENVOLVIMENTO ...............................................................26
   4.1 Arquitetura do Sistema .......................................................26
   4.2 Estrutura de Arquivos .........................................................27
   4.3 Banco de Dados (db.php e database.json) ..........................28
   4.4 Portal Público .....................................................................30
      4.4.1 Página Inicial (index.php) .............................................30
      4.4.2 Listagem de Acomodações (quartos.php) ......................31
      4.4.3 Detalhe do Quarto (quarto-detalhe.php) .......................32
      4.4.4 Formulário de Reserva (reserva.php) ............................33
      4.4.5 Infraestrutura (infraestrutura.php) ................................35
      4.4.6 Contato e FAQ (contato.php) ........................................35
   4.5 Painel Administrativo (admin.php) ......................................36
   4.6 Design e Responsividade (style.css) ...................................38
   4.7 Identidade Visual .................................................................39

5. RESULTADOS E DISCUSSÃO .................................................40
   5.1 Funcionalidades Implementadas .........................................40
   5.2 Testes Realizados ................................................................41
   5.3 Limitações Identificadas .....................................................42

6. CONCLUSÃO ............................................................................43
   6.1 Considerações Finais ...........................................................43
   6.2 Trabalhos Futuros ...............................................................43

REFERÊNCIAS ..............................................................................45

APÊNDICE A — Código-Fonte: db.php .........................................47
APÊNDICE B — Código-Fonte: reserva.php .................................52
APÊNDICE C — Estrutura do database.json ................................57

---

## 1 INTRODUÇÃO

### 1.1 Contextualização do Problema

O setor de hospedagem de pequeno porte no Brasil, composto por pousadas, albergues e pensões familiares, representa uma fatia significativa da indústria turística nacional. Segundo dados do Ministério do Turismo, o país conta com mais de 33 mil meios de hospedagem registrados, dos quais grande parte são empreendimentos de micro e pequeno porte que ainda operam seus processos de reserva de forma manual — por telefone, mensagem de WhatsApp ou anotações em cadernos físicos.

A Pousada Barão, estabelecimento familiar localizado na Rua Nunes Machado, no centro histórico de Araras, interior de São Paulo, enquadra-se neste perfil. Com capacidade para atender até 3 quartos simultaneamente e oferecendo atendimento personalizado há vários anos, o estabelecimento enfrentava dificuldades recorrentes: falta de controle formal sobre reservas, ausência de canal digital de agendamento e impossibilidade de verificar disponibilidade em tempo real.

Este cenário criava conflitos de agenda, perda de clientes em potencial que preferem canais digitais e sobrecarga operacional da gestão.

### 1.2 Justificativa

A digitalização de processos em pequenas empresas é reconhecida como um fator crítico de competitividade e sobrevivência no mercado atual. Um sistema web de gestão de reservas, por mais simples que seja, tem o potencial de:

- **Reduzir erros operacionais**, eliminando conflitos de datas e duplas reservas;
- **Ampliar o alcance comercial**, permitindo que clientes realizem solicitações a qualquer hora do dia;
- **Melhorar a percepção de profissionalismo**, transmitindo confiança e modernidade ao potencial hóspede;
- **Facilitar a gestão administrativa**, centralizando informações em um único painel digital.

Do ponto de vista acadêmico, o projeto justifica-se por integrar conhecimentos multidisciplinares de programação back-end, front-end, banco de dados, design de interface e experiência do usuário, consolidando as competências desenvolvidas ao longo do curso de Tecnologia em Análise e Desenvolvimento de Sistemas.

### 1.3 Objetivos

#### 1.3.1 Objetivo Geral

Desenvolver um sistema web completo para gestão e recebimento de reservas online para a Pousada Barão, proporcionando ao estabelecimento uma presença digital profissional e um painel de administração funcional.

#### 1.3.2 Objetivos Específicos

- Criar um portal público responsivo com apresentação das acomodações e seus diferenciais;
- Implementar formulário de reserva com validação de datas e verificação de disponibilidade;
- Desenvolver painel administrativo protegido por autenticação, com funcionalidades de listagem, filtragem, confirmação, cancelamento e exclusão de reservas;
- Utilizar banco de dados em formato JSON para garantir portabilidade e facilidade de implantação;
- Aplicar boas práticas de usabilidade, acessibilidade e design responsivo;
- Integrar links diretos com o WhatsApp para facilitar a comunicação entre hóspede e estabelecimento.

### 1.4 Estrutura do Trabalho

O presente documento está organizado em seis seções principais. A **Seção 1** apresenta o contexto, a justificativa e os objetivos do projeto. A **Seção 2** expõe o referencial teórico que fundamenta as decisões tecnológicas adotadas. A **Seção 3** descreve a metodologia utilizada, incluindo o levantamento de requisitos e a modelagem de dados. A **Seção 4** detalha o desenvolvimento de cada módulo do sistema. A **Seção 5** discute os resultados obtidos e as limitações identificadas. Por fim, a **Seção 6** apresenta as conclusões e indica caminhos para trabalhos futuros.

---

## 2 REFERENCIAL TEÓRICO

### 2.1 Sistemas de Informação na Hotelaria

Sistemas de Informação (SI) são conjuntos organizados de recursos — humanos, materiais, tecnológicos e financeiros — destinados a coletar, processar, armazenar e distribuir informações para suporte à tomada de decisão em organizações (LAUDON; LAUDON, 2021).

No contexto hoteleiro, os sistemas de informação assumem papel central na operação diária dos estabelecimentos. Os chamados Property Management Systems (PMS) são softwares especializados que integram reservas, check-in, check-out, faturamento e relatórios gerenciais em uma única plataforma (BUHALIS; LAW, 2008).

Contudo, soluções como PMS comerciais apresentam custos elevados de licenciamento e implantação, frequentemente incompatíveis com a realidade de microempresas. Neste contexto, sistemas web customizados surgem como alternativa viável, permitindo que os empreendimentos desenvolvam ferramentas adaptadas à sua escala operacional e orçamento disponível.

### 2.2 Desenvolvimento Web com PHP

PHP (*Hypertext Preprocessor*) é uma linguagem de script de código aberto, especialmente voltada para o desenvolvimento web do lado servidor (server-side). Originalmente criada por Rasmus Lerdorf em 1994, tornou-se uma das linguagens mais utilizadas mundialmente para construção de aplicações web dinâmicas (PHP GROUP, 2024).

Entre as características que justificam a escolha do PHP para este projeto, destacam-se:

- **Amplitude de hospedagem**: a grande maioria dos servidores de hospedagem compartilhada suporta PHP nativamente, sem configurações adicionais;
- **Maturidade e documentação**: a linguagem possui documentação extensa, comunidade ativa e vasta disponibilidade de materiais de aprendizagem;
- **Facilidade de integração**: PHP integra-se nativamente com arquivos do sistema operacional, o que viabiliza o uso de JSON como mecanismo de persistência de dados;
- **Custo zero**: PHP é distribuído sob licença livre, sem custos de licenciamento.

O sistema da Pousada Barão foi desenvolvido em PHP puro (sem uso de frameworks como Laravel ou Symfony), privilegiando a simplicidade, a legibilidade do código e a facilidade de manutenção por desenvolvedores com nível básico a intermediário.

### 2.3 Banco de Dados JSON como Alternativa Leve

JSON (*JavaScript Object Notation*) é um formato leve de intercâmbio de dados, legível por humanos e de fácil processamento por máquinas. Baseado em um subconjunto da linguagem JavaScript, tornou-se o formato padrão de comunicação em APIs REST e, mais recentemente, tem sido utilizado como mecanismo de persistência de dados em aplicações de escala reduzida (ECMA INTERNATIONAL, 2017).

A escolha de JSON como banco de dados para este projeto baseia-se nos seguintes argumentos:

1. **Portabilidade total**: o banco de dados é um único arquivo (`database.json`), que pode ser copiado, versionado e migrado sem ferramentas adicionais;
2. **Ausência de dependências externas**: não é necessário instalar ou configurar servidores de banco de dados como MySQL, PostgreSQL ou SQLite;
3. **Adequação ao volume de dados**: para um estabelecimento com poucos quartos e dezenas de reservas por mês, o desempenho de leitura e escrita em arquivo JSON é plenamente suficiente;
4. **Familiaridade**: a estrutura de arrays e objetos em JSON é diretamente compatível com as estruturas nativas de arrays do PHP.

A limitação principal desta abordagem — ausência de controle de concorrência em escritas simultâneas — não representa risco significativo dado o baixo volume de acessos esperado para o sistema.

### 2.4 Usabilidade e Experiência do Usuário

Jakob Nielsen (1994) estabeleceu dez heurísticas fundamentais de usabilidade que continuam sendo referência no design de interfaces digitais. Entre elas, destacam-se para este projeto:

- **Visibilidade do estado do sistema**: o sistema deve sempre informar ao usuário o que está acontecendo, com feedback adequado e em tempo razoável;
- **Correspondência entre o sistema e o mundo real**: a linguagem, as convenções e os conceitos utilizados devem ser familiares ao usuário;
- **Prevenção de erros**: melhor do que informar erros é evitar que eles ocorram;
- **Consistência e padrões**: os usuários não devem ter que se questionar se palavras, situações ou ações diferentes significam a mesma coisa.

Estas heurísticas guiaram decisões como a exibição de mensagens de erro claras no formulário de reserva, a confirmação antes de exclusões no painel administrativo e a padronização visual em todas as páginas do portal.

### 2.5 Segurança em Aplicações Web

A segurança em aplicações web é um tema crítico, especialmente quando há processamento de dados de usuários. O OWASP (*Open Web Application Security Project*) mantém uma lista das dez vulnerabilidades mais comuns em aplicações web, conhecida como OWASP Top 10 (OWASP, 2021).

Para o presente projeto, foram adotadas as seguintes medidas de segurança:

- **Sanitização de dados**: todos os dados recebidos via formulário são tratados com `htmlspecialchars()` antes de armazenamento e exibição, prevenindo ataques de Cross-Site Scripting (XSS);
- **Tipagem explícita**: campos numéricos são convertidos com cast `(int)` antes do uso, evitando injeção de tipos inesperados;
- **Autenticação por sessão**: o painel administrativo utiliza o mecanismo nativo de sessões do PHP para controle de acesso;
- **Controle de redirecionamento**: após cada operação no painel, o sistema redireciona via `header('Location:')` para evitar resubmissão de formulários (padrão POST/Redirect/GET).

---

## 3 METODOLOGIA

### 3.1 Tipo de Pesquisa

O presente trabalho caracteriza-se como uma **pesquisa aplicada** de natureza **qualitativa e exploratória**, com abordagem de **estudo de caso** (GIL, 2017). O objeto de estudo é a Pousada Barão, e o desenvolvimento do sistema configura a produção técnica resultante da pesquisa.

A metodologia de desenvolvimento adotada foi **incremental e iterativa**, sem vínculo formal com um framework específico de gerenciamento de projetos. As funcionalidades foram implementadas em ordem de prioridade, do núcleo funcional (banco de dados e formulário de reserva) para os módulos auxiliares (painel administrativo, páginas informativas).

### 3.2 Ferramentas e Tecnologias

**Tabela 1 — Tecnologias e ferramentas utilizadas**

| Componente | Tecnologia/Ferramenta | Versão | Papel no Sistema |
|------------|----------------------|--------|------------------|
| Back-end | PHP | 8.x | Lógica de negócio, acesso a dados |
| Front-end | HTML5 | — | Estrutura das páginas |
| Estilização | CSS3 (custom) | — | Layout e identidade visual |
| Admin UI | Tailwind CSS (CDN) | 3.x | Estilização do painel administrativo |
| Interatividade | JavaScript (vanilla) | ES6+ | Validações e cálculos dinâmicos |
| Banco de Dados | JSON (flat-file) | — | Persistência dos dados |
| Ícones | Font Awesome | 6.4.0 | Ícones do portal público |
| Tipografia | Google Fonts | — | Plus Jakarta Sans; Playfair Display |
| Servidor local | PHP built-in server | — | Desenvolvimento e testes |
| Versionamento | Git | — | Controle de versão do código |

### 3.3 Levantamento de Requisitos

O levantamento de requisitos foi realizado por meio de entrevista informal com a gestora do estabelecimento e observação do fluxo de trabalho existente. Os requisitos foram classificados em funcionais (RF) e não funcionais (RNF).

#### 3.3.1 Requisitos Funcionais

**Tabela 2 — Requisitos Funcionais**

| Código | Descrição | Prioridade |
|--------|-----------|------------|
| RF-01 | O sistema deve exibir uma página inicial com apresentação do estabelecimento | Alta |
| RF-02 | O sistema deve listar todos os quartos disponíveis com fotos, preços e amenidades | Alta |
| RF-03 | O sistema deve exibir uma página de detalhe para cada quarto | Alta |
| RF-04 | O sistema deve disponibilizar formulário de solicitação de reserva | Alta |
| RF-05 | O sistema deve validar datas de entrada e saída no formulário de reserva | Alta |
| RF-06 | O sistema deve verificar a disponibilidade do quarto para o período solicitado | Alta |
| RF-07 | O sistema deve armazenar os dados da reserva em banco de dados | Alta |
| RF-08 | O sistema deve exibir confirmação ao hóspede após envio da reserva | Alta |
| RF-09 | O painel administrativo deve exigir autenticação por senha | Alta |
| RF-10 | O painel deve listar todas as reservas com dados do hóspede | Alta |
| RF-11 | O painel deve permitir filtrar reservas por data e status | Média |
| RF-12 | O painel deve permitir confirmar uma reserva | Alta |
| RF-13 | O painel deve permitir cancelar uma reserva | Alta |
| RF-14 | O painel deve permitir excluir uma reserva permanentemente | Média |
| RF-15 | O sistema deve exibir o total de noites e valor estimado no formulário | Média |
| RF-16 | O sistema deve pré-selecionar o quarto ao acessar o formulário via link de detalhe | Média |
| RF-17 | O sistema deve integrar links de contato via WhatsApp | Média |
| RF-18 | O sistema deve exibir FAQ com perguntas frequentes | Baixa |

#### 3.3.2 Requisitos Não Funcionais

**Tabela 3 — Requisitos Não Funcionais**

| Código | Descrição | Categoria |
|--------|-----------|-----------|
| RNF-01 | O sistema deve ser responsivo e funcional em dispositivos móveis | Usabilidade |
| RNF-02 | As páginas devem carregar em menos de 3 segundos em conexões 4G | Desempenho |
| RNF-03 | O código deve ser mantível sem necessidade de framework externo | Manutenibilidade |
| RNF-04 | O sistema deve funcionar em qualquer servidor com PHP 7.4+ | Portabilidade |
| RNF-05 | Dados de entrada devem ser sanitizados antes do armazenamento | Segurança |
| RNF-06 | O painel administrativo deve ser acessível apenas com autenticação | Segurança |
| RNF-07 | O banco de dados não deve depender de servidor externo | Portabilidade |
| RNF-08 | A interface deve seguir padrões de acessibilidade (atributos aria-label) | Acessibilidade |

### 3.4 Modelagem de Dados

O banco de dados, implementado em formato JSON, é composto por três entidades principais:

**Entidade QUARTOS** — armazena as informações estáticas de cada acomodação:

```json
{
  "id": 1,
  "nome": "Suíte Casal Conforto",
  "tipo": "casal",
  "descricao": "Descrição curta...",
  "descricao_longa": "Descrição completa...",
  "preco": 180,
  "capacidade": 2,
  "imagem": "img/quarto-duplo.png",
  "avaliacao": 4.9,
  "total_avaliacoes": 12,
  "amenidades": ["Wi-Fi rápido e gratuito", "Ar Condicionado Split", ...],
  "badge": "Mais Popular"
}
```

**Entidade RESERVAS** — registra cada solicitação de reserva:

```json
{
  "id": 1,
  "nome_cliente": "João da Silva",
  "telefone": "(19) 99999-9999",
  "quarto_id": 1,
  "data_entrada": "2026-07-10",
  "data_saida": "2026-07-13",
  "quantidade_pessoas": 2,
  "status": "pendente",
  "data_criacao": "2026-06-07 14:30:00"
}
```

**Tabela 5 — Campos da entidade Reserva**

| Campo | Tipo | Descrição |
|-------|------|-----------|
| id | inteiro | Identificador único, autoincremental |
| nome_cliente | string | Nome completo do hóspede |
| telefone | string | WhatsApp ou telefone de contato |
| quarto_id | inteiro | Chave estrangeira referenciando o quarto |
| data_entrada | string (YYYY-MM-DD) | Data de check-in |
| data_saida | string (YYYY-MM-DD) | Data de check-out |
| quantidade_pessoas | inteiro | Número de hóspedes |
| status | enum | pendente \| confirmada \| cancelada |
| data_criacao | string (YYYY-MM-DD HH:MM:SS) | Timestamp de criação do registro |

**Tabela 6 — Status possíveis de uma reserva**

| Status | Significado | Ações disponíveis no admin |
|--------|-------------|---------------------------|
| pendente | Aguardando análise do administrador | Confirmar / Cancelar / Excluir |
| confirmada | Reserva aceita pelo estabelecimento | Cancelar / Excluir |
| cancelada | Reserva cancelada | Excluir |

---

## 4 DESENVOLVIMENTO

### 4.1 Arquitetura do Sistema

O sistema segue uma arquitetura monolítica simples, sem separação formal de camadas MVC, adequada à escala do projeto e ao nível de complexidade pretendido. A estrutura pode ser descrita em três camadas lógicas:

```
┌─────────────────────────────────────────┐
│          CAMADA DE APRESENTAÇÃO         │
│  HTML5 + CSS3 + JavaScript (front-end)  │
│  index.php, quartos.php, reserva.php,   │
│  quarto-detalhe.php, admin.php, etc.    │
└────────────────────┬────────────────────┘
                     │ require_once
┌────────────────────▼────────────────────┐
│           CAMADA DE NEGÓCIO             │
│          db.php (funções PHP)           │
│  getQuartos(), addReserva(),            │
│  checkDisponibilidade(), etc.           │
└────────────────────┬────────────────────┘
                     │ read/write
┌────────────────────▼────────────────────┐
│           CAMADA DE DADOS               │
│         database.json (JSON)            │
│  { quartos: [...], reservas: [...] }    │
└─────────────────────────────────────────┘
```

**Figura 1 — Arquitetura geral do sistema**

### 4.2 Estrutura de Arquivos

```
Pousada/
│
├── index.php             # Página inicial (home)
├── quartos.php           # Listagem de acomodações
├── quarto-detalhe.php    # Detalhe de quarto (dinâmico via ?id=X)
├── reserva.php           # Formulário de solicitação de reserva
├── infraestrutura.php    # Página de infraestrutura
├── contato.php           # Página de contato e FAQ
├── admin.php             # Painel administrativo
│
├── db.php                # Camada de dados (funções CRUD)
├── database.json         # Banco de dados (gerado automaticamente)
│
├── style.css             # Folha de estilos global do portal
│
└── img/
    ├── hero.png                  # Imagem de fundo do herói
    ├── araras.png                # Foto da cidade
    ├── quarto-duplo.png          # Foto da Suíte Casal
    ├── quarto-familia.png        # Foto do Quarto Familiar
    ├── quarto-single.png         # Foto do Quarto Solteiro
    ├── quintal.png               # Foto do quintal
    ├── logo fundo removido.png   # Logomarca principal
    └── Logo P.png                # Ícone reduzido
```

### 4.3 Banco de Dados (db.php e database.json)

O arquivo `db.php` centraliza toda a lógica de acesso e manipulação de dados. Ao ser incluído por qualquer página via `require_once 'db.php'`, ele executa a inicialização do banco — criando o arquivo `database.json` caso não exista, ou atualizando a estrutura dos quartos caso a versão do banco seja inferior à versão atual do sistema (campo `_version`).

As funções disponibilizadas são:

| Função | Retorno | Descrição |
|--------|---------|-----------|
| `lerBanco()` | array | Lê e decodifica o arquivo JSON |
| `salvarBanco($dados)` | void | Codifica e grava os dados no arquivo |
| `getQuartos()` | array | Retorna todos os quartos |
| `getQuarto($id)` | array\|null | Retorna um quarto pelo ID |
| `addReserva(...)` | bool | Cria uma nova reserva |
| `checkDisponibilidade($id, $entrada, $saida)` | bool | Verifica conflito de datas |
| `getReservas($filtro_data)` | array | Lista reservas com filtro opcional por data |
| `deleteReserva($id)` | bool | Remove uma reserva permanentemente |
| `updateStatusReserva($id, $status)` | bool | Atualiza o status de uma reserva |

**Fluxo de `checkDisponibilidade()`:**

```
Para cada reserva do quarto X:
  Se status != 'cancelada' E
     data_entrada_nova < data_saida_existente E
     data_saida_nova > data_entrada_existente:
       → CONFLITO DETECTADO (retorna true)
Se nenhum conflito: retorna false
```

**Figura 11 — Fluxograma de validação de disponibilidade**

### 4.4 Portal Público

#### 4.4.1 Página Inicial (index.php)

A página inicial serve como vitrine do estabelecimento e primeiro ponto de contato com o potencial hóspede. Sua estrutura é composta pelas seguintes seções:

1. **Hero Section**: imagem de fundo com efeito de zoom lento (animação CSS `@keyframes slowZoom`), headline de impacto, subtítulo descritivo e formulário de busca rápida com campos de data de check-in, check-out e número de hóspedes. O formulário redireciona o usuário diretamente para `reserva.php` com os parâmetros pré-preenchidos via método GET;
2. **Barra de Estatísticas**: exibe quatro indicadores de credibilidade da pousada — +5.000 hóspedes atendidos, portaria 24h, 100% satisfação com limpeza e localização a 1 minuto do centro;
3. **Seção de Infraestrutura**: grade com quatro diferenciais (monitoramento, Wi-Fi, higienização, quintal arborizado) ao lado de imagem do quintal com selo "Zero Taxas Ocultas";
4. **Seção de Quartos**: três cards com as acomodações disponíveis, linkando individualmente para `quarto-detalhe.php?id=X`;
5. **Provas Sociais**: três avaliações fictícias de hóspedes com sistema de cinco estrelas;
6. **FAQ**: três perguntas frequentes com respostas;
7. **Footer**: rodapé com logo, navegação, informações de contato e links de políticas.

**Figura 5 — Página inicial (Hero Section)**

#### 4.4.2 Listagem de Acomodações (quartos.php)

A página de acomodações carrega dinamicamente os quartos do banco de dados via `getQuartos()`. Oferece filtro por tipo de quarto através de parâmetro GET (`?tipo=casal`, `?tipo=familia`, `?tipo=solteiro`), renderizando somente os quartos correspondentes ao filtro selecionado. Cada card exibe: imagem, nome, avaliação, localização, pills de amenidades, descrição curta, preço por noite e capacidade. Ao clicar em um card, o usuário é direcionado para a página de detalhe do quarto com o ID correto.

**Figura 6 — Página de listagem de acomodações**

#### 4.4.3 Detalhe do Quarto (quarto-detalhe.php)

Recebe o parâmetro `id` via GET e carrega os dados do quarto correspondente com `getQuarto($id)`. Caso o ID não exista, redireciona para `quartos.php`. A página exibe:

- **Galeria de imagens**: foto principal do quarto + duas fotos complementares (quintal e vista da cidade);
- **Informações detalhadas**: nome, avaliação, descrição longa, lista de amenidades com ícones;
- **Widget de reserva lateral**: formulário com campos de check-in, check-out e número de hóspedes, limitando a capacidade máxima ao valor definido no banco de dados. Ao alterar as datas, JavaScript calcula e exibe dinamicamente o número de noites e o valor total estimado;
- **Navegação entre quartos**: botões que permitem navegar para outros quartos sem retornar à listagem.

**Figura 7 — Página de detalhe do quarto com widget de reserva**

#### 4.4.4 Formulário de Reserva (reserva.php)

Esta é a página central de captação de solicitações. Aceita parâmetros via GET (provenientes do widget de detalhe do quarto) para pré-preencher os campos de quarto, datas e número de pessoas. O processamento ocorre via POST e inclui as seguintes validações:

**Validações de servidor (PHP):**

1. Campos obrigatórios: nome, telefone, quarto, data de entrada, data de saída;
2. Data de entrada não pode ser anterior ao dia atual;
3. Data de saída deve ser estritamente posterior à data de entrada;
4. Quantidade de pessoas não pode exceder a capacidade do quarto;
5. Verificação de disponibilidade via `checkDisponibilidade()`.

**Validações de cliente (JavaScript):**

- Atualização do atributo `min` do campo checkout ao alterar o checkin;
- Cálculo dinâmico e exibição do resumo de preço (noites × preço/noite);
- Atualização do campo `max` de pessoas conforme o quarto selecionado.

Após processamento bem-sucedido, exibe mensagem de confirmação com dois botões de ação: retornar à home ou iniciar conversa direta no WhatsApp.

**Figura 8 — Formulário de reserva com validação**

#### 4.4.5 Infraestrutura (infraestrutura.php)

Página informativa que destaca os quatro pilares de infraestrutura da pousada: monitoramento 24h, Wi-Fi de alta velocidade, higienização diária e ambiente arborizado. Apresenta imagem do quintal ao lado do conteúdo com selo visual de destaque.

#### 4.4.6 Contato e FAQ (contato.php)

Centraliza as perguntas frequentes e disponibiliza acesso direto ao WhatsApp do estabelecimento para atendimento humanizado. As três perguntas abordam: horários de check-in e check-out, disponibilidade de estacionamento e funcionamento da garantia de reserva.

### 4.5 Painel Administrativo (admin.php)

O painel administrativo é protegido por sessão PHP. Ao acessar `admin.php` sem sessão ativa, o sistema exibe uma tela de login com logotipo, campo de senha e efeitos visuais modernos (glassmorphism). A senha é verificada contra o valor definido na variável `$senha_correta`. Após autenticação, inicia-se uma sessão PHP que persiste enquanto o browser permanecer aberto.

**Funcionalidades do painel:**

1. **Dashboard de estatísticas**: quatro cards exibindo o total de reservas, quantidade de reservas pendentes (com alerta visual), check-ins futuros e hóspedes esperados;
2. **Alerta de pendências**: se houver reservas com status "pendente", um aviso amarelo é exibido no topo da página informando a quantidade;
3. **Tabela de reservas**: lista todas as reservas com colunas para hóspede (nome + link WhatsApp), quarto, check-in, check-out, quantidade de pessoas, status e ações;
4. **Filtros**: a tabela pode ser filtrada por data de check-in e/ou por status (todos, pendentes, confirmadas, canceladas);
5. **Gestão de status**: cada linha possui botões de ação contextuais — confirmar reserva (ícone de check verde), cancelar reserva (ícone de X laranja) e excluir permanentemente (ícone de lixeira vermelha). A exclusão exige confirmação em diálogo nativo do browser. O sistema atualiza o status via `updateStatusReserva()` e redireciona com mensagem de feedback.

**Figura 9 — Painel administrativo — tabela de reservas com status**

**Figura 10 — Tela de login do painel administrativo**

### 4.6 Design e Responsividade (style.css)

O arquivo `style.css` concentra mais de 600 linhas de estilos escritos manualmente, sem depender de frameworks CSS para o portal público. A abordagem utiliza variáveis CSS (custom properties) para definir a paleta de cores, sombras e curvaturas, facilitando futuras alterações de identidade visual.

**Variáveis CSS principais:**

```css
:root {
  --green:        #2F4F4F;  /* Verde principal — seriedade e sofisticação */
  --orange:       #C96A2A;  /* Laranja de destaque — ação e calor */
  --bg:           #FCFBF9;  /* Fundo off-white — conforto visual */
  --radius-lg:    20px;     /* Curvatura grande — cards e seções */
  --shadow-lg:    0 16px 40px rgba(47,79,79,0.08); /* Sombra premium */
}
```

O layout responsivo é implementado por meio de media queries sem breakpoints de framework:

- `max-width: 1024px`: ajuste de grid de colunas e galeria de fotos;
- `max-width: 768px`: ocultação da navbar desktop, exibição do botão hambúrguer, adaptação de formulários e grids para coluna única.

O menu mobile utiliza um elemento `<div class="nav-mobile">` separado do menu desktop, ativado via JavaScript ao clicar no botão hambúrguer — adicionando/removendo a classe `.open` que alterna `display: none` para `display: flex`.

**Figura 12 — Layout responsivo em dispositivo móvel**

### 4.7 Identidade Visual

A identidade visual da Pousada Barão combina elementos que evocam sofisticação, natureza e confiança:

| Elemento | Escolha | Justificativa |
|----------|---------|---------------|
| Cor primária | Verde escuro (#2F4F4F) | Remete à natureza, seriedade e tranquilidade |
| Cor de destaque | Laranja (#C96A2A) | Calor, ação e hospitalidade |
| Tipografia de título | Playfair Display | Elegância clássica, associada à hotelaria de qualidade |
| Tipografia de texto | Plus Jakarta Sans | Leiturabilidade moderna e clean |
| Estilo visual | Minimalista premium | Transmite confiança sem sobrecarregar o usuário |
| Imagens | Fotografia real do local | Autenticidade e expectativas realistas |

**Tabela 4 — Tipos de acomodação e valores**

| Tipo | Nome | Preço/Noite | Capacidade | Avaliação |
|------|------|-------------|------------|-----------|
| Casal | Suíte Casal Conforto | R$ 180,00 | 2 pessoas | ⭐ 4,9 |
| Família | Quarto Familiar Triplo | R$ 250,00 | 3 pessoas | ⭐ 4,8 |
| Solteiro | Quarto Solteiro Econômico | R$ 120,00 | 1 pessoa | ⭐ 5,0 |

---

## 5 RESULTADOS E DISCUSSÃO

### 5.1 Funcionalidades Implementadas

Ao término do desenvolvimento, o sistema conta com as seguintes funcionalidades plenamente operacionais:

**Portal Público:**
- ✅ Página inicial com hero animado, estatísticas, cards de quartos, avaliações e FAQ;
- ✅ Listagem dinâmica de acomodações com filtro por tipo;
- ✅ Página de detalhe dinâmica por ID, com galeria, amenidades, descrição e widget de reserva;
- ✅ Formulário de reserva com validação de datas (client-side e server-side), verificação de disponibilidade e cálculo de valor estimado;
- ✅ Integração com WhatsApp em múltiplos pontos;
- ✅ Menu mobile funcional com animação de abertura;
- ✅ Design responsivo para smartphones e tablets.

**Painel Administrativo:**
- ✅ Autenticação por senha com controle de sessão;
- ✅ Dashboard com 4 indicadores em tempo real;
- ✅ Alerta visual de reservas pendentes;
- ✅ Tabela de reservas com link direto para WhatsApp de cada hóspede;
- ✅ Filtro por data e por status;
- ✅ Botões de confirmação, cancelamento e exclusão com feedback visual;
- ✅ Sistema de status: pendente / confirmada / cancelada.

**Banco de Dados:**
- ✅ Inicialização automática do arquivo JSON;
- ✅ Sistema de versionamento com atualização de estrutura preservando reservas;
- ✅ CRUD completo para reservas;
- ✅ Verificação de conflito de datas excluindo reservas canceladas.

### 5.2 Testes Realizados

Os testes foram conduzidos de forma manual, cobrindo os seguintes cenários:

| Cenário | Resultado |
|---------|-----------|
| Acessar o site sem `database.json` existente | Banco criado automaticamente ✅ |
| Acessar com banco de versão anterior | Estrutura atualizada, reservas preservadas ✅ |
| Enviar formulário com todos os campos | Reserva criada com sucesso ✅ |
| Enviar formulário com campos em branco | Mensagem de erro específica por campo ✅ |
| Tentar reservar data passada | Erro de validação exibido ✅ |
| Checkout anterior ao checkin | Erro de validação exibido ✅ |
| Tentar reservar quarto já ocupado no período | Mensagem de indisponibilidade ✅ |
| Cancelar reserva e tentar o mesmo período novamente | Disponibilidade liberada ✅ |
| Acessar admin sem autenticação | Redirecionado para tela de login ✅ |
| Confirmar reserva | Status atualizado, badge exibido ✅ |
| Excluir reserva | Registro removido com reindexação do array ✅ |
| Filtrar por data no admin | Apenas reservas do período exibidas ✅ |
| Acessar `quarto-detalhe.php?id=99` (inválido) | Redirecionado para quartos.php ✅ |
| Acesso em dispositivo móvel (768px) | Menu hamburger funcional, layout em coluna ✅ |

### 5.3 Limitações Identificadas

Embora o sistema atenda plenamente aos objetivos propostos para o contexto de uso, são reconhecidas as seguintes limitações técnicas:

1. **Senha hardcoded**: a senha do administrador está definida diretamente no código-fonte (`admin123`), o que representa risco de segurança caso o código seja acessado por terceiros. Recomenda-se migrar para um arquivo `.env` ou variável de ambiente;

2. **Ausência de controle de concorrência**: o banco de dados JSON não implementa bloqueio de arquivo (file locking). Em cenários de alto tráfego com escritas simultâneas, pode haver corrupção de dados. Para a escala atual do estabelecimento, este risco é negligenciável;

3. **Sem paginação**: o painel administrativo exibe todas as reservas sem paginação. Para volumes grandes, isso pode impactar a performance de carregamento;

4. **Autenticação simples**: o sistema utiliza uma senha única sem hash. Para produção robusta, recomenda-se o uso de `password_hash()` e armazenamento seguro;

5. **Sem envio de notificações**: o sistema não envia e-mail ou SMS automático ao administrador quando uma nova reserva é recebida. A integração com WhatsApp é manual.

---

## 6 CONCLUSÃO

### 6.1 Considerações Finais

O desenvolvimento do sistema web de gestão e reservas para a Pousada Barão demonstrou que é possível entregar uma solução digital funcional, de baixo custo e fácil manutenção utilizando tecnologias consolidadas e acessíveis. O projeto alcançou todos os objetivos específicos propostos: portal público responsivo, formulário de reserva com verificação de disponibilidade, painel administrativo com controle de status e banco de dados portátil em JSON.

Do ponto de vista técnico, o projeto proporcionou aprofundamento em PHP server-side, manipulação de dados JSON, design de interfaces com CSS moderno, validação de formulários em múltiplas camadas e aplicação de heurísticas de usabilidade.

Do ponto de vista prático, o sistema representa um avanço significativo para um estabelecimento que operava inteiramente de forma analógica, oferecendo ao gestor uma visão centralizada das reservas e ao hóspede um canal digital de agendamento disponível 24 horas.

### 6.2 Trabalhos Futuros

Para evolução futura do sistema, sugere-se:

1. **Migração para banco relacional (MySQL/SQLite)**: aumentar robustez e suporte a consultas complexas;
2. **Implementação de notificações**: envio de e-mail automático ao administrador via PHPMailer ao receber nova reserva;
3. **Integração com Pix/Mercado Pago**: permitir cobrança online no ato da solicitação;
4. **Painel de gestão de quartos**: adicionar, editar e remover quartos diretamente pelo painel sem alterar o código;
5. **Calendário de ocupação**: visualização visual por calendário das reservas ativas;
6. **Relatórios gerenciais**: geração de relatórios mensais de receita e taxa de ocupação em PDF;
7. **Autenticação robusta**: implementar múltiplos perfis de usuário com senhas hasheadas;
8. **Internacionalização**: suporte a reservas em inglês e espanhol para turistas estrangeiros.

---

## REFERÊNCIAS

BUHALIS, D.; LAW, R. **Progress in information technology and tourism management**: 20 years on and 10 years after the Internet — the state of eTourism research. *Tourism Management*, v. 29, n. 4, p. 609–623, 2008.

ECMA INTERNATIONAL. **ECMA-404**: The JSON Data Interchange Standard. 2. ed. Genebra: Ecma International, 2017. Disponível em: https://www.ecma-international.org/publications/standards/Ecma-404.htm. Acesso em: 7 jun. 2026.

GIL, A. C. **Como elaborar projetos de pesquisa**. 6. ed. São Paulo: Atlas, 2017.

LAUDON, K. C.; LAUDON, J. P. **Sistemas de informação gerenciais**. 16. ed. São Paulo: Pearson, 2021.

NIELSEN, J. **Usability Engineering**. San Francisco: Morgan Kaufmann, 1994.

OWASP. **OWASP Top Ten 2021**. Open Web Application Security Project, 2021. Disponível em: https://owasp.org/www-project-top-ten/. Acesso em: 7 jun. 2026.

PHP GROUP. **PHP Manual**. 2024. Disponível em: https://www.php.net/manual/pt_BR/. Acesso em: 7 jun. 2026.

W3C. **HTML5 Specification**. World Wide Web Consortium, 2014. Disponível em: https://www.w3.org/TR/html5/. Acesso em: 7 jun. 2026.

TAILWIND LABS. **Tailwind CSS Documentation**. 2024. Disponível em: https://tailwindcss.com/docs. Acesso em: 7 jun. 2026.

---

## APÊNDICE A — Código-Fonte Principal: db.php

```php
<?php
// db.php - Camada de dados JSON (sem necessidade de drivers PDO)

$dbFile    = __DIR__ . '/database.json';
$dbVersion = 2;

$defaultDb = [
    '_version' => $dbVersion,
    'quartos'  => [
        [
            'id' => 1, 'nome' => 'Suíte Casal Conforto', 'tipo' => 'casal',
            'preco' => 180, 'capacidade' => 2,
            'imagem' => 'img/quarto-duplo.png', 'avaliacao' => 4.9,
            'amenidades' => ['Wi-Fi rápido e gratuito', 'Ar Condicionado Split',
                             'TV Smart', 'Frigobar', 'Cama Queen Size'],
            'badge' => 'Mais Popular'
        ],
        [
            'id' => 2, 'nome' => 'Quarto Familiar Triplo', 'tipo' => 'familia',
            'preco' => 250, 'capacidade' => 3,
            'imagem' => 'img/quarto-familia.png', 'avaliacao' => 4.8,
            'amenidades' => ['Wi-Fi rápido e gratuito', 'Ventilador de Teto',
                             'Frigobar', '3 Camas de Solteiro'],
            'badge' => ''
        ],
        [
            'id' => 3, 'nome' => 'Quarto Solteiro Econômico', 'tipo' => 'solteiro',
            'preco' => 120, 'capacidade' => 1,
            'imagem' => 'img/quarto-single.png', 'avaliacao' => 5.0,
            'amenidades' => ['Wi-Fi rápido e gratuito', 'Mesa de Trabalho',
                             'Ventilador', '1 Cama de Solteiro'],
            'badge' => 'Melhor Custo-Benefício'
        ],
    ],
    'reservas'       => [],
    'next_reserva_id'=> 1
];

// Inicialização automática e versionamento
if (!file_exists($dbFile)) {
    file_put_contents($dbFile,
        json_encode($defaultDb, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
} else {
    $existing = json_decode(file_get_contents($dbFile), true);
    if (!isset($existing['_version']) || $existing['_version'] < $dbVersion) {
        $defaultDb['reservas']        = $existing['reservas']        ?? [];
        $defaultDb['next_reserva_id'] = $existing['next_reserva_id'] ?? 1;
        file_put_contents($dbFile,
            json_encode($defaultDb, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

function checkDisponibilidade($quarto_id, $data_entrada, $data_saida) {
    $db = lerBanco();
    foreach ($db['reservas'] as $r) {
        if ($r['quarto_id'] != $quarto_id) continue;
        if (($r['status'] ?? 'pendente') === 'cancelada') continue;
        if ($data_entrada < $r['data_saida'] && $data_saida > $r['data_entrada'])
            return true; // Conflito
    }
    return false;
}
// ... demais funções omitidas por brevidade
?>
```

---

## APÊNDICE B — Fluxo de Validação do Formulário de Reserva

```
INÍCIO
  │
  ▼
Usuário preenche formulário
  │
  ▼
[JavaScript] Valida client-side:
  - checkout.min = checkin.value
  - Recalcula preço total
  │
  ▼
POST enviado para reserva.php
  │
  ▼
[PHP] Validações server-side:
  ├─ Campos obrigatórios preenchidos? ──── NÃO → Exibe erros
  ├─ data_entrada >= hoje? ─────────────── NÃO → Erro: "data no passado"
  ├─ data_saida > data_entrada? ────────── NÃO → Erro: "datas inválidas"
  ├─ quantidade <= capacidade_quarto? ──── NÃO → Erro: "excede capacidade"
  └─ checkDisponibilidade() == false? ──── SIM → Erro: "quarto indisponível"
  │
  ▼ Todas as validações passaram
[PHP] addReserva() — Salva no JSON com status='pendente'
  │
  ▼
Exibe mensagem de sucesso
  + Botão "Confirmar pelo WhatsApp"
  │
  ▼
FIM
```

---

## APÊNDICE C — Estrutura Completa do database.json

```json
{
    "_version": 2,
    "quartos": [
        {
            "id": 1,
            "nome": "Suíte Casal Conforto",
            "tipo": "casal",
            "descricao": "O espaço ideal para casais...",
            "descricao_longa": "A Suíte Casal Conforto foi pensada...",
            "preco": 180,
            "capacidade": 2,
            "imagem": "img/quarto-duplo.png",
            "avaliacao": 4.9,
            "total_avaliacoes": 12,
            "amenidades": [
                "Wi-Fi rápido e gratuito",
                "Ar Condicionado Split",
                "TV Smart",
                "Frigobar",
                "Cama Queen Size",
                "Banheiro Privativo"
            ],
            "badge": "Mais Popular"
        },
        {
            "id": 2,
            "nome": "Quarto Familiar Triplo",
            "tipo": "familia",
            "preco": 250,
            "capacidade": 3,
            "imagem": "img/quarto-familia.png",
            "avaliacao": 4.8,
            "total_avaliacoes": 8,
            "amenidades": [
                "Wi-Fi rápido e gratuito",
                "Ventilador de Teto",
                "Frigobar",
                "3 Camas de Solteiro",
                "Vista para o Quintal",
                "Banheiro Privativo"
            ],
            "badge": ""
        },
        {
            "id": 3,
            "nome": "Quarto Solteiro Econômico",
            "tipo": "solteiro",
            "preco": 120,
            "capacidade": 1,
            "imagem": "img/quarto-single.png",
            "avaliacao": 5.0,
            "total_avaliacoes": 5,
            "amenidades": [
                "Wi-Fi rápido e gratuito",
                "Mesa de Trabalho",
                "Ventilador",
                "1 Cama de Solteiro",
                "Tomadas USB",
                "Banheiro Privativo"
            ],
            "badge": "Melhor Custo-Benefício"
        }
    ],
    "reservas": [
        {
            "id": 1,
            "nome_cliente": "Maria da Silva",
            "telefone": "(19) 99888-7766",
            "quarto_id": 1,
            "data_entrada": "2026-07-10",
            "data_saida": "2026-07-13",
            "quantidade_pessoas": 2,
            "status": "confirmada",
            "data_criacao": "2026-06-07 14:30:00"
        }
    ],
    "next_reserva_id": 2
}
```

---

*Documento gerado em: 07 de junho de 2026*  
*Sistema: Pousada Barão — Gestão de Reservas v2.0*  
*Desenvolvedor: Esdras de Souza*
