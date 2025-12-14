<?php
require_once 'includes/header.php';
require_once 'includes/auth_functions.php';
require_once 'includes/resume_functions.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$resumes = getUserResumes($_SESSION['user_id']);
?>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>My Resumes</h5>
                <a href="create-resume.php" class="btn btn-primary">Create New Resume</a>
            </div>
        </div>
        <div class="card-body">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            
            <?php if ($resumes->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Template</th>
                                <th>Created</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($resume = $resumes->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($resume['title']); ?></td>
                                    <td>Template #<?php echo $resume['template_id']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($resume['created_at'])); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($resume['updated_at'])); ?></td>
                                    <td>
                                        <a href="create-resume.php?edit=<?php echo $resume['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="preview-resume.php?id=<?php echo $resume['id']; ?>" class="btn btn-sm btn-info">Preview</a>
                                        <form method="POST" action="delete-resume.php" class="d-inline">
                                            <input type="hidden" name="resume_id" value="<?php echo $resume['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this resume?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <h5>You haven't created any resumes yet.</h5>
                    <p>Get started by creating your first professional resume.</p>
                    <a href="create-resume.php" class="btn btn-primary">Create Resume</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
require_once 'includes/footer.php';
?>