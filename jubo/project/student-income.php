<?php
include('session.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>শিক্ষিত কর্মপ্রত্যাশি যুবদের ফ্রিল্যান্সিং প্রশিক্ষণের মাধ্যমে কর্মসংস্থান সৃষ্টি - E-Learning & Earning LTD</title>
  <?php include('link.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { background: #f4f4f9 !important; font-family: 'Poppins', sans-serif !important; margin: 120px !important; }
    .profile-card p, .profile-card h5 { text-align: justify; color: #002058 !important; }
    .summary-icon i { font-size: 48px; color: #169E43; }
    .profile-card { background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); }
    .dashboard-card { background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
    table th, table td { text-align: center; vertical-align: middle; }

    /* Profile Image Gradient Border + Animation */
    .profile-img-wrapper { position: relative; display: inline-block; border-radius: 50%; padding: 5px; background: linear-gradient(135deg, #169E3F, #4CAF50); }
    .profile-img-wrapper img { display: block; border-radius: 50%; width: 160px; height: 160px; background: #fff; border: 4px solid #fff; transition: transform 0.3s ease, box-shadow 0.3s ease; animation: pulse 3s infinite; }
    .profile-img-wrapper:hover img { transform: scale(1.05); box-shadow: 0 8px 20px rgba(0,0,0,0.3); }
    @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(22,158,67,0.4); } 70% { box-shadow: 0 0 0 15px rgba(22,158,67,0); } 100% { box-shadow: 0 0 0 0 rgba(22,158,67,0); } }

    /* Progress Bar Gradient */
    .progress-bar { background: linear-gradient(90deg, #169E3F, #4CAF50); }
  </style>
</head>
<body>
<?php include('header.php'); ?>

<?php
if (isset($_GET['income_id']) && !empty($_GET['income_id'])) {
    $student_id = $_GET['income_id'];
    $stmt_edit = $DB_con->prepare('SELECT * FROM student_list 
      LEFT JOIN district ON district.id = student_list.district 
      LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id 
      LEFT JOIN group_list ON group_list.group_id = student_list.group_id 
      WHERE student_list.student_id = :uid');
    $stmt_edit->execute([':uid' => $student_id]);
    $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
    extract($edit_row);

      // Check if the 'incomePics' column contains any data
  if (!empty($incomePics)) {
    $images = explode(',', $incomePics);  // Split the comma-separated image paths






  }
}

// Profile Completion
$totalFields = 9; // 8 profile fields + earnings record
$fieldsCompleted = 0;

// Profile picture must exist and file must be available
if (!empty($userPic) && file_exists("../stu-info/user_images/" . $userPic)) $fieldsCompleted++;
if (!empty($nid_no)) $fieldsCompleted++;
if (!empty($contact)) $fieldsCompleted++;
if (!empty($email)) $fieldsCompleted++;
if (!empty($dist_name)) $fieldsCompleted++;
if (!empty($batch_name)) $fieldsCompleted++;
if (!empty($group_name)) $fieldsCompleted++;
if (!empty($about)) $fieldsCompleted++;

// Earnings check
$stmt = $DB_con->prepare("SELECT COUNT(*) FROM income_info WHERE student_id = ?");
$stmt->execute([$student_id]);
if ($stmt->fetchColumn() > 0) $fieldsCompleted++;

$profileCompletion = round(($fieldsCompleted / $totalFields) * 100);



// Monthly Earnings Data
$stmt = $DB_con->prepare("
  SELECT DATE_FORMAT(earning_date, '%b') AS month,
         SUM(earning_dollar) AS total_dollar,
         SUM(earning_bd) AS total_bd
  FROM income_info
  WHERE student_id = ?
  GROUP BY DATE_FORMAT(earning_date, '%Y-%m')
  ORDER BY earning_date ASC
");
$stmt->execute([$student_id]);
$months = $dollars = $bdts = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $months[] = $row['month'];
    $dollars[] = $row['total_dollar'];
    $bdts[] = $row['total_bd'];
}

// Yearly Earnings Data
$stmt = $DB_con->prepare("
  SELECT DATE_FORMAT(earning_date, '%Y') AS year,
         SUM(earning_dollar) AS total_dollar,
         SUM(earning_bd) AS total_bd
  FROM income_info
  WHERE student_id = ?
  GROUP BY DATE_FORMAT(earning_date, '%Y')
  ORDER BY earning_date ASC
");
$stmt->execute([$student_id]);
$years = $yearlyDollars = $yearlyBdts = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $years[] = $row['year'];
    $yearlyDollars[] = $row['total_dollar'];
    $yearlyBdts[] = $row['total_bd'];
}
?>

<div class="container mt-5">
  <div class="row">
    <!-- Profile Card -->
    <div class="col-md-4">
      <div class="profile-card text-center">
        <div class="profile-img-wrapper mb-3">
          <?php if (!empty($userPic)) : ?>
            <img src="../stu-info/user_images/<?php echo $userPic; ?>" alt="Profile Image">
          <?php else : ?>
            <img src="https://picsum.photos/id/237/200/300" alt="Profile Image">
          <?php endif; ?>
        </div>
        <h4><?= $stu_name; ?></h4>
        <p style="text-align: center;"><strong>Student ID:</strong> <?= $student_id; ?></p>
        <h5 class="mt-3">About</h5>
        <p><?= !empty($about) ? $about : 'No About Info'; ?></p>
        <p><strong>NID:</strong> <?= $nid_no; ?></p>
        <p><strong>Contact:</strong> <?= $contact; ?></p>
        <p><strong>Email:</strong> <?= $email; ?></p>
        <p><strong>District:</strong> <?= $dist_name; ?></p>
        <p><strong>Batch:</strong> <?= $batch_name; ?></p>
        <p><strong>Group:</strong> <?= $group_name; ?></p>
        <h5 class="mt-4">Profile Completion</h5>
        <div class="progress mb-2">
          <div class="progress-bar" id="profileProgress" role="progressbar"
               aria-valuenow="<?= $profileCompletion ?>" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <p><?= $profileCompletion; ?>% Complete</p>
      </div>
    </div>

    <!-- Right Side (Summary & Chart) -->
    <div class="col-lg-8">
      <h4>Earnings Summary</h4>
      <div class="row mb-4">
        <div class="col-md-6">
          <div class="dashboard-card text-center">
            <div class="summary-icon"><i class="fas fa-dollar-sign"></i></div>
            <h4>
              <?php
              $stmt = $DB_con->prepare("SELECT SUM(earning_dollar) FROM income_info WHERE student_id = ?");
              $stmt->execute([$student_id]);
              echo "$".number_format($stmt->fetchColumn(),2);
              ?>
            </h4>
            <p>Total Dollar Earnings</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="dashboard-card text-center">
            <div class="summary-icon"><i class="fas fa-coins"></i></div>
            <h4>
              <?php
              $stmt = $DB_con->prepare("SELECT SUM(earning_bd) FROM income_info WHERE student_id = ?");
              $stmt->execute([$student_id]);
              echo "৳".number_format($stmt->fetchColumn(),2);
              ?>
            </h4>
            <p>Total BDT Earnings</p>
          </div>
        </div>
      </div>

      <!-- Monthly/Yearly Chart -->
      <div class="dashboard-card mb-4">
        <div class="d-flex justify-content-between">
            <h4 class="mb-3">Earnings Chart</h4>
            <select id="chartType" class="form-select w-auto">
              <option value="monthly" selected>Monthly</option>
              <option value="yearly">Yearly</option>
            </select>
        </div>
        <canvas id="earningsChart" height="120"></canvas>
      </div>
    </div>
  </div>

  <!-- Full Page Earnings Records -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="dashboard-card">
        <h4>Earning Records</h4><hr>
        <div class="table-responsive">
          <table class="table table-bordered table-striped text-center align-middle" style="white-space: nowrap;">
            <thead class="table-dark">
              <tr>
                <th>Date</th><th>Job</th><th>Platform</th><th>Payment</th><th>$</th><th>৳</th><th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $stmt = $DB_con->prepare("
              SELECT earning_date, earning_dollar, earning_bd, incomePics,
                     jobs.job_name, work_source.work_name, payment_method.payment_name 
              FROM income_info 
              LEFT JOIN jobs ON jobs.j_id = income_info.job_id
              LEFT JOIN work_source ON work_source.ws_id = income_info.work_source
              LEFT JOIN payment_method ON payment_method.pm_id = income_info.payment_type
              WHERE student_id = ?
              ORDER BY earning_date DESC
            ");
            $stmt->execute([$student_id]);
           while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo "<tr>
          <td>{$row['earning_date']}</td>
          <td>{$row['job_name']}</td>
          <td>{$row['work_name']}</td>
          <td>{$row['payment_name']}</td>
          <td>$" . number_format($row['earning_dollar'], 2) . "</td>
          <td>৳" . number_format($row['earning_bd'], 2) . "</td>
          <td width='8%'>
            <div class='text-center d-flex align-items-center'>";

$images = explode(",", $row['incomePics']);
                      foreach ($images as $index => $image) {
                        $imgSrc = $image == null ? 'website/favicon.png' : $image;
                        echo "
        <img src='$imgSrc' alt='Image' class='img-fluid img-thumbnail m-1 preview-thumb' 
             style='width:30px;height:30px;'";
                      }



  echo "</div>
        </td>
      </tr>";
}

            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Attendance Information -->
  <div class="row mt-4 d-none">
    <div class="col-12">
      <div class="dashboard-card">
        <h4>Attendance Information</h4><hr>
        
        <?php
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
        $end_date_att = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
        
        // Use student_id (numeric) or stu_user_id depending on table schema
        // In attendance-student-view.php we used stu_user_id. 
        // student-income.php gets "student_id" from $_GET['income_id']. 
        // Let's verify if $_GET['income_id'] matches 'student_id' column or 'stu_user_id' in 'student_list'
        // In line 40: WHERE student_list.student_id = :uid
        // So $student_id here is indeed student_list.student_id
        
        // We need to fetch 'stu_user_id' for attendance query if attendance uses it
        // Or if attendance.student_id links to student_list.student_id?
        // Checking category-card.php step 30: "attendance.student_id links to student_list.stu_user_id"
        // So we need to get stu_user_id from the $edit_row (extracted)
        
        // Variable $stu_user_id should be available since we did extract($edit_row) and SELECT * from student_list
        $attendance_student_id = isset($stu_user_id) ? $stu_user_id : $student_id; 

        // Calculate Stats
        $start = strtotime($start_date);
        $end = strtotime($end_date_att);
        $total_days = round(($end - $start) / (60 * 60 * 24)) + 1;
        
        $attMap = [];
        // Note: adjust connection variable if needed ($con or $DB_con). 
        // $DB_con is PDO. $con is mysqli (from link.php usually). 
        // student-income.php uses $DB_con (PDO). 
        // Let's use PDO.
        
        $stmt_att = $DB_con->prepare("SELECT * FROM attendance WHERE student_id = ? AND att_date BETWEEN ? AND ? ORDER BY att_date DESC");
        $stmt_att->execute([$attendance_student_id, $start_date, $end_date_att]);
        $attendance_records = $stmt_att->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($attendance_records as $row){
             $attMap[$row['att_date']] = $row;
        }
        
        $total_present = count($attMap);
        $total_absent = $total_days - $total_present;
        ?>

        <div class="row mb-3">
            <div class="col-md-8">
                 <div class="">
                    <span class="badge bg-primary text-white p-2">Total: <?= $total_days ?> Days</span>
                    <span class="badge bg-success text-white p-2">Present: <?= $total_present ?> Days</span>
                    <span class="badge bg-danger text-white p-2">Absent: <?= $total_absent ?> Days</span>
                    <span class="text-muted ms-2">(<?= date('d M Y', strtotime($start_date)) ?> - <?= date('d M Y', strtotime($end_date_att)) ?>)</span>
                </div>
            </div>
            <div class="col-md-4">
                <form method="GET" action="">
                    <input type="hidden" name="income_id" value="<?= $student_id ?>">
                    <div class="input-group">
                        <input type="date" name="start_date" class="form-control form-control-sm" value="<?= $start_date ?>">
                        <input type="date" name="end_date" class="form-control form-control-sm" value="<?= $end_date_att ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
              <tr>
                <th>Date</th><th>Status</th><th>Check In</th><th>Check Out</th><th>Location</th>
              </tr>
            </thead>
            <tbody>
              <?php
                if ($total_days > 0) {
                    $currentDate = $start_date;
                    while (strtotime($currentDate) <= strtotime($end_date_att)) {
                        $att = isset($attMap[$currentDate]) ? $attMap[$currentDate] : null;
                        
                        $status = '<span class="badge bg-danger text-white">Absent</span>';
                        $checkIn = '-';
                        $checkOut = '-';
                        $location = '-';

                        if($att){
                            $status = '<span class="badge bg-success text-white">Present</span>';
                            $checkIn = date('h:i A', strtotime($att['check_in']));
                            $checkOut = isset($att['check_out']) && $att['check_out'] ? date('h:i A', strtotime($att['check_out'])) : '-';
                            if(isset($att['lat']) && $att['lat']){
                                // Use standard map link
                                $location = '<a href="https://maps.google.com/?q='.$att['lat'].','.$att['lng'].'" target="_blank" class="btn btn-sm btn-info text-white"><i class="fas fa-map-marker-alt"></i> Loc</a>';
                            }
                        }
              ?>
                <tr>
                    <td><?= date('d M Y', strtotime($currentDate)) ?></td>
                    <td><?= $status ?></td>
                    <td><?= $checkIn ?></td>
                    <td><?= $checkOut ?></td>
                    <td><?= $location ?></td>
                </tr>
              <?php
                        $currentDate = date ("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
                    }
                } else {
                    echo "<tr><td colspan='5'>No records found</td></tr>";
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>






<script>

  function showProofModal(imageUrl) {
  const modalBody = document.getElementById('proofImagesContainer');
  modalBody.innerHTML = `<img src="${imageUrl}" class="img-fluid mb-2" style="max-height:500px;">`;
  const proofModal = new bootstrap.Modal(document.getElementById('proofModal'));
  proofModal.show();
}

// Profile Completion Animation
document.addEventListener("DOMContentLoaded", function(){
    const bar = document.getElementById("profileProgress");
    const target = parseInt(bar.getAttribute("aria-valuenow"));
    let width = 0;
    const interval = setInterval(() => {
        if (width >= target) { clearInterval(interval); }
        else {
            width++;
            bar.style.width = width + "%";
        }
    }, 15);
});

// Chart.js
const ctx = document.getElementById('earningsChart').getContext('2d');
let earningsChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [
            {
                label: 'USD',
                data: <?php echo json_encode($dollars); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            },
            {
                label: 'BDT',
                data: <?php echo json_encode($bdts); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.7)'
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: { x: { stacked: false }, y: { beginAtZero: true } }
    }
});

// Toggle Chart Type (Monthly/Yearly)
document.getElementById('chartType').addEventListener('change', function(){
    if(this.value === 'monthly'){
        earningsChart.data.labels = <?php echo json_encode($months); ?>;
        earningsChart.data.datasets[0].data = <?php echo json_encode($dollars); ?>;
        earningsChart.data.datasets[1].data = <?php echo json_encode($bdts); ?>;
    } else {
        earningsChart.data.labels = <?php echo json_encode($years); ?>;
        earningsChart.data.datasets[0].data = <?php echo json_encode($yearlyDollars); ?>;
        earningsChart.data.datasets[1].data = <?php echo json_encode($yearlyBdts); ?>;
    }
    earningsChart.update();
});
</script>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
