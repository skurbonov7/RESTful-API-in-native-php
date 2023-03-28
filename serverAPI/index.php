<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Credentials: true");
header('Content-type: application/json');

include_once('model/functions.php');
include_once('core/arr.php');

$method = $_SERVER['REQUEST_METHOD'];
$params = parseUrl($_GET['q'] ?? '');
$type = &$params[0];
$id = &$params[1];

if ($method === 'GET') {
    if ($type === 'posts') {
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
    if ($type === 'posts') {
        addPost($fields);
    }
} elseif ($method === 'PATCH') {
    if ($type === 'posts') {
        if (isset($id)) {
            $data = json_decode(file_get_contents('php://input'), true);
            updatePost($id, $data);
        }
    }
} elseif ($method === 'DELETE') {
    if ($type === 'posts') {
        if (isset($id)) {
            deletePost($id);
        }
    }
}
