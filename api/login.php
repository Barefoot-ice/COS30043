<?php
http_response_code(400);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';

if ($method === 'POST') {
    
    $json = file_get_contents('php://input');
    $params = json_decode($json, true);

    $username = isset($params['username']) ? trim($params['username']) : '';
    $password = isset($params['password']) ? trim($params['password']) : '';

    if (!empty($username) && !empty($password)) {
        
        $query = "SELECT account_id, username, role FROM accounts WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($data);
    }
}
?>