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
}
