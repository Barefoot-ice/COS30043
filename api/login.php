<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';

if ($method === 'GET') {
    $email = $_GET["email"];
    $password = $_GET["password"];

    if (!empty($email) && !empty($password)) {
        
        $query = "SELECT account_id, username, role FROM accounts WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($data);
    }
}
?>