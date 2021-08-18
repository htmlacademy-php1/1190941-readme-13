<?php
/**
 * @var $db
 * @var $query
 * @var $isAuth
 * @var $userName
 */

require 'bootstrap.php';
require 'model/posts.php';
require 'model/comments.php';
require 'model/hashtags.php';

// TODO додумать с 0, ?id[]=343 не передавать в getPostById(), и что-то с undefined index (вспомнить где)
if (!is_string($_GET['id'])) {
    http_response_code(404);
}

$id = intval($_GET['id'] ?? null);
$post = getPostById($db, $id);

if (!$post) {
    http_response_code(404);
}

$comments = getPostComments($db, $id);
$hashtags = getPostTags($db, $id);

$pageMainContent = includeTemplate('post.php', [
    'post' => $post,
    'comments' => $comments,
    'hashtags' => $hashtags,
]);

$pageLayout = includeTemplate('layout.php', [
    'pageTitle' => $post['title'] . ' ▶️ Пост на Readme',
    'isAuth' => $isAuth,
    'userName' => $userName,
    'pageMainContent' => $pageMainContent,
    'pageMainClass' => 'publication',
]);

print($pageLayout);
