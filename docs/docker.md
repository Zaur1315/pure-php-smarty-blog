# Docker Setup

The project includes a Docker environment with:

- PHP + Apache
- MySQL
- phpMyAdmin

---

## Start project

```bash
docker compose up -d --build
```

### Application:

```http://localhost:8080```

### phpMyAdmin:

```http://localhost:8081```

---

## Database credentials

```dotenv
Host: mysql
Port: 3308
Database: pure_php_smarty_blog
User: blog_user
Password: blog_password
Root password: root_password
Charset: utf8mb4
```

---

## Stop project

```bash
docker compose down
```

---

## Apache

Apache is configured to use:

```public/index.php```

as the application entry point.

---

## Docker services
- app
- mysql
- phpmyadmin

---

[To top](#docker-setup)

[Back to Main](../README.md)