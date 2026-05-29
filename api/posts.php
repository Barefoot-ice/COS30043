<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

http_response_code(400);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';

if ($method === 'GET') {
    $query = "SELECT * FROM `posts`";
    $result = mysqli_query($conn, $query);

    $data = mysqli_fetch_all($result);
    http_response_code(200);
    echo json_encode($data);
}
?>