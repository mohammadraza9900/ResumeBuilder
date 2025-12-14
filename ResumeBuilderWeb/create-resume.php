<?php
include "db/connection.php";
session_start();
?>

<?php
require_once 'includes/header.php';
require_once 'includes/auth_functions.php';
require_once 'includes/resume_functions.php';
require_once 'includes/default_profile.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$title = 'My Resume';
$template_id = 1;
$resume_id = null;
$edit_mode = false;

if (isset($_GET['edit'])) {
    $resume_id = intval($_GET['edit']);
    $resume = getResumeById($resume_id, $_SESSION['user_id']);
    
    if ($resume) {
        $edit_mode = true;
        $title = $resume['title'];
        $template_id = $resume['template_id'];
    }
}

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

if ($edit_mode && isset($resume)) {
    $decoded_data = json_decode($resume['resume_data'], true);
    if (json_last_error() === JSON_ERROR_NONE) {
        $resume_data = array_merge($resume_data, $decoded_data);
    }
} else {
    $resume_data = [
        'personal_info' => [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '+1 (555) 123-4567',
            'address' => 'New York, NY',
            'linkedin' => 'linkedin.com/in/johndoe',
            'github' => 'github.com/johndoe',
            'profile_picture' => getDefaultProfilePicture()
        ],
        'summary' => 'Experienced software developer with a strong background in web development and a passion for creating efficient, scalable solutions. Skilled in multiple programming languages and frameworks, with a track record of delivering high-quality projects on time.',
        'experience' => [
            [
                'title' => 'Senior Software Developer',
                'company' => 'Tech Solutions Inc.',
                'start_date' => '2020-01',
                'end_date' => 'Present',
                'description' => "• Led a team of 5 developers in developing a cloud-based project management system\n• Improved system performance by 40% through code optimization\n• Implemented CI/CD pipeline reducing deployment time by 60%"
            ],
            [
                'title' => 'Software Developer',
                'company' => 'Digital Innovations LLC',
                'start_date' => '2017-06',
                'end_date' => '2019-12',
                'description' => "• Developed and maintained multiple web applications using PHP and JavaScript\n• Collaborated with UX team to improve user interface design\n• Mentored junior developers and conducted code reviews"
            ]
        ],
        'education' => [
            [
                'degree' => 'Bachelor of Science in Computer Science',
                'institution' => 'University of Technology',
                'start_date' => '2013-09',
                'end_date' => '2017-05',
                'description' => 'Major in Software Engineering, Minor in Data Science. GPA: 3.8/4.0'
            ]
        ],
        'skills' => [
            ['name' => 'PHP', 'level' => 'Expert'],
            ['name' => 'JavaScript', 'level' => 'Expert'],
            ['name' => 'HTML/CSS', 'level' => 'Advanced'],
            ['name' => 'MySQL', 'level' => 'Advanced'],
            ['name' => 'Git', 'level' => 'Advanced'],
            ['name' => 'Docker', 'level' => 'Intermediate']
        ]
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $template_id = intval($_POST['template']);

    $submitted_data = isset($_POST['resume_data']) ? $_POST['resume_data'] : '';

    if (is_string($submitted_data) && !empty($submitted_data)) {
        $decoded = json_decode($submitted_data, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $submitted_data = $decoded;
        }
    }
    $processed_data = [
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
    if (isset($submitted_data['personal_info']) && is_array($submitted_data['personal_info'])) {
        foreach ($processed_data['personal_info'] as $key => $default) {
            $processed_data['personal_info'][$key] = isset($submitted_data['personal_info'][$key]) 
                ? trim($submitted_data['personal_info'][$key]) 
                : $default;
        }
    }
    $processed_data['summary'] = isset($submitted_data['summary']) ? trim($submitted_data['summary']) : '';

    if (isset($submitted_data['experience']) && is_array($submitted_data['experience'])) {
        foreach ($submitted_data['experience'] as $exp) {
            if (is_array($exp) && (!empty($exp['title']) || !empty($exp['company']))) {
                $processed_data['experience'][] = [
                    'title' => isset($exp['title']) ? trim($exp['title']) : '',
                    'company' => isset($exp['company']) ? trim($exp['company']) : '',
                    'start_date' => isset($exp['start_date']) ? trim($exp['start_date']) : '',
                    'end_date' => isset($exp['end_date']) ? trim($exp['end_date']) : '',
                    'description' => isset($exp['description']) ? trim($exp['description']) : ''
                ];
            }
        }
    }

    if (isset($submitted_data['education']) && is_array($submitted_data['education'])) {
        foreach ($submitted_data['education'] as $edu) {
            if (is_array($edu) && (!empty($edu['degree']) || !empty($edu['institution']))) {
                $processed_data['education'][] = [
                    'degree' => isset($edu['degree']) ? trim($edu['degree']) : '',
                    'institution' => isset($edu['institution']) ? trim($edu['institution']) : '',
                    'start_date' => isset($edu['start_date']) ? trim($edu['start_date']) : '',
                    'end_date' => isset($edu['end_date']) ? trim($edu['end_date']) : '',
                    'description' => isset($edu['description']) ? trim($edu['description']) : ''
                ];
            }
        }
    }

    if (isset($submitted_data['skills']) && is_array($submitted_data['skills'])) {
        foreach ($submitted_data['skills'] as $skill) {
            if (is_array($skill) && !empty($skill['name'])) {
                $processed_data['skills'][] = [
                    'name' => trim($skill['name']),
                    'level' => isset($skill['level']) ? trim($skill['level']) : 'Intermediate'
                ];
            }
        }
    }

    $resume_data_json = json_encode($processed_data, JSON_UNESCAPED_UNICODE);
    
    if ($edit_mode) {
        if (updateResume($resume_id, $_SESSION['user_id'], $title, $resume_data_json)) {
            $_SESSION['success'] = "Resume updated successfully!";
            header("Location: my-resumes.php");
            exit();
        }
    } else {
        if (createResume($_SESSION['user_id'], $title, $template_id, $resume_data_json)) {
            $_SESSION['success'] = "Resume created successfully!";
            header("Location: my-resumes.php");
            exit();
        }
    }
    
    $error = "An error occurred while saving your resume.";
}
?>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Resume Details</h5>
            </div>
            <div class="card-body">
                <form id="resumeForm" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Resume Title</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo htmlspecialchars($title); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="template" class="form-label">Template</label>
                        <select class="form-select" id="template" name="template" required>
                            <option value="1" <?php echo $template_id == 1 ? 'selected' : ''; ?>>Template 1</option>
                            <option value="2" <?php echo $template_id == 2 ? 'selected' : ''; ?>>Template 2</option>
                            <option value="3" <?php echo $template_id == 3 ? 'selected' : ''; ?>>Template 3</option>
                        </select>
                    </div>
                    <input type="hidden" name="resume_data" id="resumeData">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $edit_mode ? 'Update Resume' : 'Save Resume'; ?>
                        </button>
                    </div>
                </form>
                <div class="mt-3">
                    <button class="btn btn-outline-secondary w-100" id="previewBtn">Preview Resume</button>
                </div>
                <div class="mt-3">
                    <button class="btn btn-outline-success w-100" id="downloadPdfBtn">Download as PDF</button>
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5>Resume Sections</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <button type="button" class="list-group-item list-group-item-action active" data-section="personal_info">Personal Information</button>
                    <button type="button" class="list-group-item list-group-item-action" data-section="summary">Professional Summary</button>
                    <button type="button" class="list-group-item list-group-item-action" data-section="experience">Work Experience</button>
                    <button type="button" class="list-group-item list-group-item-action" data-section="education">Education</button>
                    <button type="button" class="list-group-item list-group-item-action" data-section="skills">Skills</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Edit Resume Content</h5>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div id="sectionForms">
                    <div class="section-form" id="personal_info_form">
                        <h6>Personal Information</h6>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="resume_data[personal_info][name]" 
                                   value="<?php echo htmlspecialchars($resume_data['personal_info']['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="resume_data[personal_info][email]" 
                                   value="<?php echo htmlspecialchars($resume_data['personal_info']['email']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="tel" class="form-control" name="resume_data[personal_info][phone]" 
                                   value="<?php echo htmlspecialchars($resume_data['personal_info']['phone']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="resume_data[personal_info][address]" 
                                   value="<?php echo htmlspecialchars($resume_data['personal_info']['address']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">LinkedIn</label>
                            <input type="url" class="form-control" name="resume_data[personal_info][linkedin]" 
                                   value="<?php echo htmlspecialchars($resume_data['personal_info']['linkedin']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">GitHub</label>
                            <input type="url" class="form-control" name="resume_data[personal_info][github]" 
                                   value="<?php echo htmlspecialchars($resume_data['personal_info']['github']); ?>">
                        </div>
                    </div>

                    <div class="section-form" id="summary_form" style="display:none;">
                        <h6>Professional Summary</h6>
                        <div class="mb-3">
                            <textarea class="form-control" name="resume_data[summary]" rows="5"><?php echo htmlspecialchars($resume_data['summary']); ?></textarea>
                        </div>
                    </div>

                    <div class="section-form" id="experience_form" style="display:none;">
                        <h6>Work Experience</h6>
                        <div id="experienceEntries">
                            <?php foreach ($resume_data['experience'] as $index => $exp): ?>
                                <div class="experience-entry mb-3 border p-3">
                                    <div class="mb-3">
                                        <label class="form-label">Job Title</label>
                                        <input type="text" class="form-control" 
                                               name="resume_data[experience][<?php echo $index; ?>][title]" 
                                               value="<?php echo htmlspecialchars($exp['title']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Company</label>
                                        <input type="text" class="form-control" 
                                               name="resume_data[experience][<?php echo $index; ?>][company]" 
                                               value="<?php echo htmlspecialchars($exp['company']); ?>" required>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Start Date</label>
                                            <input type="month" class="form-control" 
                                                   name="resume_data[experience][<?php echo $index; ?>][start_date]" 
                                                   value="<?php echo htmlspecialchars($exp['start_date']); ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">End Date</label>
                                            <input type="month" class="form-control" 
                                                   name="resume_data[experience][<?php echo $index; ?>][end_date]" 
                                                   value="<?php echo htmlspecialchars($exp['end_date']); ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" 
                                                  name="resume_data[experience][<?php echo $index; ?>][description]" 
                                                  rows="3"><?php echo htmlspecialchars($exp['description']); ?></textarea>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger remove-experience">Remove</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-2" id="addExperience">Add Experience</button>
                    </div>

                    <div class="section-form" id="education_form" style="display:none;">
                        <h6>Education</h6>
                        <div id="educationEntries">
                            <?php foreach ($resume_data['education'] as $index => $edu): ?>
                                <div class="education-entry mb-3 border p-3">
                                    <div class="mb-3">
                                        <label class="form-label">Degree</label>
                                        <input type="text" class="form-control" 
                                               name="resume_data[education][<?php echo $index; ?>][degree]" 
                                               value="<?php echo htmlspecialchars($edu['degree']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Institution</label>
                                        <input type="text" class="form-control" 
                                               name="resume_data[education][<?php echo $index; ?>][institution]" 
                                               value="<?php echo htmlspecialchars($edu['institution']); ?>" required>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Start Date</label>
                                            <input type="month" class="form-control" 
                                                   name="resume_data[education][<?php echo $index; ?>][start_date]" 
                                                   value="<?php echo htmlspecialchars($edu['start_date']); ?>" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">End Date</label>
                                            <input type="month" class="form-control" 
                                                   name="resume_data[education][<?php echo $index; ?>][end_date]" 
                                                   value="<?php echo htmlspecialchars($edu['end_date']); ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" 
                                                  name="resume_data[education][<?php echo $index; ?>][description]" 
                                                  rows="3"><?php echo htmlspecialchars($edu['description']); ?></textarea>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger remove-education">Remove</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-2" id="addEducation">Add Education</button>
                    </div>

                    <div class="section-form" id="skills_form" style="display:none;">
                        <h6>Skills</h6>
                        <div id="skillsEntries">
                            <?php foreach ($resume_data['skills'] as $index => $skill): ?>
                                <div class="skill-entry mb-3 border p-3">
                                    <div class="mb-3">
                                        <label class="form-label">Skill Name</label>
                                        <input type="text" class="form-control" 
                                               name="resume_data[skills][<?php echo $index; ?>][name]" 
                                               value="<?php echo htmlspecialchars($skill['name']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Proficiency</label>
                                        <select class="form-select" name="resume_data[skills][<?php echo $index; ?>][level]">
                                            <option value="Beginner" <?php echo $skill['level'] == 'Beginner' ? 'selected' : ''; ?>>Beginner</option>
                                            <option value="Intermediate" <?php echo $skill['level'] == 'Intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                                            <option value="Advanced" <?php echo $skill['level'] == 'Advanced' ? 'selected' : ''; ?>>Advanced</option>
                                            <option value="Expert" <?php echo $skill['level'] == 'Expert' ? 'selected' : ''; ?>>Expert</option>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger remove-skill">Remove</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-sm btn-primary mt-2" id="addSkill">Add Skill</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Live Preview</h5>
            </div>
            <div class="card-body">
                <div id="livePreview" class="border p-4">
  
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Resume Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="resumePreview" class="p-4">
                   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="downloadFromPreview">Download as PDF</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/main.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded" alt="Profile Picture">`;
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'resume_data[personal_info][profile_picture]';
            hiddenInput.value = e.target.result;
            preview.appendChild(hiddenInput);
            updateLivePreview();
        };
        reader.readAsDataURL(file);
    }
}

