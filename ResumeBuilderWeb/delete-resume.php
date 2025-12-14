<?php
require_once 'includes/config.php';
require_once 'includes/auth_functions.php';
require_once 'includes/resume_functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resume_id'])) {
    $resume_id = intval($_POST['resume_id']);
    deleteResume($resume_id, $_SESSION['user_id']);
    
    $_SESSION['success'] = "Resume deleted successfully.";
}

header("Location: my-resumes.php");
exit();
?>