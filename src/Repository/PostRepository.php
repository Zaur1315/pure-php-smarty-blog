<?php

declare(strict_types=1);

namespace App\Repository;

use App\Core\Database\Database;

/**
 * Repository for blog posts.
 *
 * Handles post queries, pagination, related posts,
 * view counters and homepage slider data.
 */
final class PostRepository
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Returns latest posts for a specific category.
     */
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

    /**
     * Counts posts inside a category.
     */
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

    /**
     * Returns paginated category posts with sorting support.
     */
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

    /**
     * Finds a single post by slug.
     */
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

    /**
     * Increments post view counter.
     */
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

    /**
     * Returns related posts based on shared categories.
     */
    public function findRelatedPosts(int $postId, int $limit = 3): array
    {
        return $this->db->fetchAll(
            'SELECT DISTINCT
            related.id,
            related.title,
            related.slug,
            related.image,
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

    /**
     * Returns one least-viewed post for each category.
     *
     * Used by the homepage hero slider.
     */
    public function findLeastViewedPostsByCategories(): array
    {
        return $this->db->fetchAll(
            'SELECT
            ranked_posts.id,
            ranked_posts.title,
            ranked_posts.slug,
            ranked_posts.image,
            ranked_posts.description,
            ranked_posts.views,
            ranked_posts.published_at,
            ranked_posts.category_name,
            ranked_posts.category_slug
        FROM (
            SELECT
                p.id,
                p.title,
                p.slug,
                p.image,
                p.description,
                p.views,
                p.published_at,
                c.name AS category_name,
                c.slug AS category_slug,
                ROW_NUMBER() OVER (
                    PARTITION BY c.id
                    ORDER BY p.views ASC, p.published_at DESC, p.id ASC
                ) AS post_rank
            FROM posts p
            INNER JOIN post_categories pc ON pc.post_id = p.id
            INNER JOIN categories c ON c.id = pc.category_id
        ) ranked_posts
        WHERE ranked_posts.post_rank = 1
        ORDER BY ranked_posts.category_name ASC'
        );
    }
}
