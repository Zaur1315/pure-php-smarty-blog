CREATE TABLE categories
(
    id          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    description TEXT NULL,
    slug        VARCHAR(255) NOT NULL UNIQUE,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts
(
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(255) NOT NULL,
    slug         VARCHAR(255) NOT NULL UNIQUE,
    image        VARCHAR(255) NULL,
    description  TEXT NULL,
    content      LONGTEXT     NOT NULL,
    views        INT UNSIGNED NOT NULL DEFAULT 0,
    published_at DATETIME     NOT NULL,
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE post_categories
(
    post_id     BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,

    PRIMARY KEY (post_id, category_id),

    CONSTRAINT fk_post_categories_post
        FOREIGN KEY (post_id) REFERENCES posts (id)
            ON DELETE CASCADE,

    CONSTRAINT fk_post_categories_category
        FOREIGN KEY (category_id) REFERENCES categories (id)
            ON DELETE CASCADE
);
