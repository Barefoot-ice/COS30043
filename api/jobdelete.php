<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';

if ($method === 'DELETE') {
    $json = file_get_contents('php://input');
    $params = json_decode($json, true);
    if (!$params) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON payload."]);
        exit;
    }
    $job_id = isset($params['job_id']) ? trim($params['job_id']) : '';
    $query = "DELETE FROM `jobs` WHERE job_id = ?;";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $job_id);
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
