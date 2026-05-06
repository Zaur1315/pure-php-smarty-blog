# Pure PHP Smarty Blog

Simple blog application built with pure PHP, MySQL and Smarty.

## Tech Stack

- PHP 8.1+
- MySQL 8
- Smarty
- SCSS
- Docker
- No PHP frameworks

## Docker Setup

The project includes a Docker environment with:

- PHP + Apache
- MySQL
- phpMyAdmin

### Start project

```bash
docker compose up -d --build
```

#### Application:

```http://localhost:8080```

#### phpMyAdmin:

```http://localhost:8081```

### Database credentials

```dotenv
Host: mysql
Port: 3306
Database: blog
User: blog_user
Password: blog_password
Root password: root_password
```

### Stop project

```bash
docker compose down
```

## Git Flow

Development is done using the following branch structure:

```
master
└── dev
    └── feature-*
```
