<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';

if ($method === 'PUT') {
    $account_id = intval($_GET['account_id']);
    $json = file_get_contents('php://input');
    $params = json_decode($json, true);
    if (!$params) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON payload."]);
        exit;
    }
    $email = isset($params['email']) ? trim($params['email']) : '';
    $username = isset($params['username']) ? trim($params['username']) : '';
    $password = isset($params['password']) ? trim($params['password']) : '';
    $query = "UPDATE `accounts` SET username = ?, email = ?, password = ? WHERE account_id= ?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $password, $account_id);
    if ($stmt && mysqli_stmt_execute($stmt)) {
        // Get the actual number of altered database rows
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        
        http_response_code(200);
        mysqli_stmt_close($stmt);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Database execution failed: " . mysqli_error($conn)]);
    }
    
    exit;
}
http_response_code(405);

?>
