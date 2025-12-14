<?php
require_once 'includes/header.php';
require_once 'includes/auth_functions.php';
require_once 'includes/resume_functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}
?>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h5>
                    <p class="card-text">Create, edit and download your professional resumes.</p>
                    <a href="create-resume.php" class="btn btn-primary">Create New Resume</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Resumes</h5>
                </div>
                <div class="card-body">
                    <?php
                    $resumes = getUserResumes($_SESSION['user_id']);
                    if ($resumes->num_rows > 0): ?>
                        <div class="list-group">
                            <?php while ($resume = $resumes->fetch_assoc()): ?>
                                <a href="create-resume.php?edit=<?php echo $resume['id']; ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($resume['title']); ?></h6>
                                        <small>Template #<?php echo $resume['template_id']; ?></small>
                                    </div>
                                    <small>Last updated: <?php echo date('M d, Y', strtotime($resume['updated_at'])); ?></small>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p>You haven't created any resumes yet. <a href="create-resume.php">Create your first resume now!</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php
require_once 'includes/footer.php';
?>