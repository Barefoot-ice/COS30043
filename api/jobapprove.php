<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';

if ($method === 'GET') {
    $jobid = $_GET["jobid"];
    $approved = $_GET["approved"];

    $query = "UPDATE `jobs` SET approved = " . $approved . ", approvalRead = 1 WHERE job_id = \"" . $jobid . "\"";

    mysqli_query($conn, $query);


    http_response_code(200);
    echo "OK";
}
?>