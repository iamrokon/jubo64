<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - Download</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .cv-header {
            text-align: center;
            border-bottom: 3px solid #015e41;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .cv-header h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 10px;
        }

        .cv-header .subheader {
            font-size: 14px;
            color: #666;
            font-weight: 500;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            background-color: #015e41;
            color: white;
            padding: 12px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .field {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 15px;
            margin-bottom: 12px;
            font-size: 13px;
            line-height: 1.6;
            padding-bottom: 8px;
            border-bottom: 1px solid #f0f0f0;
        }

        .field-label {
            font-weight: 600;
            color: #333;
        }

        .field-value {
            color: #555;
            word-break: break-word;
        }

        .action-buttons {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: #015e41;
            color: white;
        }

        .btn-primary:hover {
            background-color: #013d2a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(1, 94, 65, 0.3);
        }

        .btn-secondary {
            background-color: #667eea;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            .container {
                box-shadow: none;
                padding: 0;
            }
            .action-buttons {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            .cv-header h1 {
                font-size: 24px;
            }
            .field {
                grid-template-columns: 1fr;
                gap: 5px;
            }
            .field-label::after {
                content: ":";
            }
        }
    </style>
</head>
<body>

<?php
// Include session and database connection
include "session.php";

// Check if student ID is provided
if(!isset($_GET['student_id']) || empty($_GET['student_id'])) {
    die("Student ID is required.");
}

$student_id = $_GET['student_id'];

// Fetch student data using mysqli
$eq_stmt = mysqli_query($con, "SELECT * FROM student_list LEFT JOIN district ON district.id=student_list.district WHERE student_list.student_id='".$student_id."'");
$student_data = mysqli_fetch_array($eq_stmt);

if(!$student_data) {
    die("Student not found.");
}

// Extract student data
extract($student_data);
?>

<div class="container">
    
    <!-- Header -->
    <div class="cv-header">
        <h1><?php echo htmlspecialchars($stu_name); ?></h1>
        <div class="subheader">
            District: <?php echo htmlspecialchars($dist_name); ?> | Batch: <?php echo htmlspecialchars($batch_id); ?>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="section">
        <div class="section-title">📞 CONTACT INFORMATION</div>
        <div class="field">
            <div class="field-label">Phone</div>
            <div class="field-value"><?php echo htmlspecialchars($contact); ?></div>
        </div>
        <div class="field">
            <div class="field-label">Email</div>
            <div class="field-value"><?php echo htmlspecialchars($email); ?></div>
        </div>
    </div>

    <!-- Objective -->
    <div class="section">
        <div class="section-title">🎯 PROFESSIONAL OBJECTIVE</div>
        <div class="field">
            <div class="field-value"><?php echo htmlspecialchars($about); ?></div>
        </div>
    </div>

    <!-- Education -->
    <div class="section">
        <div class="section-title">🎓 EDUCATIONAL QUALIFICATION</div>
        <div class="field">
            <div class="field-label">Academic</div>
            <div class="field-value"><?php echo htmlspecialchars($edu_qual); ?></div>
        </div>
        <div class="field">
            <div class="field-label">Passing Year</div>
            <div class="field-value"><?php echo htmlspecialchars($pass_year); ?></div>
        </div>
    </div>

    <!-- Work Experience -->
    <div class="section">
        <div class="section-title">💼 WORK EXPERIENCE</div>
        <div class="field">
            <div class="field-value"><?php echo htmlspecialchars($work); ?></div>
        </div>
    </div>

    <!-- Personal Details -->
    <div class="section">
        <div class="section-title">👤 PERSONAL DETAILS</div>
        <div class="field">
            <div class="field-label">Age</div>
            <div class="field-value"><?php echo htmlspecialchars($age); ?></div>
        </div>
        <div class="field">
            <div class="field-label">Profession</div>
            <div class="field-value"><?php echo htmlspecialchars($profession); ?></div>
        </div>
        <div class="field">
            <div class="field-label">Father Name</div>
            <div class="field-value"><?php echo htmlspecialchars($father_name); ?></div>
        </div>
        <div class="field">
            <div class="field-label">Mother Name</div>
            <div class="field-value"><?php echo htmlspecialchars($mother_name); ?></div>
        </div>
        <div class="field">
            <div class="field-label">Religion</div>
            <div class="field-value"><?php echo htmlspecialchars($religion); ?></div>
        </div>
        <div class="field">
            <div class="field-label">Blood Group</div>
            <div class="field-value"><?php echo htmlspecialchars($blood_grp); ?></div>
        </div>
        <div class="field">
            <div class="field-label">Address</div>
            <div class="field-value"><?php echo htmlspecialchars($address); ?></div>
        </div>
    </div>

    <!-- Other Information -->
    <div class="section">
        <div class="section-title">📋 OTHER INFORMATION</div>
        <div class="field">
            <div class="field-label">NID/Birth Cert No</div>
            <div class="field-value"><?php echo htmlspecialchars($nid_no); ?></div>
        </div>
        <div class="field">
            <div class="field-label">Have Computer</div>
            <div class="field-value"><?php echo htmlspecialchars($computer); ?></div>
        </div>
        <div class="field">
            <div class="field-label">Disabilities</div>
            <div class="field-value"><?php echo htmlspecialchars($disabilities); ?></div>
        </div>
    </div>

    <!-- Freelancing Profiles -->
    <div class="section">
        <div class="section-title">🌐 FREELANCING PROFILES</div>
        <?php
        if(!empty($linked_in) && $linked_in != 'none') {
            echo '<div class="field">
                    <div class="field-label">LinkedIn</div>
                    <div class="field-value"><a href="'.htmlspecialchars($linked_in).'" target="_blank">'.htmlspecialchars($linked_in).'</a></div>
                  </div>';
        }
        if(!empty($upwork) && $upwork != 'none') {
            echo '<div class="field">
                    <div class="field-label">Upwork</div>
                    <div class="field-value"><a href="'.htmlspecialchars($upwork).'" target="_blank">'.htmlspecialchars($upwork).'</a></div>
                  </div>';
        }
        if(!empty($fiver) && $fiver != 'none') {
            echo '<div class="field">
                    <div class="field-label">Fiverr</div>
                    <div class="field-value"><a href="'.htmlspecialchars($fiver).'" target="_blank">'.htmlspecialchars($fiver).'</a></div>
                  </div>';
        }
        if(!empty($link_three) && $link_three != 'none') {
            echo '<div class="field">
                    <div class="field-label">Link 3</div>
                    <div class="field-value"><a href="'.htmlspecialchars($link_three).'" target="_blank">'.htmlspecialchars($link_three).'</a></div>
                  </div>';
        }
        if(!empty($link_four) && $link_four != 'none') {
            echo '<div class="field">
                    <div class="field-label">Link 4</div>
                    <div class="field-value"><a href="'.htmlspecialchars($link_four).'" target="_blank">'.htmlspecialchars($link_four).'</a></div>
                  </div>';
        }
        ?>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fa fa-download"></i> Save as PDF
        </button>
        <a href="student-cv.php?view=<?php echo htmlspecialchars($student_id); ?>" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

</div>

<script>
    // Auto-focus for printing
    window.addEventListener('afterprint', function() {
        window.history.back();
    });
</script>

</body>
</html>
