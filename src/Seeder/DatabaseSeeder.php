<?php

declare(strict_types=1);

namespace App\Seeder;

use App\Core\Database\Database;

final class DatabaseSeeder
{
    public function run(): void
    {
        $database = Database::getInstance();

        $database->query('DELETE FROM post_categories');
        $database->query('DELETE FROM posts');
        $database->query('DELETE FROM categories');

        $database->query(
            'INSERT INTO categories (name, description, slug) VALUES
            (:name1, :description1, :slug1),
            (:name2, :description2, :slug2),
            (:name3, :description3, :slug3)',
            [
                'name1' => 'PHP',
                'description1' => 'Articles about PHP development.',
                'slug1' => 'php',

                'name2' => 'MySQL',
                'description2' => 'Database design and SQL examples.',
                'slug2' => 'mysql',

                'name3' => 'Frontend',
                'description3' => 'HTML, CSS and frontend practices.',
                'slug3' => 'frontend',
            ]
        );

        $database->query(
            'INSERT INTO posts (title, slug, image, description, content, views, published_at) VALUES
            (:title1, :slug1, :image1, :description1, :content1, :views1, :publishedAt1),
            (:title2, :slug2, :image2, :description2, :content2, :views2, :publishedAt2),
            (:title3, :slug3, :image3, :description3, :content3, :views3, :publishedAt3)',
            [
                'title1' => 'Getting Started with PHP',
                'slug1' => 'getting-started-with-php',
                'image1' => null,
                'description1' => 'Basic PHP concepts for beginners.',
                'content1' => 'Full article content about PHP.',
                'views1' => 12,
                'publishedAt1' => '2026-05-08 10:00:00',

                'title2' => 'MySQL Tables and Relations',
                'slug2' => 'mysql-tables-and-relations',
                'image2' => null,
                'description2' => 'How to design simple MySQL tables.',
                'content2' => 'Full article content about MySQL.',
                'views2' => 8,
                'publishedAt2' => '2026-05-07 10:00:00',

                'title3' => 'CSS Layout Basics',
                'slug3' => 'css-layout-basics',
                'image3' => null,
                'description3' => 'Simple layout practices with CSS.',
                'content3' => 'Full article content about CSS.',
                'views3' => 5,
                'publishedAt3' => '2026-05-06 10:00:00',
            ]
        );

        $database->query(
            'INSERT INTO post_categories (post_id, category_id)
             SELECT p.id, c.id
             FROM posts p
             INNER JOIN categories c ON
                (p.slug = :phpPostSlug AND c.slug = :phpCategorySlug)
                OR (p.slug = :mysqlPostSlug AND c.slug = :mysqlCategorySlug)
                OR (p.slug = :frontendPostSlug AND c.slug = :frontendCategorySlug)',
            [
                'phpPostSlug' => 'getting-started-with-php',
                'phpCategorySlug' => 'php',

                'mysqlPostSlug' => 'mysql-tables-and-relations',
                'mysqlCategorySlug' => 'mysql',

                'frontendPostSlug' => 'css-layout-basics',
                'frontendCategorySlug' => 'frontend',
            ]
        );
    }
}
