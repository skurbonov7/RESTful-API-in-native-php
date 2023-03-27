<?php
include_once('dbInstance.php');

function getAllPosts()
{
    $sql = "SELECT * FROM posts ORDER BY title DESC";
    $query = dbQuery($sql);
    $posts = $query->fetchAll();

    return json_encode($posts);
}

function messagesOne(int $id)
{
    $sql = "SELECT * FROM posts WHERE id = $id";
    $query = dbQuery($sql);
    $post = $query->fetch();

    if ($post === false) {
        http_response_code(404);
        $res = [
            'status' => false,
            'message' => 'message no found'
        ];
        echo json_encode($res);
    } else {
        return json_encode($post);
    }
}

function addPost(array $fields)
{
    $db = dbInstance();
    $sql = "INSERT INTO `posts` (`title`, `body`) VALUES (:title, :body)";
    $query = $db->prepare($sql);
    $query->bindParam(':title', $fields['title']);
    $query->bindParam(':body', $fields['body']);
    $query->execute();
    dbCheckError($query);

    http_response_code(201);
    $res = [
        'status' => true,
        'post_id' => $db->lastInsertId()
    ];
    echo json_encode($res);
}

function parseUrl($url)
{
    $params = explode('/', $url);
    $cnt = count($params);

    if ($params[$cnt - 1] === '') {
        unset($params[$cnt - 1]);
    }
    return $params;
}
