<!doctype html>
<html lang="en">

<head>
  <title>Earning Information  | e-Learning & Earning Ltd.</title>
  <?php include "header-link.php" ?>
</head>

<body data-topbar="colored">
  <div id="layout-wrapper">
    <?php include "header.php" ?>
    <?php include "sidebar.php" ?>

    <div class="main-content">
      <div class="page-content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-12">
              <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="page-title">
                  <h4 class="mb-0 font-size-18">Dashboard</h4>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active">All Student Information</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>

          <div class="page-content-wrapper">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header border-bottom py-4">
                    <h4 class="card-title m-0">All Student Information Report</h4>
                  </div>
                  <hr class="m-0">
                  <div class="card-body">

                    <div class="row mb-4 mt-3">
                      <div class="col-xl-8 mx-auto">
                        <form>
                          <div class="row align-items-center justify-content-center">
                            <div class="col-md-12 text-center mb-3">
                              <h3 class="m-0">District Wise Reports</h3>
                            </div>

                            <div class="col-md-6 col-lg-2 my-2">
                              <select id="DistId" name="DistId" class="form-control form-select" required>
                                <option value="" disabled selected>Select District</option>
                                <?php
                                $sql = "SELECT * FROM district";
                                $result = $con->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                  echo "<option value='" . $row['id'] . "'>" . $row['dist_name'] . "</option>";
                                }
                                ?>
                              </select>
                            </div>

                            <div class="col-md-6 col-lg-2 my-2">
                              <select id="Batch" name="Batch" class="form-control form-select" required>
                                <option value="" disabled selected>Select Batch</option>
                                <?php
                                $sql = "SELECT * FROM batch_list";
                                $result = $con->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                  echo "<option value='" . $row['batch_id'] . "'>" . $row['batch_name'] . "</option>";
                                }
                                ?>
                              </select>
                            </div>

                            <div class="col-md-6 col-lg-2 my-2">
                              <select id="Group" name="Group" class="form-control form-select">
                                <option value="">Select Group</option>
                                <?php
                                $sql = "SELECT * FROM group_list";
                                $result = $con->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                  echo "<option value='" . $row['group_id'] . "'>" . $row['group_name'] . "</option>";
                                }
                                ?>
                              </select>
                            </div>

                            <div class="col-md-6 col-lg-3 col-xxl-2 my-2">
                              <a id="reportLink" target="_blank" class="btn btn-success w-100 waves-effect">Open Report</a>
                            </div>

                            <script>
                              document.getElementById("reportLink").addEventListener('click', function (e) {
                                var distId = document.getElementById("DistId").value;
                                var batchId = document.getElementById("Batch").value;
                                var groupId = document.getElementById("Group").value;

                                if (!distId || !batchId) {
                                  alert("Please select District and Batch !");
                                  e.preventDefault();
                                  return false;
                                }

                                if (distId && batchId && groupId) {
                                  // Update href attribute of report link
                                  this.href = "student-information-report?dist_id=" + distId + "&batch_id=" + batchId + "&group_id=" + groupId;
                                } else if (distId && batchId) {
                                  this.href = "student-information-report?dist_id=" + distId + "&batch_id=" + batchId;
                                }
                              });
                            </script>

                          </div>
                        </form>
                      </div>
                    </div>

                    <hr>

                    <table id="datatable" class="table table-bordered table-hover align-middle">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>District</th>
                          <th>Name</th>
                          <th>Father Name</th>
                          <th>Batch</th>
                          <th>Group</th>
                          <th>Mobile</th>
                          <th>Email</th>
                          <th>Age</th>
                          <!-- <th>Action</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = "SELECT student_list.*, district.dist_name, batch_list.batch_name, group_list.group_name
                                  FROM student_list
                                  LEFT JOIN district ON district.id = student_list.district
                                  LEFT JOIN batch_list ON batch_list.batch_id = student_list.batch_id
                                  LEFT JOIN group_list ON group_list.group_id = student_list.group_id
                                  ORDER BY student_list.student_id DESC LIMIT 1000";
                        $result = $con->query($query);
                        $sl = 1;
                        while ($row = $result->fetch_assoc()) {
                        ?>
                          <tr>
                            <td><?= $sl++ ?></td>
                            <td><?= $row['dist_name']; ?></td>
                            <td><?= $row['stu_name']; ?></td>
                            <td><?= $row['father_name']; ?></td>
                            <td><?= $row['batch_name']; ?></td>
                            <td><?= $row['group_name']; ?></td>
                            <td><?= $row['contact']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['age']; ?></td>
                            <!-- <td width="10%">
                              <a class="btn btn-primary waves-effect" href="student-info-profile?view_id=<?= $row['student_id']; ?>" title="Click To View"><i class="fa fa-eye"></i></a>
                            </td> -->
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
      </div>

      <?php include "footer.php" ?>
    </div>
  </div>

  <?php include "script.php" ?>
</body>
</html>


