<?php
http_response_code(400);


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
?>