function collectFormData() {
    const formData = new FormData(document.getElementById('resumeForm'));
    const resumeData = {
        personal_info: {},
        summary: '',
        experience: [],
        education: [],
        skills: []
    };
    const personalInfoFields = ['name', 'email', 'phone', 'address', 'linkedin', 'github', 'profile_picture'];
    personalInfoFields.forEach(field => {
        const input = document.querySelector(`[name="resume_data[personal_info][${field}]"]`);
        if (input) {
            if (field === 'profile_picture' && input.type === 'file') {
                const hiddenInput = document.querySelector('input[name="resume_data[personal_info][profile_picture]"][type="hidden"]');
                if (hiddenInput) {
                    resumeData.personal_info[field] = hiddenInput.value;
                }
            } else {
                resumeData.personal_info[field] = input.value.trim();
            }
        }
    });
    const summaryInput = document.querySelector('textarea[name="resume_data[summary]"]');
    if (summaryInput) {
        resumeData.summary = summaryInput.value.trim();
    }

    document.querySelectorAll('.experience-entry').forEach(entry => {
        const exp = {
            title: entry.querySelector('[name$="[title]"]')?.value.trim() || '',
            company: entry.querySelector('[name$="[company]"]')?.value.trim() || '',
            start_date: entry.querySelector('[name$="[start_date]"]')?.value.trim() || '',
            end_date: entry.querySelector('[name$="[end_date]"]')?.value.trim() || '',
            description: entry.querySelector('[name$="[description]"]')?.value.trim() || ''
        };
        if (exp.title || exp.company) {
            resumeData.experience.push(exp);
        }
    });
    document.querySelectorAll('.education-entry').forEach(entry => {
        const edu = {
            degree: entry.querySelector('[name$="[degree]"]')?.value.trim() || '',
            institution: entry.querySelector('[name$="[institution]"]')?.value.trim() || '',
            start_date: entry.querySelector('[name$="[start_date]"]')?.value.trim() || '',
            end_date: entry.querySelector('[name$="[end_date]"]')?.value.trim() || '',
            description: entry.querySelector('[name$="[description]"]')?.value.trim() || ''
        };
        if (edu.degree || edu.institution) {
            resumeData.education.push(edu);
        }
    });
    document.querySelectorAll('.skill-entry').forEach(entry => {
        const skill = {
            name: entry.querySelector('[name$="[name]"]')?.value.trim() || '',
            level: entry.querySelector('[name$="[level]"]')?.value || 'Intermediate'
        };
        if (skill.name) {
            resumeData.skills.push(skill);
        }
    });
    
    return resumeData;
}

