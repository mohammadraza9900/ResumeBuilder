<div class="resume-template template3">
    <div class="resume-header text-center py-4 mb-4 bg-primary text-white">
        <h1 class="mb-2"><?php echo htmlspecialchars($resume_data['personal_info']['name']); ?></h1>
        <div class="contact-info">
            <?php if (!empty($resume_data['personal_info']['email'])): ?>
                <span><i class="fas fa-envelope me-1"></i><?php echo htmlspecialchars($resume_data['personal_info']['email']); ?></span>
            <?php endif; ?>
            <?php if (!empty($resume_data['personal_info']['phone'])): ?>
                <span class="mx-3">|</span>
                <span><i class="fas fa-phone me-1"></i><?php echo htmlspecialchars($resume_data['personal_info']['phone']); ?></span>
            <?php endif; ?>
            <?php if (!empty($resume_data['personal_info']['linkedin'])): ?>
                <span class="mx-3">|</span>
                <span><i class="fab fa-linkedin me-1"></i><?php echo htmlspecialchars($resume_data['personal_info']['linkedin']); ?></span>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <?php if (!empty($resume_data['personal_info']['address'])): ?>
                <div class="resume-section mb-4">
                    <h3 class="section-title">ADDRESS</h3>
                    <div class="section-content">
                        <p><i class="fas fa-map-marker-alt me-2"></i><?php echo htmlspecialchars($resume_data['personal_info']['address']); ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($resume_data['skills'])): ?>
                <div class="resume-section mb-4">
                    <h3 class="section-title">SKILLS</h3>
                    <div class="section-content">
                        <ul class="list-unstyled">
                            <?php foreach ($resume_data['skills'] as $skill): ?>
                                <li class="mb-2">
                                    <span class="skill-name"><?php echo htmlspecialchars($skill['name']); ?></span>
                                    <div class="progress mt-1" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?php 
                                            switch($skill['level']) {
                                                case 'Beginner': echo '25%'; break;
                                                case 'Intermediate': echo '50%'; break;
                                                case 'Advanced': echo '75%'; break;
                                                case 'Expert': echo '100%'; break;
                                                default: echo '50%';
                                            }
                                        ?>"></div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($resume_data['education'])): ?>
                <div class="resume-section">
                    <h3 class="section-title">EDUCATION</h3>
                    <div class="section-content">
                        <?php foreach ($resume_data['education'] as $edu): ?>
                            <div class="education-item mb-3">
                                <h5 class="mb-1"><?php echo htmlspecialchars($edu['degree']); ?></h5>
                                <h6 class="text-muted mb-1"><?php echo htmlspecialchars($edu['institution']); ?></h6>
                                <small class="text-muted d-block mb-1">
                                    <?php echo htmlspecialchars($edu['start_date']); ?> - <?php echo htmlspecialchars($edu['end_date']); ?>
                                </small>
                                <?php if (!empty($edu['description'])): ?>
                                    <p class="small"><?php echo nl2br(htmlspecialchars($edu['description'])); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-8 border-start">
            <?php if (!empty($resume_data['summary'])): ?>
                <div class="resume-section mb-4">
                    <h3 class="section-title">PROFESSIONAL SUMMARY</h3>
                    <div class="section-content">
                        <p><?php echo nl2br(htmlspecialchars($resume_data['summary'])); ?></p>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($resume_data['experience'])): ?>
                <div class="resume-section">
                    <h3 class="section-title">PROFESSIONAL EXPERIENCE</h3>
                    <div class="section-content">
                        <?php foreach ($resume_data['experience'] as $exp): ?>
                            <div class="experience-item mb-4 pb-3 border-bottom">
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-1"><?php echo htmlspecialchars($exp['title']); ?></h5>
                                    <div class="text-muted">
                                        <?php echo htmlspecialchars($exp['start_date']); ?> - <?php echo htmlspecialchars($exp['end_date']); ?>
                                    </div>
                                </div>
                                <h6 class="text-primary mb-2"><?php echo htmlspecialchars($exp['company']); ?></h6>
                                <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>