<?php


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';

if ($method === 'GET') {
    $query = "
    SELECT 
        posts.post_id,
        posts.account_id,
        posts.post_content,
        posts.created_at,
        posts.likes,
        accounts.username
        FROM posts
        JOIN accounts ON posts.account_id = accounts.account_id
        ORDER BY posts.created_at DESC
    ";
    $result = mysqli_query($conn, $query);

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($data as $key => $post) {
            if (isset($post['post_content'])) {
                $data[$key]['post_content'] = json_decode($post['post_content'], true);
            }
        }

    http_response_code(200);
    echo json_encode($data);
}

if ($method === 'POST') {

    $input = json_decode(file_get_contents("php://input"), true);

    //If Liking a post
    if (isset($input['action']) && $input['action'] === 'like') {

        $post_id = $input['post_id'];

        $query = "
            UPDATE posts
            SET likes = likes + 1
            WHERE post_id = ?
        ";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $post_id);
        mysqli_stmt_execute($stmt);

        echo json_encode(["message" => "Liked"]);
        exit();
    }

    //When making a new post
    $account_id = $input['account_id'];
    $content = json_encode($input['post_content']);

    $query = "INSERT INTO posts (account_id, post_content) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "is", $account_id, $content);

    if (mysqli_stmt_execute($stmt)) {
        http_response_code(201);
        echo json_encode(["message" => "Post created"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => mysqli_error($conn)]);
    }

    exit();
}
?>