document.getElementById('resumeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const resumeData = collectFormData();
    document.getElementById('resumeData').value = JSON.stringify(resumeData);
    this.submit();
});
function updateLivePreview() {
    const resumeData = collectFormData();
    fetch('preview-resume.php?template=' + document.getElementById('template').value, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(resumeData)
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('livePreview').innerHTML = html;
    })
    .catch(error => console.error('Error:', error));
}
document.querySelectorAll('input, textarea, select').forEach(element => {
    element.addEventListener('input', updateLivePreview);
    element.addEventListener('change', updateLivePreview);
});
document.getElementById('addExperience').addEventListener('click', function() {
    updateLivePreview();
});
document.getElementById('addEducation').addEventListener('click', function() {
    updateLivePreview();
});
document.getElementById('addSkill').addEventListener('click', function() {
    updateLivePreview();
});
document.addEventListener('click', function(e) {
    if (e.target.matches('.remove-experience, .remove-education, .remove-skill')) {
        e.target.closest('.experience-entry, .education-entry, .skill-entry').remove();
        updateLivePreview();
    }
});
updateLivePreview();
document.getElementById('previewBtn').addEventListener('click', function() {
    const resumeData = collectFormData();
    const template = document.getElementById('template').value;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'preview-resume.php?template=' + template;
    form.target = '_blank';
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'resume_data';
    input.value = JSON.stringify(resumeData);
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
});
document.getElementById('downloadPdfBtn').addEventListener('click', function() {
    const element = document.getElementById('livePreview');
    const opt = {
        margin: 10,
        filename: document.getElementById('title').value + '.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };
    
    html2pdf().from(element).set(opt).save();
});
</script>
<?php
require_once 'includes/footer.php';
?>