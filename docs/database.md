# Database and Seeder

The project uses MySQL 8 as the primary database.

Database access is implemented through PDO without using any ORM or framework.

---

## Database Layer

Main database class:

```text
App\Core\Database\Database
```

Responsibilities:

- create PDO connection
- provide singleton database instance
- execute SQL queries
- fetch data
- return last inserted IDs

---

## PDO Configuration

The database connection uses:

```php
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
PDO::ATTR_EMULATE_PREPARES => false
```

Benefits:

- exceptions on SQL errors
- associative arrays by default
- real prepared statements

---

## Database Configuration

Database config file:

```
config/database.php
```

Configuration values are loaded from:

```dotenv
.env
```

Example:

```dotenv
DB_HOST=mysql
DB_PORT=3306
DB_NAME=pure_php_smarty_blog
DB_USER=blog_user
DB_PASSWORD=blog_password
DB_CHARSET=utf8mb4
```

---

## Database Schema

Main schema file:

```
database/schema.sql
```

Contains tables:

- categories
- posts
- post_categories

---

## Categories Table

Stores blog categories.

Fields:

| Field       | Type      |
| ----------- | --------- |
| id          | BIGINT    |
| name        | VARCHAR   |
| description | TEXT      |
| slug        | VARCHAR   |
| created_at  | TIMESTAMP |

---

## Posts Table

Stores blog posts.

Fields:

| Field        | Type      |
| ------------ | --------- |
| id           | BIGINT    |
| title        | VARCHAR   |
| slug         | VARCHAR   |
| image        | VARCHAR   |
| description  | TEXT      |
| content      | LONGTEXT  |
| views        | INT       |
| published_at | DATETIME  |
| created_at   | TIMESTAMP |

---

## Post Categories Table

Pivot table for many-to-many relation between posts and categories.

Fields:

| Field       | Type   |
| ----------- | ------ |
| post_id     | BIGINT |
| category_id | BIGINT |

---

## Repository Layer

Repositories are stored in:

```
src/Repository
```

Current repositories:

- CategoryRepository
- PostRepository

Responsibilities:

- isolate SQL logic
- fetch data
- prepare paginated results
- handle sorting/filtering

---

CategoryRepository

Handles category queries.

Implemented methods:

- findAll()
- findBySlug()
- findWithLatestPosts()

---

## PostRepository

Handles post queries.

Implemented methods:

- findLatestByCategory()
- findByCategorySlug()
- findByCategorySlugPaginated()
- countByCategorySlug()
- findBySlug()
- incrementViews()
- findRelatedPosts()
- findLeastViewedPostsByCategories()

---

## Pagination

Category pages support pagination.

Logic:

```php
$offset = ($page - 1) * self::PER_PAGE;
```
Default posts per page:

```php
6
```

---

### Sorting

Allowed sorting fields:

- published_at
- views
- title

Direction:

- ASC
- DESC

Sorting is protected through a whitelist.

---

## Homepage Slider Query

Homepage slider uses:

```sql
ROW_NUMBER() OVER (
    PARTITION BY c.id
    ORDER BY p.views ASC, p.published_at DESC
)
```

Purpose:

- select one least-viewed post per category

This requires MySQL 8 window functions.

---

## Seeder

Seeder class:

```
App\Seeder\DatabaseSeeder
```

Responsibilities:

- clear database tables
- create demo categories
- create demo posts
- create post/category relations

---

## Seeded Data

Seeder creates:

- 3 categories
- 12 posts per category
- 36 posts total

Categories:

- PHP
- MySQL
- Frontend

---

## Images

Posts use demo images stored in:

```
public/assets/images/posts/
```

Naming format:

```
1.jpg
2.jpg
3.jpg
...
36.jpg
```

Image path stored in database:

```
/assets/images/posts/{number}.jpg
```

---

## Running Seeder

Run seeder:

```shell
docker exec -it pure_php_smarty_blog_app php seed.php
```

Seeder will:

- clear old data
- recreate demo content

---

## Slug Generation

Seeder generates slugs automatically.

Example:

```
Getting Started with PHP
↓
getting-started-with-php
```

---

## Current Status

Implemented:

- PDO database layer
- singleton DB connection
- repositories
- category queries
- post queries
- pagination
- sorting
- related posts
- homepage slider query
- demo data seeder
- image support

---

[To top](#database-and-seeder)

[Back to Main](../README.md)