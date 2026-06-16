# Deploy — Pousada Barão (Railway + MySQL)

O sistema agora usa **MySQL** (PDO) no lugar do antigo JSON. As tabelas, a chave
estrangeira e os **triggers** são criados automaticamente pelo `db.php` na
primeira vez que o site abre — você não precisa rodar nada à mão. O arquivo
`schema.sql` é o entregável SQL (para importar/mostrar no trabalho, se quiser).

O Railway dá a cada projeto um **banco MySQL próprio com privilégios totais**, então
triggers funcionam sem restrição (diferente de hospedagens grátis compartilhadas).

---

## Passo a passo

### 1. Subir o código no GitHub
No terminal, dentro da pasta do projeto:

```bash
git add .
git commit -m "Migra banco de JSON para MySQL + deploy Railway"
git push
```

(Se ainda não tiver repositório remoto, crie um no GitHub e faça o `git remote add origin ...` antes do push.)

### 2. Criar o projeto no Railway
1. Acesse **https://railway.app** e faça login com o GitHub.
2. **New Project → Deploy from GitHub repo** e selecione este repositório.
3. O Railway detecta o `Dockerfile` e começa a montar a imagem PHP+Apache sozinho.

### 3. Adicionar o banco MySQL
1. Dentro do projeto: **New → Database → Add MySQL**.
2. Espere subir. Ele cria as variáveis `MYSQLHOST`, `MYSQLPORT`, `MYSQLUSER`,
   `MYSQLPASSWORD`, `MYSQLDATABASE` automaticamente.

### 4. Ligar o app ao banco (variáveis de ambiente)
1. Clique no **serviço do app** (não no banco) → aba **Variables**.
2. Adicione estas 5 variáveis como **referência** ao serviço do MySQL
   (use o botão de referência ou o editor "Raw"; troque `MySQL` pelo nome real
   do serviço de banco, se for diferente):

   ```
   MYSQLHOST=${{MySQL.MYSQLHOST}}
   MYSQLPORT=${{MySQL.MYSQLPORT}}
   MYSQLUSER=${{MySQL.MYSQLUSER}}
   MYSQLPASSWORD=${{MySQL.MYSQLPASSWORD}}
   MYSQLDATABASE=${{MySQL.MYSQLDATABASE}}
   ```

3. Salve. O Railway vai reimplantar o app.

### 5. Gerar o domínio público
1. No serviço do app → **Settings → Networking → Generate Domain**.
2. Abra a URL gerada. Na primeira visita, o `db.php` cria as tabelas, os
   triggers e insere os quartos iniciais. Pronto — está no ar. 🎉

---

## Conferindo os triggers
No painel do MySQL do Railway (aba **Data** ou **Query**), rode:

```sql
SHOW TRIGGERS;
SELECT * FROM reservas_log;
```

Faça uma reserva pelo site e mude o status no `admin.php` (senha: `admin123`) —
cada ação aparece na tabela `reservas_log`, gravada pelos triggers.

## Importar o schema.sql manualmente (opcional)
Se preferir criar tudo por SQL antes (em vez do auto-init):

```bash
mysql -h HOST -P PORTA -u USUARIO -p NOME_DO_BANCO < schema.sql
```

Pegue HOST/PORTA/USUÁRIO/SENHA na aba **Connect** do serviço MySQL no Railway.
O `schema.sql` usa `DELIMITER` (compatível com cliente mysql, phpMyAdmin e Workbench).

---

## Rodar localmente (opcional)
Precisa de um MySQL local. Defina as variáveis antes de subir o PHP:

```bash
export MYSQLHOST=127.0.0.1 MYSQLPORT=3306 MYSQLUSER=root MYSQLPASSWORD= MYSQLDATABASE=pousada
php -S localhost:8000
```

(No PowerShell: `$env:MYSQLHOST="127.0.0.1"`, etc.)

## Nota sobre custo
O Railway é gratuito dentro do crédito de avaliação ($5). Para um projeto
acadêmico/demonstração isso costuma sobrar. Se o crédito acabar, o app pausa até
o próximo ciclo — basta ficar de olho perto da apresentação.
