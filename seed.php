<?php

declare(strict_types=1);

use App\Seeder\DatabaseSeeder;
use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$seeder = new DatabaseSeeder();
$seeder->run();

echo "Database seeded successfully.\n";
