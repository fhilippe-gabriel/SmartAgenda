## 📌 Projeto / Project Overview

**PT-BR:**  
SmartAgenda é uma API RESTful para gerenciamento de agendamentos, com autenticação via Laravel Sanctum, CRUD completo de compromissos e associação direta com usuários autenticados.

**EN:**  
SmartAgenda is a RESTful API for managing appointments, featuring Laravel Sanctum authentication, full CRUD operations, and user-specific data protection.

---

## 🚀 Tecnologias / Technologies

-   PHP 8.3+
-   Laravel 12.x
-   SQLite (local dev)
-   Laravel Sanctum (token-based auth)
-   API RESTful

---

## ⚙️ Instalação / Installation

```bash
# Clone o repositório / Clone the repository
git clone https://github.com/fhilippe-gabriel/smartagenda-api.git
cd smartagenda-api

# Instale as dependências / Install dependencies
composer install

# Crie o arquivo de ambiente / Create .env file
cp .env.example .env

# Gere a chave da aplicação / Generate application key
php artisan key:generate

# Configure o banco de dados SQLite / Setup SQLite
touch database/database.sqlite
# Edite o .env e defina:
# DB_CONNECTION=sqlite
# DB_DATABASE=${caminho_completo}/database/database.sqlite

# Execute as migrations / Run migrations
php artisan migrate

# Inicie o servidor de desenvolvimento / Start the dev server
php artisan serve
```

---

## 🔐 Autenticação com Sanctum / Sanctum Authentication

**Endpoints:**

| Método | Rota            | Ação / Action                              | Protegida? |
| ------ | --------------- | ------------------------------------------ | ---------- |
| POST   | `/api/register` | Registro de usuário / User registration    | ❌         |
| POST   | `/api/login`    | Login e token / Login and token            | ❌         |
| GET    | `/api/me`       | Dados do usuário / Authenticated user info | ✅         |
| POST   | `/api/logout`   | Logout / Revoke token                      | ✅         |

Para acessar rotas protegidas, envie o token de autenticação no header:

```
Authorization: Bearer {token}
```

---

## 📆 Endpoints de Agendamento / Appointment Endpoints

**Todos os endpoints abaixo exigem autenticação.**  
All endpoints below require authentication.

| Método | Rota                       | Ação / Action                                |
| ------ | -------------------------- | -------------------------------------------- |
| GET    | `/api/appointments`        | Listar agendamentos do usuário               |
| POST   | `/api/appointments`        | Criar novo agendamento                       |
| GET    | `/api/appointments/{id}`   | Ver um agendamento específico                |
| PUT    | `/api/appointments/{id}`   | Atualizar agendamento                        |
| DELETE | `/api/appointments/{id}`   | Remover agendamento                          |
| GET    | `/api/appointments/search` | Buscar por cliente, serviço ou por intervalo |

---

## 📦 Estrutura do Projeto / Project Structure

```bash
app/
├── Models/
│   └── Appointment.php     # Modelo de agendamento
│   └── User.php            # Modelo de usuário com HasApiTokens
├── Http/
│   └── Controllers/
│       └── AuthController.php         # Autenticação
│       └── AppointmentController.php  # CRUD de agendamento
database/
└── migrations/             # Migrations
routes/
└── api.php                 # Rotas da API
```

---

## 🧪 Testando com Insomnia ou Postman / Testing with Insomnia or Postman

1. Faça login com `/api/login`
2. Copie o token e envie como `Authorization: Bearer {token}`
3. Acesse as rotas protegidas (`/me`, `/appointments`, etc.)

---

## 📝 Exemplo de Registro (POST /api/register)

```json
{
    "name": "Fhilippe",
    "email": "fhilippe@email.com",
    "password": "123456",
    "password_confirmation": "123456"
}
```

## 🔑 Exemplo de Login (POST /api/login)

```json
{
    "email": "fhilippe@email.com",
    "password": "123456"
}
```

## ✅ Exemplo de Agendamento (POST /api/appointments)

```json
{
    "client_name": "João da Silva",
    "service": "Corte de cabelo",
    "scheduled_at": "2025-04-15 10:00:00"
}
```

## 🔍 Exemplo de Filtro de Busca (GET /api/appointments/search)

```http
GET /api/appointments/search?client_name=joao
GET /api/appointments/search?service=corte
GET /api/appointments/search?scheduled_at=2025-04-15
GET /api/appointments/search?start_date=2025-04-01&end_date=2025-04-30
```

---

## 🌍 Internacionalização / i18n

Toda a documentação está disponível em **português e inglês** para facilitar a compreensão e aumentar a visibilidade internacional do projeto.

---

## 📜 Licença / License

Este projeto está licenciado sob a [MIT license](https://opensource.org/licenses/MIT).

---

## 📣 Contato / Contact

Desenvolvido por **Fhilippe**  
📧 [fhilippedev@gmail.com](mailto:fhilippedev@gmail.com)  
💼 [GitHub](https://github.com/fhilippe-gabriel)

---

## 🧠 Contribuindo / Contributing

Pull requests são bem-vindos! Veja o [guia de contribuição](https://laravel.com/docs/12.x/contributions) oficial.
