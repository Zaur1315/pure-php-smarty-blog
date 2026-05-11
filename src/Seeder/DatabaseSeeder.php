<?php

declare(strict_types=1);

namespace App\Seeder;

use App\Core\Database\Database;

/**
 * Seeds the database with demo blog data.
 *
 * Creates:
 * - categories
 * - posts
 * - post/category relations
 */
final class DatabaseSeeder
{
    /**
     * Runs the database seeding process.
     */
    public function run(): void
    {
        $database = Database::getInstance();

        /**
         * Clears existing data before seeding.
         */
        $database->query('DELETE FROM post_categories');
        $database->query('DELETE FROM posts');
        $database->query('DELETE FROM categories');

        /**
         * Demo categories and posts dataset.
         */
        $categories = [
            [
                'name' => 'PHP',
                'description' => 'Articles about PHP development, clean code and backend architecture.',
                'slug' => 'php',
                'posts' => [
                    'Getting Started with PHP',
                    'PHP Arrays in Practice',
                    'Working with Classes in PHP',
                    'Simple Routing Without Frameworks',
                    'Using PDO Safely',
                    'Building a Mini MVC Application',
                    'PHP Error Handling Basics',
                    'Composer Autoload Explained',
                    'Writing Clean PHP Functions',
                    'Understanding PHP Visibility',
                    'Simple Dependency Management',
                    'PHP Project Structure Tips',
                ],
            ],
            [
                'name' => 'MySQL',
                'description' => 'Database design, SQL queries and practical MySQL examples.',
                'slug' => 'mysql',
                'posts' => [
                    'MySQL Tables and Relations',
                    'Indexes for Better Performance',
                    'Writing Clean SELECT Queries',
                    'Understanding JOIN Types',
                    'Pagination with LIMIT and OFFSET',
                    'Designing Blog Database Schema',
                    'Using Foreign Keys Correctly',
                    'Filtering Data with WHERE',
                    'Sorting Results with ORDER BY',
                    'Counting Rows in MySQL',
                    'Simple Data Seeding Strategy',
                    'Optimizing Basic SQL Queries',
                ],
            ],
            [
                'name' => 'Frontend',
                'description' => 'HTML, SCSS, layouts and frontend practices without heavy frameworks.',
                'slug' => 'frontend',
                'posts' => [
                    'CSS Layout Basics',
                    'SCSS Project Structure',
                    'Responsive Cards Grid',
                    'Building a Simple Header',
                    'Typography for Blog Pages',
                    'Using jQuery Carefully',
                    'Creating Reusable UI Blocks',
                    'Styling Pagination Links',
                    'Mobile First Layout Tips',
                    'Organizing Frontend Assets',
                    'Simple Blog Card Design',
                    'Working with Image Ratios',
                ],
            ],
        ];

        $categoryIds = [];

        /**
         * Inserts categories and stores their generated IDs.
         */
        foreach ($categories as $category) {
            $database->query(
                'INSERT INTO categories (name, description, slug)
                 VALUES (:name, :description, :slug)',
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'slug' => $category['slug'],
                ]
            );

            $categoryIds[$category['slug']] = (int)$database->lastInsertId();
        }

        $imageNumber = 1;
        $daysAgo = 0;

        /**
         * Inserts posts and category relations.
         */
        foreach ($categories as $category) {
            foreach ($category['posts'] as $index => $title) {
                $slug = $this->slugify($title);
                $description = $this->makeDescription($title, $category['name']);
                $content = $this->makeContent($title, $category['name']);

                $database->query(
                    'INSERT INTO posts (
                        title,
                        slug,
                        image,
                        description,
                        content,
                        views,
                        published_at
                    ) VALUES (
                        :title,
                        :slug,
                        :image,
                        :description,
                        :content,
                        :views,
                        :published_at
                    )',
                    [
                        'title' => $title,
                        'slug' => $slug,
                        'image' => '/assets/images/posts/' . $imageNumber . '.jpg',
                        'description' => $description,
                        'content' => $content,
                        'views' => ($index + 1) * 7,
                        'published_at' => date('Y-m-d H:i:s', strtotime('2026-05-10 10:00:00 -' . $daysAgo . ' days')),
                    ]
                );

                $postId = (int)$database->lastInsertId();

                $database->query(
                    'INSERT INTO post_categories (post_id, category_id)
                     VALUES (:post_id, :category_id)',
                    [
                        'post_id' => $postId,
                        'category_id' => $categoryIds[$category['slug']],
                    ]
                );

                $imageNumber++;
                $daysAgo++;
            }
        }
    }

    /**
     * Converts a string into a URL-friendly slug.
     */
    private function slugify(string $value): string
    {
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';
        return trim($value, '-');
    }

    /**
     * Generates a short demo description for a post.
     */
    private function makeDescription(string $title, string $categoryName): string
    {
        return sprintf(
            '%s is a practical article from the %s section with short examples and clear explanations.',
            $title,
            $categoryName
        );
    }

    /**
     * Generates demo HTML content for a post.
     */
    private function makeContent(string $title, string $categoryName): string
    {
        return sprintf(
            '<p>%s introduces an important topic from the %s category. The article explains the main idea in simple words and shows how it can be used in a small project.</p>
            <p>This material is written for developers who want to understand the basics without using a heavy framework. It focuses on clean structure, readable code and practical implementation.</p>
            <p>After reading it, you should have a better understanding of how this part of the blog application works and how it can be extended later.</p>',
            $title,
            $categoryName
        );
    }
}