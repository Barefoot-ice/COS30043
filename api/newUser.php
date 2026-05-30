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
    $email = isset($params['email']) ? trim($params['email']) : '';

    if (!empty($username) && !empty($password) && !empty($email)) {
        
        $query = "INSERT INTO accounts (username, email, password, role) VALUES ('$username', '$email', '$password', 'employee')";
        $result = mysqli_query($conn, $query);

        http_response_code(200);
        echo json_encode(["status" => "success", "message" => "Account created successfully."]);
    }
    else
    {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
    }
}
?>