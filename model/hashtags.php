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
