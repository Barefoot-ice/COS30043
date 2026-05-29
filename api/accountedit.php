<?php
http_response_code(400);
//still in progress
$id = $_GET['id'];
$username = $_GET['username'];
$pass = $_GET['pass'];
$email = $_GET['email'];

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';


$query = "UPDATE `accounts` SET username = $username, email = $email, password = $pass WHERE id=$id";;
$result = mysqli_query($conn, $query);

$data = mysqli_fetch_all($result);
http_response_code(200);
echo json_encode($data);

?>
