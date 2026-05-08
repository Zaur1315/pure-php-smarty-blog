<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\Database\Database;

final class PostRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function findLatestByCategory(int $categoryId, int $limit = 3): array
    {
        return $this->db->fetchAll(
            'SELECT p.id, p.title, p.slug, p.image, p.description, p.views, p.published_at
             FROM posts p
             INNER JOIN post_categories pc ON pc.post_id = p.id
             WHERE pc.category_id = :category_id
             ORDER BY p.published_at DESC
             LIMIT ' . $limit,
            [
                'category_id' => $categoryId,
            ]
        );
    }
}
