<!-- <p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<h1 align="center">📅 SmartAgenda API</h1>

<p align="center">A powerful scheduling API built with Laravel 12 and Sanctum, featuring user authentication and secure appointment management.</p>

---

## 📌 Projeto / Project Overview

**PT-BR:**  
SmartAgenda é uma API RESTful para gerenciamento de agendamentos, com autenticação via Laravel Sanctum, CRUD completo de compromissos e associação direta com usuários autenticados.

**EN:**  
SmartAgenda is a RESTful API for managing appointments, featuring Laravel Sanctum authentication, full CRUD operations, and user-specific data protection.

---

## 🚀 Tecnologias / Technologies

- PHP 8.3+
- Laravel 12.x
- SQLite (local dev)
- Laravel Sanctum (token-based auth)
- API RESTful

---

## ⚙️ Instalação / Installation

```bash
# Clone o repositório / Clone the repository
git clone https://github.com/seu-usuario/smartagenda-api.git
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

| Método | Rota           | Ação / Action         | Protegida? |
|--------|----------------|------------------------|------------|
| POST   | `/api/register` | Registro de usuário / User registration | ❌ |
| POST   | `/api/login`    | Login e token / Login and token | ❌ |
| GET    | `/api/me`       | Dados do usuário / Authenticated user info | ✅ |
| POST   | `/api/logout`   | Logout / Revoke token | ✅ |

Para acessar rotas protegidas, envie o token de autenticação no header:

```
Authorization: Bearer {token}
```

---

## 📆 Endpoints de Agendamento / Appointment Endpoints

**Todos os endpoints abaixo exigem autenticação.**  
All endpoints below require authentication.

| Método  | Rota                      | Ação / Action                |
|---------|---------------------------|------------------------------|
| GET     | `/api/appointments`       | Listar agendamentos do usuário |
| POST    | `/api/appointments`       | Criar novo agendamento        |
| GET     | `/api/appointments/{id}`  | Ver um agendamento específico |
| PUT     | `/api/appointments/{id}`  | Atualizar agendamento         |
| DELETE  | `/api/appointments/{id}`  | Remover agendamento           |

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

## 🧪 Testando com Postman / Testing with Postman

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
  "title": "Live de programação",
  "description": "Stream na Twitch sobre Laravel + React",
  "scheduled_to": "2025-04-10 14:00:00"
}
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
💼 [LinkedIn ou GitHub](https://github.com/fhilippe-gabriel)

---

## 🧠 Contribuindo / Contributing

Pull requests são bem-vindos! Veja o [guia de contribuição](https://laravel.com/docs/12.x/contributions) oficial.
