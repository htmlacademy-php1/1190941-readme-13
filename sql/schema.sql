CREATE DATABASE readme_db
    DEFAULT CHARACTER SET utf8mb4;

USE readme_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(64) NOT NULL,
    avatar_name VARCHAR(255) NOT NULL UNIQUE,
    registration_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE types (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL UNIQUE,
    class_name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    title VARCHAR(255) NOT NULL,
    creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    type_id INT NOT NULL,
    author_id INT NOT NULL,
    original_author_id INT DEFAULT NULL,
    content TEXT NOT NULL,
    cite_author VARCHAR(255) DEFAULT NULL,
    views_count INT DEFAULT NULL,
    repost BOOL DEFAULT NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (original_author_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (type_id) REFERENCES types(id) ON DELETE CASCADE
);

CREATE TABLE hashtags (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE post_tags (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    hashtag_id INT NOT NULL,
    post_id INT NOT NULL,
    FOREIGN KEY (hashtag_id) REFERENCES hashtags(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    comment TEXT NOT NULL,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    post_id INT NOT NULL,
    author_id INT NOT NULL,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    message TEXT NOT NULL,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    recipient_id INT NOT NULL,
    sender_id INT NOT NULL,
    FOREIGN KEY (recipient_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    follower_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
