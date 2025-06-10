# 📌 ToDo App - Laravel 12 + Vue 3 + Bootstrap

Este é um projeto de demonstração para um sistema de gerenciamento de tarefas (ToDo List) 
O foco está em boas práticas, aplicação de design patterns e arquitetura limpa.

---

## 🚀 Tecnologias Utilizadas

- **Laravel 12** (API RESTful)
- **Vue 3** (SPA via Breeze)
- **Laravel Breeze** (Autenticação com Sanctum)
- **Bootstrap 5** (Interface responsiva)
- **MySQL** (ou SQLite, configurável)
- **Docker + Laravel Sail** (Ambiente local)
- **Pest** (Testes automatizados)
- **GitHub Actions** (CI/CD)

---

## 🛠 Funcionalidades

- Cadastro e login de usuários com autenticação via Sanctum
- CRUD de tarefas com título, descrição, status e prazo
- Listagem de tarefas com filtros e ordenação
- Paginação de tarefas
- Separação clara de responsabilidades (Service, Repository, DTO, Policy)
- Interface SPA com Vue 3 e Bootstrap

---

## 📦 Instalação Local

### Pré-requisitos

- Docker e Docker Compose
- Node.js e npm

### Passos

```bash
# Clone o repositório:
git clone <URL_DO_REPOSITORIO> todo-app
cd todo-app

# Suba os containers com Sail:
./vendor/bin/sail up -d

# Instale as dependências:
./vendor/bin/sail composer install
./vendor/bin/sail npm install

# Configure o .env:
cp .env.example .env
./vendor/bin/sail artisan key:generate

# Execute as migrações e seeders:
./vendor/bin/sail artisan migrate --seed

# Compile os assets:
./vendor/bin/sail npm run dev
```

Acesse o app em: [http://localhost](http://localhost)

---

## 🔑 Autenticação

- **Registro:** `/register`
- **Login:** `/login`
- **Dashboard:** `/dashboard` (requer login)

---

## 🔗 Endpoints da API

| Método | Rota              | Descrição         |
|--------|-------------------|------------------|
| GET    | /api/tasks        | Listar tarefas   |
| POST   | /api/tasks        | Criar nova tarefa|
| PUT    | /api/tasks/{id}   | Atualizar tarefa |
| DELETE | /api/tasks/{id}   | Excluir tarefa   |

> Autenticação via token Sanctum obrigatória.

---

## ✅ Testes

Execute os testes com Pest:

```bash
./vendor/bin/sail artisan pest
```

---

## ⚙️ CI/CD

Este projeto conta com integração contínua via **GitHub Actions**, que executa os testes automaticamente a cada push e pull request.

---

## 🌍 Deploy

- **Backend:** Pode ser hospedado via Railway, Render ou VPS.
- **Frontend:** `npm run build` e hospedar o conteúdo de `public/` em Vercel ou Netlify.

---
