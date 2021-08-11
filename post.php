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

// TODO додумать с 0, не передавать в get_post_by_id()
$id = intval($_GET['id'] ?? 0);
$post = getPostById($db, $id);

// TODO додумать с ?id[]=343 и undefined index
if (!$post) {
    get404Page($isAuth, $userName);
}

$comments = getPostComments($db, $id);

$pageMainContent = includeTemplate('post.php', [
    'post' => $post,
    'comments' => $comments,
]);

// TODO не подключается лэйаут
$pageLayout = includeTemplate('layout.php', [
    'pageTitle' => $post['title'] . ' ▶️ Пост на Readme',
    'isAuth' => $isAuth,
    'userName' => $userName,
    'pageMainContent' => $pageMainContent,
    'pageMainClass' => 'publication',
]);

print($pageLayout);
