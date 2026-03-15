<style>
    /* Social icon */
    .stu-profile-social-icon {
        height: 30px;
    }

    /* Profile image with animated gradient border */
    .profile-img {
        width: 180px;
        height: 180px;
        border: 8px solid transparent;
        border-radius: 50%;
        background:
            linear-gradient(white, white) padding-box,
            linear-gradient(270deg, #DE5C5F, #FE9174, #16F716, #595959, #DE5C5F) border-box;
        background-size: 400% 400%;
        background-position: 0% 50%;
        animation: gradientBorder 6s ease infinite;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .profile-img:hover {
        transform: scale(1.05);
    }

    /* Section title underline animation */
    .profile-hr {
        position: relative;
        display: inline-block;
        padding-bottom: 5px;
        margin: 20px 0;
    }

    .profile-hr::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        height: 2px;
        width: 100%;
        border-radius: 10px;
        background: linear-gradient(270deg, #DE5C5F, #FE9174, rgb(36, 235, 9), rgb(144, 21, 214), #DE5C5F);
        background-size: 400% 400%;
        animation: animateHrHorizontal 6s ease infinite;
    }

    /* Earnings Block Styles */
    .earning-block {
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .earning-block:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .earning-block.dollar {
        background: linear-gradient(45deg, #1e3c72, #2a5298);
        color: white;
    }

    .earning-block.bdt {
        background: linear-gradient(45deg, #27ae60, #2ecc71);
        color: white;
    }

    .earning-value {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 10px 0;
    }

    .chart-container {
        height: 250px;
        margin-top: 20px;
        position: relative;
    }
    .table-scroll {
        max-height: 400px;  /* adjust height as needed */
        overflow-y: auto;
        /* Optional for nicer scroll */
        scrollbar-width: thin; /* Firefox */
    }

    .table-scroll::-webkit-scrollbar {
        width: 8px;
    }

    .table-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(100, 100, 100, 0.3);
        border-radius: 4px;
    }


    /* Animations */
    @keyframes gradientBorder {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes animateHrHorizontal {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    /* Summary cards responsive */
    @media (max-width: 576px) {
        .d-flex.gap-3.flex-wrap > div {
            flex: 100% !important;
            margin-bottom: 15px;
        }
    }

</style>

<?php
// Fetch student data
$sql = mysqli_query($con, "SELECT * FROM student_list
  LEFT JOIN district ON district.id = student_list.district
  LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
  LEFT JOIN group_list ON group_list.group_id = student_list.group_id 
  WHERE student_list.stu_user_id = '" . $_SESSION['id'] . "'");
$surow = mysqli_fetch_array($sql);

// Fetch total earnings
$incomeSql = mysqli_query($con, "SELECT SUM(earning_bd) AS total_bd, SUM(earning_dollar) AS total_usd FROM income_info WHERE stu_user_id = '" . $_SESSION['id'] . "'");
$icomerow = mysqli_fetch_assoc($incomeSql);
// Monthly earnings fetch
// Monthly earnings for chart
$monthlySql = mysqli_query($con, "
    SELECT DATE_FORMAT(earning_date, '%b %Y') AS month_label,
           SUM(earning_dollar) AS total_usd,
           SUM(earning_bd) AS total_bdt
    FROM income_info
    WHERE stu_user_id = '" . $_SESSION['id'] . "'
    GROUP BY DATE_FORMAT(earning_date, '%Y-%m')
    ORDER BY earning_date ASC
");

$months = [];
$usdData = [];
$bdtData = [];

while ($row = mysqli_fetch_assoc($monthlySql)) {
    $months[] = $row['month_label'];
    $usdData[] = round($row['total_usd'], 2);
    $bdtData[] = round($row['total_bdt'], 2);
}

// This Month summary
$thisMonthLabel = date('M Y');
$thisMonthUsd = 0;
$thisMonthBdt = 0;
foreach($months as $i => $month) {
    if ($month === $thisMonthLabel) {
        $thisMonthUsd = $usdData[$i];
        $thisMonthBdt = $bdtData[$i];
        break;
    }
}


?>


<!-- Main Container -->
<div class="page-content-wrapper">
    <div class="row mt-4">
        <!-- Profile Section -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <img src="../stu-info/user_images/<?php echo $surow['userPic']; ?>" alt="<?php echo $surow['stu_name']; ?>" class="img-thumbnail profile-img mb-3">
                    <h4 class="mb-1"><?php echo $surow['stu_name']; ?></h4>
                    <p class="text-muted"> Email:<?php echo $surow['email']; ?></p>
                      <div class="text-start mt-4">
                        <h5 class="profile-hr">About Me</h5>
                        <p><?php echo $surow['about']; ?></p>
                      </div>

                    <h5 class="profile-hr">Personal Information</h5>
                    <ul style="list-style: none; padding: 0; text-align: left;">
                        <li><strong>Father's Name:</strong> <?php echo $surow['father_name']; ?></li>
                        <li><strong>Mother's Name:</strong> <?php echo $surow['mother_name']; ?></li>
                        <li><strong>Phone:</strong> <?php echo $surow['contact']; ?></li>
                        <li><strong>Address:</strong> <?php echo $surow['address']; ?></li>
                        <li><strong>Permanent Address:</strong> <?php echo $surow['perma_address']; ?></li>
                        <li><strong>Age:</strong> <?php echo $surow['age']; ?></li>
                        <li><strong>NID/Birth Cert:</strong> <?php echo $surow['nid_no']; ?></li>
                        <li><strong>Blood Group:</strong> <?php echo $surow['blood_grp']; ?></li>
                    </ul>

                    <!-- Social Icons -->
                    <div class="mt-3">
                        <?php if (!empty($surow['fiver'])): ?>
                            <a href="<?php echo $surow['fiver']; ?>" target="_blank"><img class="stu-profile-social-icon" src="../images/fiverr1.png" style="height:50px;"></a>
                        <?php endif; ?>
                        <?php if (!empty($surow['upwork'])): ?>
                            <a href="<?php echo $surow['upwork']; ?>" target="_blank"><img class="stu-profile-social-icon" src="../images/upwork.png" style="height:37px;"></a>
                        <?php endif; ?>
                        <?php if (!empty($surow['linked_in'])): ?>
                            <a href="<?php echo $surow['linked_in']; ?>" target="_blank"><img class="stu-profile-social-icon" src="../images/linkedin.jpg" style="height:37px;"></a>
                        <?php endif; ?>
                    </div>

                    

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <a href="change-password" class="btn btn-success"><i class="fa fa-key me-1"></i> Change Password</a>
                        <a href="student-edit" class="btn btn-primary"><i class="fa fa-edit me-1"></i> Edit Info</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings Section -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <!-- <h3 class="profile-hr mb-4">Earnings Summary</h3> -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="earning-block dollar">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>Total Dollar Earnings</h5>
                                        <div class="earning-value">$<?php echo number_format($icomerow['total_usd'] ?? 0, 2); ?></div>
                                    </div>
                                    <i class="fas fa-dollar-sign fa-3x"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="earning-block bdt">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5>Total BDT Earnings</h5>
                                        <div class="earning-value">৳<?php echo number_format($icomerow['total_bd'] ?? 0, 2); ?></div>
                                    </div>
                                    
                                    <span style="font-size: 3rem; font-weight: 700; color: #FFFFFF;">৳</span>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4 mb-4">
                        <a href="earning-add-with-student" class="btn btn-dark btn-lg">
                            <i class="fa fa-plus-circle me-2"></i> Add New Earning
                        </a>
                    </div>

                    <!-- Summary Cards -->
                    <!-- <div class="d-flex gap-3 mb-4 flex-wrap">
                        <div style="flex:1; min-width:150px; background:#1e3c72; color:#fff; border-radius:8px; padding:15px; text-align:center;">
                            <h6>This Month Earnings (USD)</h6>
                            <h3 style="margin:0;">$<?php echo number_format($thisMonthUsd, 2); ?></h3>
                        </div>
                        <div style="flex:1; min-width:150px; background:#27ae60; color:#fff; border-radius:8px; padding:15px; text-align:center;">
                            <h6>This Month Earnings (BDT)</h6>
                            <h3 style="margin:0;">৳<?php echo number_format($thisMonthBdt, 2); ?></h3>
                        </div>
                    </div> -->

                    <!-- Chart Container -->
                    <canvas id="earningsChart" style="max-width:100%; height:250px;"></canvas>

                </div>
            </div>
        </div>
    </div>

    <!-- Earning Records Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom py-4 d-flex justify-content-between">
                    <h4 class="card-title m-0">All Earning Records</h4>
                </div>
                <div class="card-body ">
                      <div class="table-scroll">

                   <table id="datatable" class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Dollar</th>
                                <th>BD.TK</th>
                                <th>Payment</th>
                                <th>Platform</th>
                                <th>Job</th>
                                <th>Photo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sl = 0;
                            $eq = mysqli_query($con, "SELECT * FROM income_info 
                                LEFT JOIN student_list ON income_info.student_id = student_list.student_id
                                LEFT JOIN payment_method ON income_info.payment_type = payment_method.pm_id
                                LEFT JOIN work_source ON income_info.work_source = work_source.ws_id
                                LEFT JOIN jobs ON income_info.job_id = jobs.j_id
                                WHERE income_info.stu_user_id = '" . $_SESSION['id'] . "' ORDER BY income_info.in_id DESC");
                            while ($eqrow = mysqli_fetch_array($eq)) {
                                $sl++;
                            ?>
                                <tr>
                                    <td><?= $sl; ?></td>
                                    <td><?= $eqrow['earning_date']; ?></td>
                                    <td><?= ($eqrow['earning_dollar']) ? '$' . number_format($eqrow['earning_dollar'], 2) : '-'; ?></td>
                                    <td><?= ($eqrow['earning_bd']) ? '৳' . number_format($eqrow['earning_bd'], 2) : '-'; ?></td>
                                    <td><?= $eqrow['payment_name'] ?? '-'; ?></td>
                                    <td><?= $eqrow['work_name'] ?? '-'; ?></td>
                                    <td><?= $eqrow['job_name'] ?? '-'; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php
                                            $images = explode(",", $eqrow['incomePics']);
                                            foreach ($images as $image) {
                                                $imgSrc = $image ?: 'website/favicon.png';
                                                echo "<img src='$imgSrc' alt='Image' class='img-fluid img-thumbnail m-1' style='width:30px;height:30px; cursor:pointer;' onclick=\"showFullImage('$imgSrc')\">";
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('earningsChart').getContext('2d');
const earningsChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [
            {
                label: 'USD Earnings',
                data: <?php echo json_encode($usdData); ?>,
                backgroundColor: 'rgba(30, 60, 114, 0.8)',
                borderRadius: 6
            },
            {
                label: 'BDT Earnings',
                data: <?php echo json_encode($bdtData); ?>,
                backgroundColor: 'rgba(39, 174, 96, 0.8)',
                borderRadius: 6
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>


<!-- Fullscreen Image Modal -->
<div id="imgModal" onclick="closeImage()" style="display:none; position:fixed; z-index:9999; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); justify-content:center; align-items:center;">
    <img id="fullImg" src="" style="max-width:90%; max-height:90%; border:5px solid white; border-radius:10px;">
</div>

<script>
    function showFullImage(src) {
        document.getElementById("fullImg").src = src;
        document.getElementById("imgModal").style.display = "flex";
    }

    function closeImage() {
        document.getElementById("imgModal").style.display = "none";
    }
</script>
