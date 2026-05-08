<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\Database\Database;

final class CategoryRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findAll(): array
    {
        return $this->db->fetchAll(
            'SELECT id, name, description, slug, created_at
             FROM categories
             ORDER BY id ASC'
        );
    }

    public function findWithLatestPosts(int $postsLimit = 3): array
    {
        $categories = $this->findAll();
        $postRepository = new PostRepository();

        foreach ($categories as &$category) {
            $category['posts'] = $postRepository->findLatestByCategory(
                (int) $category['id'],
                $postsLimit
            );
        }

        unset($category);

        return $categories;
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->db->fetchOne(
            'SELECT id, name, description, slug
             FROM categories
             WHERE slug = :slug
            LIMIT 1',
            [
                'slug' => $slug,
            ]
        );
    }
}
