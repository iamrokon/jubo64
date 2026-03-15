<?php require_once 'header.php'; ?>
 
<link rel="stylesheet" type="text/css" href="css/chosen.css" />
<script src="js/search.js"></script>


<div class="container">
  <center>
    <h4>
      <ol class="breadcrumb">
        <li>Report By Category</li>
      </ol>
    </h4>
  </center>
  <div class="row">



    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="glyphicon glyphicon-check"></i> Report By Category
        </div>
        <div class="panel-body">
          <form class="form-horizontal" action="" method="post">
            <div class="form-group">
              <label for="startDate" class="col-sm-4 control-label">Start Date</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="startDate" name="startDate" placeholder="Start Date" required />
              </div>
            </div>
            <div class="form-group">
              <label for="endDate" class="col-sm-4 control-label">End Date</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Date" required />
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <center>
                  <button type="submit" class="btn btn-success" id="generateReportBtn">
                    <i class="glyphicon glyphicon-ok-sign"></i> View Report
                  </button>
                </center>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>


    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { ?>

      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <?php

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              $startDate = $_POST['startDate'];
              $date = DateTime::createFromFormat('m/d/Y', $startDate);
              $start_date = $date->format("Y-m-d");
              $start_date_n = $date->format("d-F-Y");

              $endDate = $_POST['endDate'];
              $format = DateTime::createFromFormat('m/d/Y', $endDate);
              $end_date = $format->format("Y-m-d");
              $end_date_n = $format->format("d-F-Y");

              $sql = $con->query("SELECT count(`stu_id`) as `total` FROM `student_reg_jubo` WHERE entry_date >= '$start_date' AND entry_date <= '$end_date' ");
              $row = $sql->fetch_assoc();
              $GT = $row['total'];
            }
            ?>

            <div style="display: flex; align-items: center; justify-content: space-between;">
              <div>
                <strong style="margin-right: 1.5rem;"> <i class="glyphicon glyphicon-check"></i> Total Student Registration (Total = <?php echo $GT; ?>)</strong>
                <strong style="margin-right: 1.5rem;"> <i class="glyphicon glyphicon-calendar"></i> Start Date: <?= $start_date  ?></strong>
                <strong> <i class="glyphicon glyphicon-calendar"></i> End Date: <?= $end_date  ?> </strong>
              </div>

              <div>
                <a id="dlink" style="display:none;"></a>
                <button type="button" class="btn btn-success" onclick="tableToExcel('testTableCount', 'name', 'all district.xls')">Export to Excel </button>
              </div>
            </div>
          </div>
 
	
          <div class="panel-body">
		   <br>
   <div style="width:100%" class="form-group input-group">
                 <span style="width:120px;" class="input-group-addon">Search:</span>
				 <input id="myInput" style="width:100%;" type="text"  class="form-control" placeholder="Search.....">
	</div>
            <table width="100%" class="table table-bordered table-hover text-center" id="testTableCount">
              <thead>
                <tr>
                  <th class="text-center" colspan="4"><br>
				  দেশের ৪৮ জেলায় শিক্ষিত কর্মপ্রত্যাশী যুবদের ফ্রিল্যান্সিং প্রশিক্ষণের মাধ্যমে কর্মসংস্থান সৃষ্টি শীর্ষক প্রকল্প <br>যুব উন্নয়ন অধিদপ্তর<br><br>
                                                  আপডেট রেজিস্ট্রেশন এর তথ্য <br>
					Date : <?= $start_date_n  ?>  To  <?= $end_date_n  ?><br>
                    Total Student Registration (Total = <?php echo $GT; ?>)					
				  </th> 
                </tr>

				<tr>				
                  <th><center>SL</center></th>
          <!--        <th><center>Division</center></th> -->
                  <th><center>District</center></th>
                  <th><center>Total</center></th>
                  <th><center>Remarks</center></th> 
				  
                </tr>
              </thead>
              <tbody id="tbody">

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                  $startDate = $_POST['startDate'];
                  $date = DateTime::createFromFormat('m/d/Y', $startDate);
                  $start_date = $date->format("Y-m-d");

                  $endDate = $_POST['endDate'];
                  $format = DateTime::createFromFormat('m/d/Y', $endDate);
                  $end_date = $format->format("Y-m-d");

                  $sql = "SELECT b.dist_name, d.div_name, COUNT(a.stu_id) as total_students 
                    FROM student_reg_jubo a 
                    LEFT JOIN division d ON a.div_id = d.div_id
                    LEFT JOIN district b ON a.district = b.id 
                    WHERE entry_date >= '$start_date' AND entry_date <= '$end_date' 
                    GROUP BY b.dist_name 
                    ORDER BY total_students DESC ";

                  $result = mysqli_query($con, $sql);
                  $sl = 1;

                  while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                      <td><?php echo $sl++; ?></td>
             <!--      <td><?php echo $row['div_name']; ?></td> -->
                      <td><?php echo $row['dist_name']; ?></td>
                      <td><?php echo $row['total_students']; ?></td>
					  <td></td>
                    </tr>
                <?php
                  }
                }
                ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>

    <?php
    }
    ?>



  </div>


  <?php require_once 'includes/footer.php'; ?>

</div>



<script src="js/excel.js"></script>
<script src="custom/js/report.js"></script>
<script src="js/chosen.js"></script>
<script type="text/javascript">
  $('.chosen-select').chosen({
    width: "100%"
  });
</script>