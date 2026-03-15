<?php 
session_start();
require_once 'includes/conn.php';
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head> 
<link rel="stylesheet" href="css/table_data_center_with_border_black.css">
<?php include('link.php'); ?>
<script src="js/excel.js"></script>
</head>
<body> 
<!--
<input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export To Excel">
-->

<div class="container-fluid" style="width:100%;">
<br>
 <center> 
  
 <h4> Category Wise Question List</h3> 
 <span style="font-size:16;">  
				   <?php 
				   $CatId = $_POST['CatId']; 
				   $pq=mysqli_query($con,"SELECT * FROM question_category   where id = '$CatId' ");
				   while($pqrow=mysqli_fetch_array($pq)){
				?>
			    Category Name :  <b>  <?php echo $pqrow['category']; ?></b> 
				 
				   
				   <?php }?>
				     
	 </span> 			   
				   <br>
	<span style="font-size:18;">			   
	 
Date : <?php echo date("M d,Y") ;?> |
Time : <?php date_default_timezone_set("Asia/Dhaka"); echo  date("h:i:sa");?>
 </span> 
 </center> 
 <br>
<table width="100%" class="table   table-bordered" customer_id="dataTables-example">
            <thead>
                <tr>
                    <th>SL</th> 
                    <th>Question</th>
                    <th>Answer 1</th>
                    <th>Answer 2</th>
                    <th>Answer 3</th>
                    <th>Answer 4</th>
                    <th style="width:150px;">Right Answer </th> 
                </tr>
            </thead>

            <tbody id="tbody">

                <?php
				
                $sl = 0;
				$CatId = $_POST['CatId']; 
				
                $sql = "SELECT questions_list.*, question_category.category 
                FROM questions_list
                JOIN question_category ON questions_list.category_id = question_category.id 
				where questions_list.category_id= '$CatId' and questions_list.status=1 
				";
                $result = mysqli_query($con, $sql);
                while ($eqrow = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo ++$sl; ?></td> 
                        <td><?php echo $eqrow['question']; ?></td>
                        <td><?php echo $eqrow['ans1']; ?></td>
                        <td><?php echo $eqrow['ans2']; ?></td>
                        <td><?php echo $eqrow['ans3']; ?></td>
                        <td><?php echo $eqrow['ans4']; ?></td>
                        <td><?php echo $eqrow['right_ans']; ?></td>

 

                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>