<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\Database\Database;

/**
 * Repository for blog categories.
 *
 * Provides methods for reading category data
 * and loading categories together with latest posts.
 */
final class CategoryRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Returns all categories ordered by ID.
     */
    public function findAll(): array
    {
        return $this->db->fetchAll(
            'SELECT id, name, description, slug, created_at
             FROM categories
             ORDER BY id ASC'
        );
    }

    /**
     * Returns all categories with a limited number of latest posts.
     */
    public function findWithLatestPosts(int $postsLimit = 3): array
    {
        $categories = $this->findAll();
        $postRepository = new PostRepository();

        foreach ($categories as &$category) {
            $category['posts'] = $postRepository->findLatestByCategory(
                (int)$category['id'],
                $postsLimit
            );
        }

        unset($category);

        return $categories;
    }

    /**
     * Finds a single category by its slug.
     */
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
