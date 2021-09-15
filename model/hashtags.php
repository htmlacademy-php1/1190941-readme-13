<?php

function getPostTags ($db, $id)
{
    return sqlGetMany($db,
        'SELECT h.name
             FROM hashtags h
                 JOIN post_tags pt ON h.id = pt.hashtag_id
             WHERE pt.post_id = ?;',
        [$id]);
}

// TODO дописать запрос на вставку тегов
function insertTags ($db, array $hashtag)
{
    $sql = "INSERT INTO hashtags (name) VALUES (?)";

    return preparedQuery($db, $sql, $hashtag);
}

function setTagToPost ($db, array $data)
{
    $sql = "INSERT INTO post_tags (hashtag_id, post_id) VALUES (?, ?)";

    return preparedQuery($db, $sql, $data);
}
