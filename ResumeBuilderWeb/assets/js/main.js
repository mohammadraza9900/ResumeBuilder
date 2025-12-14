document.addEventListener('DOMContentLoaded', function() {
    // Section navigation
    const sectionButtons = document.querySelectorAll('[data-section]');
    const sectionForms = document.querySelectorAll('.section-form');
    
    sectionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const section = this.getAttribute('data-section');
            
            // Hide all forms
            sectionForms.forEach(form => {
                form.style.display = 'none';
            });
            
            // Show selected form
            document.getElementById(`${section}_form`).style.display = 'block';
            
            // Update active button
            sectionButtons.forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
    
    // Show personal info by default
    if (sectionButtons.length > 0) {
        sectionButtons[0].click();
    }
    
    // Add experience entry
    const addExperienceBtn = document.getElementById('addExperience');
    const experienceEntries = document.getElementById('experienceEntries');
    
    if (addExperienceBtn) {
        addExperienceBtn.addEventListener('click', function() {
            const index = experienceEntries.children.length;
            const html = `
                <div class="experience-entry mb-3 border p-3">
                    <div class="mb-3">
                        <label class="form-label">Job Title</label>
                        <input type="text" class="form-control" name="resume_data[experience][${index}][title]" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company</label>
                        <input type="text" class="form-control" name="resume_data[experience][${index}][company]" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="month" class="form-control" name="resume_data[experience][${index}][start_date]" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="month" class="form-control" name="resume_data[experience][${index}][end_date]">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="resume_data[experience][${index}][description]" rows="3"></textarea>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger remove-experience">Remove</button>
                </div>
            `;
            experienceEntries.insertAdjacentHTML('beforeend', html);
        });
    }
    
    // Remove experience entry
    experienceEntries.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-experience')) {
            e.target.closest('.experience-entry').remove();
        }
    });
    
    // Add education entry
    const addEducationBtn = document.getElementById('addEducation');
    const educationEntries = document.getElementById('educationEntries');
    
    if (addEducationBtn) {
        addEducationBtn.addEventListener('click', function() {
            const index = educationEntries.children.length;
            const html = `
                <div class="education-entry mb-3 border p-3">
                    <div class="mb-3">
                        <label class="form-label">Degree</label>
                        <input type="text" class="form-control" name="resume_data[education][${index}][degree]" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Institution</label>
                        <input type="text" class="form-control" name="resume_data[education][${index}][institution]" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="month" class="form-control" name="resume_data[education][${index}][start_date]" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="month" class="form-control" name="resume_data[education][${index}][end_date]">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="resume_data[education][${index}][description]" rows="3"></textarea>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger remove-education">Remove</button>
                </div>
            `;
            educationEntries.insertAdjacentHTML('beforeend', html);
        });
    }
    
    // Remove education entry
    educationEntries.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-education')) {
            e.target.closest('.education-entry').remove();
        }
    });
    
    // Add skill entry
    const addSkillBtn = document.getElementById('addSkill');
    const skillsEntries = document.getElementById('skillsEntries');
    
    if (addSkillBtn) {
        addSkillBtn.addEventListener('click', function() {
            const index = skillsEntries.children.length;
            const html = `
                <div class="skill-entry mb-3 border p-3">
                    <div class="mb-3">
                        <label class="form-label">Skill Name</label>
                        <input type="text" class="form-control" name="resume_data[skills][${index}][name]" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Proficiency</label>
                        <select class="form-select" name="resume_data[skills][${index}][level]">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger remove-skill">Remove</button>
                </div>
            `;
            skillsEntries.insertAdjacentHTML('beforeend', html);
        });
    }
    
    // Remove skill entry
    skillsEntries.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-skill')) {
            e.target.closest('.skill-entry').remove();
        }
    });
    
    // Preview resume
    const previewBtn = document.getElementById('previewBtn');
    const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
    const resumeForm = document.getElementById('resumeForm');
    const resumePreview = document.getElementById('resumePreview');
    const resumeDataInput = document.getElementById('resumeData');
    
    if (previewBtn) {
        previewBtn.addEventListener('click', function() {
            // Serialize form data
            const formData = new FormData(resumeForm);
            const resumeData = {};
            
            for (let [key, value] of formData.entries()) {
                if (key.startsWith('resume_data')) {
                    const keys = key.match(/\[(.*?)\]/g).map(k => k.replace(/[\[\]]/g, ''));
                    let current = resumeData;
                    
                    for (let i = 0; i < keys.length; i++) {
                        if (i === keys.length - 1) {
                            current[keys[i]] = value;
                        } else {
                            if (!current[keys[i]]) {
                                current[keys[i]] = isNaN(keys[i+1]) ? {} : [];
                            }
                            current = current[keys[i]];
                        }
                    }
                }
            }
            
            // Store serialized data in hidden input
            resumeDataInput.value = JSON.stringify(resumeData);
            
            // Load appropriate template
            const templateId = document.getElementById('template').value;
            
            // Create a temporary form to submit to the template
            const tempForm = document.createElement('form');
            tempForm.method = 'POST';
            tempForm.action = `templates/template${templateId}.php`;
            tempForm.style.display = 'none';
            
            const tempInput = document.createElement('input');
            tempInput.type = 'hidden';
            tempInput.name = 'resume_data';
            tempInput.value = JSON.stringify(resumeData);
            
            tempForm.appendChild(tempInput);
            document.body.appendChild(tempForm);
            
            // Submit the form and get the response
            fetch(tempForm.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `resume_data=${encodeURIComponent(JSON.stringify(resumeData))}`
            })
            .then(response => response.text())
            .then(html => {
                resumePreview.innerHTML = html;
                previewModal.show();
            })
            .catch(error => {
                console.error('Error:', error);
                resumePreview.innerHTML = '<div class="alert alert-danger">Error loading preview. Please try again.</div>';
                previewModal.show();
            })
            .finally(() => {
                document.body.removeChild(tempForm);
            });
        });
    }
    
    // Download PDF from preview
    const downloadFromPreview = document.getElementById('downloadFromPreview');
    if (downloadFromPreview) {
        downloadFromPreview.addEventListener('click', function() {
            const element = document.getElementById('resumePreview');
            const title = document.getElementById('title').value || 'resume';
            const opt = {
                margin: 10,
                filename: `${title}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            
            html2pdf().from(element).set(opt).save();
        });
    }
    
    // Download PDF directly
    const downloadPdfBtn = document.getElementById('downloadPdfBtn');
    if (downloadPdfBtn) {
        downloadPdfBtn.addEventListener('click', function() {
            // Trigger the preview first to ensure data is updated
            if (previewBtn) previewBtn.click();
            
            // Then after a short delay, trigger the download
            setTimeout(() => {
                if (downloadFromPreview) downloadFromPreview.click();
            }, 500);
        });
    }
});