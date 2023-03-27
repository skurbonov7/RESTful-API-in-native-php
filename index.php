<?php

header('Content-type: json/application');

include_once('functions.php');
include_once('core/arr.php');

$method = $_SERVER['REQUEST_METHOD'];
$params = parseUrl($_GET['q'] ?? '');

if($method === 'GET') {
    if ($params[0]) {
        if (isset($params[1])) {
            $post = messagesOne($params[1]);
            echo $post;
        } else {
            $posts = getAllPosts();
            echo $posts;
        }
    }
}elseif($method === 'POST'){
    $fields = extractFields($_POST, ['title', 'body']);
    if ($params[0]) {
        addPost($fields);
    }
}
