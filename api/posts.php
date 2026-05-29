<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';

//Get posts
if ($method === 'GET') {
    $query = "SELECT * FROM `posts` ORDER BY `created_at` DESC";
    $result = mysqli_query($conn, $query);

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($data as $key => $post) {
            if (isset($post['post_content'])) {
                $data[$key]['post_content'] = json_decode($post['post_content'], true);
            }
        }

    http_response_code(200);
    echo json_encode($data);
    exit();
}


//Add new post
if ($method === 'POST') {

    $input = json_decode(file_get_contents("php://input"), true);

    if (
        !isset($input['account_id']) ||
        !isset($input['title']) ||
        !isset($input['body'])
    ) {
        http_response_code(400);

        echo json_encode([
            "message" => "Missing required fields"
        ]);

        exit();
    }

    $postContent = [
        "title" => $input['title'],
        "body" => $input['body'],
        "tags" => $input['tags'] ?? []
    ];

    $postContentJson = mysqli_real_escape_string(
        $conn,
        json_encode($postContent)
    );

    $accountId = (int)$input['account_id'];

    $query = "
        INSERT INTO posts (account_id, post_content)
        VALUES ($accountId, '$postContentJson')
    ";

    if (mysqli_query($conn, $query)) {

        http_response_code(201);

        echo json_encode([
            "post_ID" => mysqli_insert_id($conn),
            "account_id" => $accountId,
            "post_content" => $postContent,
            "created_at" => date("Y-m-d H:i:s")
        ]);

    } 
    else {

        http_response_code(500);

        echo json_encode([
            "message" => "Failed to create post"
        ]);
    }

    exit();
}


?>