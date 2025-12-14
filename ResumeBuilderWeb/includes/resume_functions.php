<?php
function createResume($user_id, $title, $template_id, $resume_data) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO resumes (user_id, title, template_id, resume_data) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $user_id, $title, $template_id, $resume_data);
    
    return $stmt->execute();
}

function getUserResumes($user_id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT id, title, template_id, created_at, updated_at FROM resumes WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    return $stmt->get_result();
}

function getResumeById($resume_id, $user_id) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM resumes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $resume_id, $user_id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    return $result->num_rows === 1 ? $result->fetch_assoc() : null;
}

function updateResume($resume_id, $user_id, $title, $resume_data) {
    global $conn;
    
    $stmt = $conn->prepare("UPDATE resumes SET title = ?, resume_data = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $title, $resume_data, $resume_id, $user_id);
    
    return $stmt->execute();
}

function deleteResume($resume_id, $user_id) {
    global $conn;
    
    $stmt = $conn->prepare("DELETE FROM resumes WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $resume_id, $user_id);
    
    return $stmt->execute();
}
?>