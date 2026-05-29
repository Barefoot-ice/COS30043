<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';

if ($method === 'GET') {
    $query = "SELECT * FROM `jobs`";
    $result = mysqli_query($conn, $query);

    $data = mysqli_fetch_all($result);
    http_response_code(200);
    echo json_encode($data);
}
?>