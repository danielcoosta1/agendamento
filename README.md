# 📅 Sistema de Agendamento de Eventos

Um sistema web completo para gerenciamento de reservas de espaços e agendamento de eventos. Desenvolvido em **PHP** puro com foco em fundamentos da web, segurança e usabilidade.

![Status](https://img.shields.io/badge/Status-Concluído-brightgreen)
![PHP](https://img.shields.io/badge/Backend-PHP_8-blue)
![MySQL](https://img.shields.io/badge/Database-MySQL-orange)

## 📸 Demonstração

> **[INSIRA AQUI SEUS PRINTS/GIFS DEPOIS]**

## 🚀 Funcionalidades

### 🔐 Autenticação e Segurança
- **Login Seguro:** Senhas criptografadas com `password_hash`.
- **Controle de Acesso (RBAC):**
    - **Admin:** Gerencia locais, eventos e usuários.
    - **Comum:** Agenda e visualiza eventos.
- **Proteção de Rotas:** Páginas restritas verificam sessão ativa.

### 📅 Gestão de Eventos
- **CRUD Completo:** Criar, Ler, Editar e Excluir eventos.
- **Validação de Conflito:** Impede agendamento duplicado no mesmo local/horário.
- **Filtros Avançados:** Busca por palavra-chave, data ou local.
- **Visualização Híbrida:** Lista detalhada ou **Calendário Visual** (FullCalendar.js).

### 🏢 Gestão de Recursos
- **Locais:** Cadastro de salas/auditórios (Restrito a Admin).
- **Dashboard:** Métricas em tempo real na tela inicial.
- **Relatórios:** Modo de impressão limpo para gerar PDFs da agenda.

## 🛠️ Tecnologias

* **Backend:** PHP 8.2 (Procedural)
* **Banco de Dados:** MySQL / MariaDB
* **Frontend:** HTML5, CSS3 (Dark Theme), JavaScript
* **Libs:** FullCalendar.js (via CDN)
* **Servidor:** Apache (XAMPP)

## ⚙️ Instalação e Uso

1.  **Clone o repositório** na pasta do seu servidor (ex: `htdocs`):
    ```bash
    git clone [https://github.com/danielcoosta1/agendamento.git](https://github.com/danielcoosta1/agendamento.git)
    ```

2.  **Banco de Dados:**
    * Crie um banco chamado `agendamentos_db` no MySQL.
    * Importe as tabelas (`usuarios`, `locais`, `eventos`) conforme descrito na documentação ou crie-as manualmente.
    * *Dica:* Crie um usuário inicial na tabela `usuarios` com uma senha hash gerada.

3.  **Configuração:**
    * Verifique o arquivo `conexao.php` se as credenciais (root/senha) batem com seu ambiente local.

4.  **Executar:**
    * Inicie o Apache e MySQL no XAMPP.
    * Acesse: `http://localhost/agendamento/login.php`

## 📂 Estrutura do Projeto

* `conexao.php`: Conexão central com o banco.
* `login.php` / `cadastro.php`: Entrada do sistema.
* `area_restrita.php`: Painel principal (Dashboard).
* `eventos_*.php`: Scripts de gestão de eventos.
* `locais_*.php`: Scripts de gestão de locais.
* `calendario.php`: Interface do calendário visual.
* `api_eventos.php`: API que fornece dados JSON para o calendário.
* `style.css`: Estilização global.

---
Desenvolvido por **Daniel Costa** como projeto final da disciplina de Programação Web.