<?php

function getPosts ($db, $offset, $postType = '', $limit = 6) {

    $sql = "SELECT p.*,
             u.name AS author,
             u.avatar_name AS avatar,
             t.name AS type_name,
             t.class_name AS type,
             (SELECT COUNT(post_id)
             FROM likes l
             WHERE p.id = l.post_id) AS likes_count,
             (SELECT COUNT(post_id)
             FROM comments c
             WHERE p.id = c.post_id) AS comments_count
         FROM posts p
             JOIN users u ON p.author_id = u.id
             JOIN types t ON p.type_id = t.id
         " . (($postType) ? 'WHERE t.id = ?' : '') . "
         ORDER BY p.views_count DESC
         LIMIT ?
         OFFSET ?;";

    return ($postType)
        ? sqlGetMany($db, $sql, [$postType, $limit, $offset])
        : sqlGetMany($db, $sql, [$limit, $offset]);
}

function getPagesCount ($db, $postType = '') {
    return ($postType)
        ? current(sqlGetSingle($db, '
        SELECT COUNT(*)
        FROM posts
        WHERE type_id = ?;',
            [$postType]))
        : current(sqlGetSingle($db, 'SELECT COUNT(*) FROM posts'));
}
