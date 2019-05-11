<?php
/**
 * User: jaime sastre
 * Date: 08/03/2019
 * Time: 11:44
 */

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $post = new Post($db);

    // Get ID
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Post
    $post->read_single();

    // create array
    $post_arr = [
        'id' => $post->id,
        'title' => $post->title,
        'body' => html_entity_decode($post->body),
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    ];

    // Make Json
    print_r(json_encode($post_arr));

    //http://localhost:8080/php_rest_myblog/api/post/read_single.php?id=3