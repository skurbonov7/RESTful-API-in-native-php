<?php

header('Content-type: json/application');

include_once('model/functions.php');
include_once('core/arr.php');

$method = $_SERVER['REQUEST_METHOD'];
$params = parseUrl($_GET['q'] ?? '');
$id = &$params[1];

if ($method === 'GET') {
    if ($params[0]) {
        if (isset($id)) {
            $post = messagesOne($id);
            echo $post;
        } else {
            $posts = getAllPosts();
            echo $posts;
        }
    }
} elseif ($method === 'POST') {
    $fields = extractFields($_POST, ['title', 'body']);
    if ($params[0]) {
        addPost($fields);
    }
} elseif ($method === 'PATCH') {
    if ($params[0]) {
        if (isset($id)) {
            $data = json_decode(file_get_contents('php://input'), true);
            updatePost($id, $data);
        }
    }
}elseif($method === 'DELETE'){
    
}
