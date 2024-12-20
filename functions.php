<?php
require_once './config/conn.php';

function registerUser($username, $password, $email, $isEmployer) {
    global $conn;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, is_employer) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$username, $hashedPassword, $email, $isEmployer]);
}

function loginUser($username, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}

function createJobListing($employerId, $title, $description, $location, $jobType, $experienceLevel, $salary) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO job_listings (employer_id, title, description, location, job_type, experience_level, salary) VALUES (?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([$employerId, $title, $description, $location, $jobType, $experienceLevel, $salary]);
}

function getJobListings($filters = []) {
    global $pdo;
    $query = "SELECT * FROM job_listings WHERE 1=1";
    $params = [];

    if (!empty($filters['job_type'])) {
        $query .= " AND job_type = ?";
        $params[] = $filters['job_type'];
    }
    if (!empty($filters['location'])) {
        $query .= " AND location LIKE ?";
        $params[] = "%{$filters['location']}%";
    }
    if (!empty($filters['experience_level'])) {
        $query .= " AND experience_level = ?";
        $params[] = $filters['experience_level'];
    }

    $query .= " ORDER BY created_at DESC";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function applyForJob($jobId, $userId) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO applications (job_id, user_id) VALUES (?, ?)");
    return $stmt->execute([$jobId, $userId]);
}

function getUserApplications($userId) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT a.*, j.title, j.company FROM applications a JOIN job_listings j ON a.job_id = j.id WHERE a.user_id = ? ORDER BY a.created_at DESC");
    $stmt->execute([$userId]);
    return $stmt->fetchAll();
}