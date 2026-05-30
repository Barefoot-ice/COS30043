<?php



if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';

if ($method === 'GET' && isset($_GET['account_id'])) {
    $id = $_GET['account_id'];
    $query = "SELECT `account_id`, `username`, `email`, `password`, `created_at`, `role` FROM `accounts` WHERE account_id = $id;";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        http_response_code(500);
        die("Database Error: " . mysqli_error($conn)); 
    }
    $data = mysqli_fetch_row($result);
    http_response_code(200);
    echo json_encode($data);
    exit;
}
http_response_code(400);
?>
