<?php

function getPostById ($db, $id)
{
    return sqlGetSingle($db, '
        SELECT p.id, title,
               text_content AS text,
               cite_author,
               img_name AS photo,
               youtube_link,
               link,
               views_count,
               repost,
               u.name AS author,
               u.avatar_name AS avatar,
               u.registration_date AS author_reg_date,
               t.class_name AS type,
               (SELECT COUNT(post_id)
                FROM likes l
                WHERE p.id = l.post_id) AS likes_count,
               (SELECT COUNT(post_id)
                FROM comments c
                WHERE p.id = c.post_id) AS comments_count,
               (SELECT COUNT(author_id)
                FROM posts p
                WHERE p.author_id = u.id) AS publications_count
        FROM posts p
                 JOIN users u ON author_id = u.id
                 JOIN types t ON type_id = t.id
        WHERE p.id = ?;',
        [$id]);
}

function getPosts ($db, $offset, $postType = '', $sort = '', $sortDirection = '', $limit = 6)
{
    // TODO валидация параметров перед запросом http://readme.loc/?sort=popularity&direction=gnflg
    $direction = $sortDirection ?? 'desc';

    switch ($sort) {
        case 'popularity':
            $orderBy = "likes_count $direction, comments_count $direction, p.views_count $direction";
            break;
        case 'likes':
            $orderBy = "likes_count $direction";
            break;
        case 'date':
            $orderBy = "p.creation_date $direction";
            break;
    }

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
         ORDER BY " . ($orderBy ?? 'p.views_count DESC') . "
         LIMIT ?
         OFFSET ?;";

    return ($postType)
        ? sqlGetMany($db, $sql, [$postType, $limit, $offset])
        : sqlGetMany($db, $sql, [$limit, $offset]);
}

function getPagesCount ($db, $postType = '')
{
    return ($postType)
        ? current(sqlGetSingle($db, '
        SELECT COUNT(*)
        FROM posts
        WHERE type_id = ?;',
            [$postType]))
        : current(sqlGetSingle($db, 'SELECT COUNT(*) FROM posts'));
}
