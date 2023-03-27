<?php
include_once('core/dbInstance.php');

//Получаем все посты
function getAllPosts()
{
    $sql = "SELECT * FROM posts ORDER BY title DESC";
    $query = dbQuery($sql);
    $posts = $query->fetchAll();

    return json_encode($posts);
}

//Получаем конктретный пост по id
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

//Добавляем пост
function addPost(array $fields)
{
    $db = dbInstance();
    $sql = "INSERT INTO `posts` (`title`, `body`) VALUES (:title, :body)";
    dbQuery($sql, $fields);
    
    http_response_code(201);
    $res = [
        'status' => true,
        'post_id' => $db->lastInsertId()
    ];
    echo json_encode($res);
    return true;
}

function updatePost(int $id, array $data)
{
    $db = dbInstance();
    $title = $data['title'];
    $body = $data['body'];
    $sql = "UPDATE `posts` SET `title` = '$title', `body` = '$body' WHERE `id` = '$id'";
    dbQuery($sql);

    http_response_code(200);
    $res = [
        'status' => true,
        'post_id' => 'Post is updated'
    ];
    echo json_encode($res);
    return true;
}

//Парсим url
function parseUrl($url)
{
    //разделяем url для получения id
    $params = explode('/', $url);
    $cnt = count($params);

    //Убираем последний слеш с url
    if ($params[$cnt - 1] === '') {
        unset($params[$cnt - 1]);
    }
    return $params;
}
