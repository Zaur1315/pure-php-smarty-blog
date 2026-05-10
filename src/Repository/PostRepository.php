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

    public function findByCategorySlug(string $slug): array
    {
        return $this->db->fetchAll(
            'SELECT
            p.id,
            p.title,
            p.slug,
            p.image,
            p.description,
            p.views,
            p.published_at
         FROM posts p
         INNER JOIN post_categories pc
            ON pc.post_id = p.id
         INNER JOIN categories c
            ON c.id = pc.category_id
         WHERE c.slug = :slug
         ORDER BY p.published_at DESC',
            [
                'slug' => $slug,
            ]
        );
    }

    public function countByCategorySlug(string $slug): int
    {
        $result = $this->db->fetchOne(
            'SELECT COUNT(*) AS total
            FROM posts p
            INNER JOIN post_categories pc ON pc.post_id = p.id
            INNER JOIN categories c ON c.id = pc.category_id
            WHERE c.slug = :slug',
            [
                'slug' => $slug,
            ]
        );

        return (int)($result['total'] ?? 0);
    }

    public function findByCategorySlugPaginated(
        string $slug,
        int    $limit,
        int    $offset,
        string $sort = 'published_at',
        string $direction = 'DESC'
    ): array
    {
        $allowedSorts = [
            'published_at' => 'p.published_at',
            'views' => 'p.views',
            'title' => 'p.title',
        ];

        $sortColumn = $allowedSorts[$sort] ?? $allowedSorts['published_at'];
        $direction = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        return $this->db->fetchAll(
            sprintf(
                'SELECT
                    p.id,
                    p.title,
                    p.slug,
                    p.image,
                    p.description,
                    p.views,
                    p.published_at
                 FROM posts p
                 INNER JOIN post_categories pc ON pc.post_id = p.id
                 INNER JOIN categories c ON c.id = pc.category_id
                 WHERE c.slug = :slug
                 ORDER BY %s %s
                 LIMIT %d OFFSET %d',
                $sortColumn,
                $direction,
                $limit,
                $offset
            ),
            [
                'slug' => $slug,
            ]
        );
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->db->fetchOne(
            'SELECT
                id,
                title,
                slug,
                image,
                description,
                content,
                views,
                published_at
             FROM posts
             WHERE slug = :slug
             LIMIT 1',
            [
                'slug' => $slug,
            ]
        );
    }

    public function incrementViews(int $postId): void
    {
        $this->db->query(
            'UPDATE posts
            SET views = views + 1
            WHERE id = :id',
            [
                'id' => $postId,
            ]
        );
    }

    public function findRelatedPosts(int $postId, int $limit = 3): array
    {
        return $this->db->fetchAll(
            'SELECT DISTINCT
            related.id,
            related.title,
            related.slug,
            related.description,
            related.views,
            related.published_at
         FROM posts current_post
         INNER JOIN post_categories current_pc
            ON current_pc.post_id = current_post.id
         INNER JOIN post_categories related_pc
            ON related_pc.category_id = current_pc.category_id
         INNER JOIN posts related
            ON related.id = related_pc.post_id
         WHERE current_post.id = :current_post_id
           AND related.id != :excluded_post_id
         ORDER BY related.published_at DESC
         LIMIT ' . $limit,
            [
                'current_post_id' => $postId,
                'excluded_post_id' => $postId,
            ]
        );
    }
}
