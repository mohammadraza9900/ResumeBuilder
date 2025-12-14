<div class="resume-template template1">
    <div class="resume-header text-center mb-4">
        <?php if (!empty($resume_data['personal_info']['profile_picture'])): ?>
            <div class="profile-picture mb-3">
                <img src="<?php echo htmlspecialchars($resume_data['personal_info']['profile_picture']); ?>" 
                     class="rounded-circle" alt="Profile Picture" 
                     style="width: 150px; height: 150px; object-fit: cover;">
            </div>
        <?php endif; ?>
        <h1><?php echo !empty($resume_data['personal_info']['name']) ? htmlspecialchars($resume_data['personal_info']['name']) : 'Your Name'; ?></h1>
        <div class="contact-info">
            <?php if (!empty($resume_data['personal_info']['email'])): ?>
                <span><?php echo htmlspecialchars($resume_data['personal_info']['email']); ?></span>
            <?php endif; ?>
            <?php if (!empty($resume_data['personal_info']['phone'])): ?>
                <span> | <?php echo htmlspecialchars($resume_data['personal_info']['phone']); ?></span>
            <?php endif; ?>
            <?php if (!empty($resume_data['personal_info']['address'])): ?>
                <span> | <?php echo htmlspecialchars($resume_data['personal_info']['address']); ?></span>
            <?php endif; ?>
        </div>
        <?php if (!empty($resume_data['personal_info']['linkedin']) || !empty($resume_data['personal_info']['github'])): ?>
            <div class="social-links mt-2">
                <?php if (!empty($resume_data['personal_info']['linkedin'])): ?>
                    <span>LinkedIn: <?php echo htmlspecialchars($resume_data['personal_info']['linkedin']); ?></span>
                <?php endif; ?>
                <?php if (!empty($resume_data['personal_info']['github'])): ?>
                    <span> | GitHub: <?php echo htmlspecialchars($resume_data['personal_info']['github']); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if (!empty($resume_data['summary'])): ?>
        <div class="resume-section mb-4">
            <h3 class="section-title">SUMMARY</h3>
            <div class="section-content">
                <p><?php echo nl2br(htmlspecialchars($resume_data['summary'])); ?></p>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($resume_data['experience'])): ?>
        <div class="resume-section mb-4">
            <h3 class="section-title">EXPERIENCE</h3>
            <div class="section-content">
                <?php foreach ($resume_data['experience'] as $exp): ?>
                    <?php if (!empty($exp['title']) || !empty($exp['company'])): ?>
                        <div class="experience-item mb-3">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-1"><?php echo !empty($exp['title']) ? htmlspecialchars($exp['title']) : ''; ?></h5>
                                <div class="text-muted">
                                    <?php echo !empty($exp['start_date']) ? htmlspecialchars($exp['start_date']) : ''; ?>
                                    <?php echo (!empty($exp['start_date']) && !empty($exp['end_date'])) ? ' - ' : ''; ?>
                                    <?php echo !empty($exp['end_date']) ? htmlspecialchars($exp['end_date']) : ''; ?>
                                </div>
                            </div>
                            <?php if (!empty($exp['company'])): ?>
                                <h6 class="text-muted mb-2"><?php echo htmlspecialchars($exp['company']); ?></h6>
                            <?php endif; ?>
                            <?php if (!empty($exp['description'])): ?>
                                <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($resume_data['education'])): ?>
        <div class="resume-section mb-4">
            <h3 class="section-title">EDUCATION</h3>
            <div class="section-content">
                <?php foreach ($resume_data['education'] as $edu): ?>
                    <?php if (!empty($edu['degree']) || !empty($edu['institution'])): ?>
                        <div class="education-item mb-3">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-1"><?php echo !empty($edu['degree']) ? htmlspecialchars($edu['degree']) : ''; ?></h5>
                                <div class="text-muted">
                                    <?php echo !empty($edu['start_date']) ? htmlspecialchars($edu['start_date']) : ''; ?>
                                    <?php echo (!empty($edu['start_date']) && !empty($edu['end_date'])) ? ' - ' : ''; ?>
                                    <?php echo !empty($edu['end_date']) ? htmlspecialchars($edu['end_date']) : ''; ?>
                                </div>
                            </div>
                            <?php if (!empty($edu['institution'])): ?>
                                <h6 class="text-muted mb-2"><?php echo htmlspecialchars($edu['institution']); ?></h6>
                            <?php endif; ?>
                            <?php if (!empty($edu['description'])): ?>
                                <p><?php echo nl2br(htmlspecialchars($edu['description'])); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($resume_data['skills'])): ?>
        <div class="resume-section">
            <h3 class="section-title">SKILLS</h3>
            <div class="section-content">
                <div class="row">
                    <?php foreach ($resume_data['skills'] as $skill): ?>
                        <?php if (!empty($skill['name'])): ?>
                            <div class="col-md-4 mb-2">
                                <div class="skill-item">
                                    <strong><?php echo htmlspecialchars($skill['name']); ?></strong>
                                    <div class="progress mt-1">
                                        <div class="progress-bar" role="progressbar" style="width: <?php 
                                            if (!empty($skill['level'])) {
                                                switch($skill['level']) {
                                                    case 'Beginner': echo '25%'; break;
                                                    case 'Intermediate': echo '50%'; break;
                                                    case 'Advanced': echo '75%'; break;
                                                    case 'Expert': echo '100%'; break;
                                                    default: echo '50%';
                                                }
                                            } else {
                                                echo '50%';
                                            }
                                        ?>"></div>
                                    </div>
                                    <small class="text-muted"><?php echo !empty($skill['level']) ? htmlspecialchars($skill['level']) : 'Intermediate'; ?></small>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>