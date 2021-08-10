<?php

/**
 * @var $db
 * @var array $queryString
 * @var int $isAuth
 * @var string $userName
*/

require 'bootstrap.php';
require 'model/types.php';
require 'model/posts.php';

$queryString = $_GET ?? [];
$queryString['type'] = $queryString['type'] ?? null;

$pagesCount = getPagesCount($db, $queryString['type']);
$limit = 6;
$totalPages = intval(ceil($pagesCount / $limit));
$queryString['page'] = intval($queryString['page'] ?? 1);
$offset = ($queryString['page'] - 1) * $limit;

$pagination['prev'] = $queryString['page'] - 1;
$pagination['next'] = $queryString['page'] + 1;
$pagination['next'] = $pagination['next'] <= $totalPages ? $pagination['next'] : null;

$postData = getPosts($db, $offset, $queryString['type']);
$postTypes = getPostTypes($db);

$pageMainContent = includeTemplate('index.php', [
    'postData' => $postData,
    'postTypes' => $postTypes,
    'queryString' => $queryString,
    'pagination' => $pagination,
]);

$pageLayout = includeTemplate('layout.php', [
    'pageTitle' => 'Readme - популярное',
    'isAuth' => $isAuth,
    'userName' => $userName,
    'pageMainContent' => $pageMainContent,
    'pageMainClass' => 'popular',
]);

print($pageLayout);
