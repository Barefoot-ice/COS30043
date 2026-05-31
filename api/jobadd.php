<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

require 'sql.php';

if ($method === 'POST') {
    $json = file_get_contents('php://input');
    $params = json_decode($json, true);
    if (!$params) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON payload."]);
        exit;
    }
    $job_id = isset($params['job_id']) ? trim($params['job_id']) : '';
    $job_title = isset($params['job_title']) ? trim($params['job_title']) : '';
    $category = isset($params['category']) ? trim($params['category']) : '';
    $location = isset($params['location']) ? trim($params['location']) : '';
    $employment_type = isset($params['employment_type']) ? trim($params['employment_type']) : '';
    $job_level = isset($params['job_level']) ? trim($params['job_level']) : '';
    $job_description = isset($params['job_description']) ? trim($params['job_description']) : '';
    $application_deadline = isset($params['application_deadline']) ? trim($params['application_deadline']) : '';
    $supervisor = isset($params['supervisor']) ? trim($params['supervisor']) : '';
    $positions_available = isset($params['positions_available']) ? trim($params['positions_available']) : '';
    $start_date = isset($params['start_date']) ? trim($params['start_date']) : '';
    $salary_range = isset($params['salary_range']) ? trim($params['salary_range']) : '';
    $required_skills = isset($params['required_skills']) ? trim($params['required_skills']) : '';
    $preferred_qualifications = isset($params['preferred_qualifications']) ? trim($params['preferred_qualifications']) : '';
    $posted_date = isset($params['posted_date']) ? trim($params['posted_date']) : '';
    $company = isset($params['company']) ? trim($params['company']) : '';
    $approved = 0;
    $tags = isset($params['tags']) ? trim($params['tags']) : '';


    $query = "INSERT INTO `jobs` (
        `job_id`, `job_title`, `category`, `location`, `employment_type`, 
        `job_level`, `job_description`, `application_deadline`, `supervisor`, 
        `positions_available`, `start_date`, `salary_range`, `required_skills`, 
        `preferred_qualifications`, `posted_date`, `company`, `approved`, `tags`
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param(
        $stmt, 
        "sssssssssissssssis",
        $job_id, 
        $job_title, 
        $category, 
        $location, 
        $employment_type, 
        $job_level, 
        $job_description, 
        $application_deadline, 
        $supervisor, 
        $positions_available, 
        $start_date, 
        $salary_range, 
        $required_skills, 
        $preferred_qualifications, 
        $posted_date, 
        $company,
        $approved,
        $tags
    );    
    if ($stmt && mysqli_stmt_execute($stmt)) {
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
