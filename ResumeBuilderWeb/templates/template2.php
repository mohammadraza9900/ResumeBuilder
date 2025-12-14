<div class="resume-template template2">
    <div class="resume-header d-flex mb-4">
        <div class="personal-info pe-4">
            <h1 class="mb-3"><?php echo htmlspecialchars($resume_data['personal_info']['name']); ?></h1>
            
            <?php if (!empty($resume_data['summary'])): ?>
                <div class="summary mb-3">
                    <h4 class="section-title">PROFILE</h4>
                    <p><?php echo nl2br(htmlspecialchars($resume_data['summary'])); ?></p>
                </div>
            <?php endif; ?>
            
            <div class="contact-info">
                <h4 class="section-title">CONTACT</h4>
                <ul class="list-unstyled">
                    <?php if (!empty($resume_data['personal_info']['email'])): ?>
                        <li><i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($resume_data['personal_info']['email']); ?></li>
                    <?php endif; ?>
                    <?php if (!empty($resume_data['personal_info']['phone'])): ?>
                        <li><i class="fas fa-phone me-2"></i><?php echo htmlspecialchars($resume_data['personal_info']['phone']); ?></li>
                    <?php endif; ?>
                    <?php if (!empty($resume_data['personal_info']['address'])): ?>
                        <li><i class="fas fa-map-marker-alt me-2"></i><?php echo htmlspecialchars($resume_data['personal_info']['address']); ?></li>
                    <?php endif; ?>
                    <?php if (!empty($resume_data['personal_info']['linkedin'])): ?>
                        <li><i class="fab fa-linkedin me-2"></i><?php echo htmlspecialchars($resume_data['personal_info']['linkedin']); ?></li>
                    <?php endif; ?>
                    <?php if (!empty($resume_data['personal_info']['github'])): ?>
                        <li><i class="fab fa-github me-2"></i><?php echo htmlspecialchars($resume_data['personal_info']['github']); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
            
            <?php if (!empty($resume_data['skills'])): ?>
                <div class="skills mt-4">
                    <h4 class="section-title">SKILLS</h4>
                    <ul class="list-unstyled">
                        <?php foreach ($resume_data['skills'] as $skill): ?>
                            <li>
                                <span class="skill-name"><?php echo htmlspecialchars($skill['name']); ?></span>
                                <span class="skill-level badge bg-primary float-end"><?php echo htmlspecialchars($skill['level']); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="main-content ps-4 border-start">
            <?php if (!empty($resume_data['experience'])): ?>
                <div class="resume-section mb-4">
                    <h3 class="section-title">WORK EXPERIENCE</h3>
                    <div class="section-content">
                        <?php foreach ($resume_data['experience'] as $exp): ?>
                            <div class="experience-item mb-4">
                                <h5 class="mb-1"><?php echo htmlspecialchars($exp['title']); ?></h5>
                                <h6 class="text-muted mb-2"><?php echo htmlspecialchars($exp['company']); ?></h6>
                                <div class="text-muted small mb-2">
                                    <?php echo htmlspecialchars($exp['start_date']); ?> - <?php echo htmlspecialchars($exp['end_date']); ?>
                                </div>
                                <p><?php echo nl2br(htmlspecialchars($exp['description'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($resume_data['education'])): ?>
                <div class="resume-section">
                    <h3 class="section-title">EDUCATION</h3>
                    <div class="section-content">
                        <?php foreach ($resume_data['education'] as $edu): ?>
                            <div class="education-item mb-4">
                                <h5 class="mb-1"><?php echo htmlspecialchars($edu['degree']); ?></h5>
                                <h6 class="text-muted mb-2"><?php echo htmlspecialchars($edu['institution']); ?></h6>
                                <div class="text-muted small mb-2">
                                    <?php echo htmlspecialchars($edu['start_date']); ?> - <?php echo htmlspecialchars($edu['end_date']); ?>
                                </div>
                                <?php if (!empty($edu['description'])): ?>
                                    <p><?php echo nl2br(htmlspecialchars($edu['description'])); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>