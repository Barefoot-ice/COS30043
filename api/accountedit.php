<?php
http_response_code(400);
//still in progress


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';

if ($method === 'PUT') {
    $id = $_GET['id'];
    $json = file_get_contents('php://input');
    $params = json_decode($json, true);
    $username = isset($params['email']) ? trim($params['email']) : '';
    $username = isset($params['username']) ? trim($params['username']) : '';
    $password = isset($params['password']) ? trim($params['password']) : '';
    $query = "UPDATE `accounts` SET username = $username, email = $email, password = $password WHERE id=$id;"
    $result = mysqli_query($conn, $query);

    $data = mysqli_fetch_all($result);
    http_response_code(200);
    echo json_encode($data);

?>
