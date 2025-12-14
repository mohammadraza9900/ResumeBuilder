<?php
require_once 'includes/header.php';
?>
    <div class="hero-section text-center py-5 bg-light">
        <h1 class="display-4">Create Your Professional Resume</h1>
        <p class="lead">Build a beautiful resume in minutes with our easy-to-use resume builder</p>
        <div class="mt-4">
            <?php if (!isLoggedIn()): ?>
                <a href="signup.php" class="btn btn-primary btn-lg me-2">Get Started</a>
                <a href="login.php" class="btn btn-outline-primary btn-lg">Login</a>
            <?php else: ?>
                <a href="create-resume.php" class="btn btn-primary btn-lg me-2">Create New Resume</a>
                <a href="my-resumes.php" class="btn btn-outline-primary btn-lg">View My Resumes</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="features-section py-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-file-alt fa-3x text-primary"></i>
                </div>
                <h3>Professional Templates</h3>
                <p>Choose from our collection of professionally designed resume templates.</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-download fa-3x text-primary"></i>
                </div>
                <h3>Easy Download</h3>
                <p>Download your resume as PDF or Word document with just one click.</p>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-icon mb-3">
                    <i class="fas fa-edit fa-3x text-primary"></i>
                </div>
                <h3>Edit Anytime</h3>
                <p>Save your resumes and edit them anytime from your dashboard.</p>
            </div>
        </div>
    </div>
<?php
require_once 'includes/footer.php';
?>