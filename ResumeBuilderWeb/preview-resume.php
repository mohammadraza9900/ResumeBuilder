<?php
require_once 'includes/config.php';
require_once 'includes/auth_functions.php';
require_once 'includes/resume_functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

if ($isAjax) {
    $json = file_get_contents('php://input');
    $resume_data = json_decode($json, true);
    $template_id = isset($_GET['template']) ? intval($_GET['template']) : 1;
} 
else {
    if (!isset($_GET['id'])) {
        header("Location: my-resumes.php");
        exit();
    }

    $resume_id = intval($_GET['id']);
    $resume = getResumeById($resume_id, $_SESSION['user_id']);

    if (!$resume) {
        header("Location: my-resumes.php");
        exit();
    }
    $resume_data = json_decode($resume['resume_data'], true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Error decoding resume data: " . json_last_error_msg());
    }
    $template_id = $resume['template_id'];
}
if (!is_array($resume_data)) {
    $resume_data = [
        'personal_info' => [
            'name' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
            'linkedin' => '',
            'github' => '',
            'profile_picture' => ''
        ],
        'summary' => '',
        'experience' => [],
        'education' => [],
        'skills' => []
    ];
}

if ($isAjax) {
    $template_file = "templates/template{$template_id}.php";
    if (file_exists($template_file)) {
        include $template_file;
    } else {
        echo "<div class='alert alert-danger'>Template file not found.</div>";
    }
} 
else {
    require_once 'includes/header.php';
    ?>
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Preview Resume: <?php echo htmlspecialchars($resume['title']); ?></h5>
                <div>
                    <button class="btn btn-primary" id="downloadPdfBtn">Download as PDF</button>
                    <a href="create-resume.php?edit=<?php echo $resume['id']; ?>" class="btn btn-secondary">Edit Resume</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="resumePreview" class="p-4">
                <?php 
                $template_file = "templates/template{$template_id}.php";
                if (file_exists($template_file)) {
                    include $template_file;
                } else {
                    echo "<div class='alert alert-danger'>Template file not found.</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
    document.getElementById('downloadPdfBtn').addEventListener('click', function() {
        const element = document.getElementById('resumePreview');
        const opt = {
            margin: 10,
            filename: '<?php echo htmlspecialchars($resume['title']); ?>.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        
        html2pdf().from(element).set(opt).save();
    });
    </script>

    <?php
    require_once 'includes/footer.php';
}
?>