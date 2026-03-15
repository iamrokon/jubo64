<?php
require_once 'header.php'; ?>

<?php

if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $category_id = $_POST['category_id'];
    $question = $_POST['question'];
    $ans1 = $_POST['ans1'];
    $ans2 = $_POST['ans2'];
    $ans3 = $_POST['ans3'];
    $ans4 = $_POST['ans4'];
    $Right = $_POST['Right'];

    if (empty($category_id)) {
        $errMSG = "Please Enter Category Name.";
    } else if (empty($question)) {
        $errMSG = "Please Enter Question Name.";
    } else if (empty($ans1)) {
        $errMSG = "Please Enter Answer 1.";
    } else if (empty($ans2)) {
        $errMSG = "Please Enter Answer 2.";
    } else if (empty($ans3)) {
        $errMSG = "Please Enter Answer 3.";
    } else if (empty($ans4)) {
        $errMSG = "Please Enter Answer 4.";
    }
	else if (empty($Right)) {
        $errMSG = "Please Enter Right Answer ";
    }
	
else if (isset($_POST['question']) && $_POST['question'] != '') { 
		$question = $_POST['question'];
		$checkQuery = mysqli_query($con, "SELECT * FROM `questions_list` WHERE `question`='$question' ");
		if (mysqli_num_rows($checkQuery) > 0) {
		$errMSG = "This Question Already Exist !";
		}
else {

    if ($id == '0') {
        // if no error occured, continue ....
        if (!isset($errMSG)) {
            $stmt = $DB_con->prepare('INSERT INTO questions_list (user_id, category_id, question, ans1, ans2, ans3, ans4,right_ans, status)VALUES(:user_id,:category_id,:question,:ans1,:ans2,:ans3,:ans4,:Right, 1)');


            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':question', $question);
            $stmt->bindParam(':ans1', $ans1);
            $stmt->bindParam(':ans2', $ans2);
            $stmt->bindParam(':ans3', $ans3);
            $stmt->bindParam(':ans4', $ans4);
            $stmt->bindParam(':Right', $Right);

            if ($stmt->execute()) {
?>
                <script>
                    alert('Question Data Successfully Add ...');
                    window.location.href = 'question';
                </script>
            <?php
            } else {
                $errMSG = "error while inserting....";
            }
        } }
    } 
    } 
	
	else {
        // Update Code 
        if (!isset($errMSG)) {
            $stmt = $DB_con->prepare('UPDATE questions_list SET user_id=:user_id, category_id=:category_id, question=:question, ans1=:ans1, ans2=:ans2, ans3=:ans3, ans4=:ans4, right_ans=:Right WHERE  id=:id');

            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':question', $question);
            $stmt->bindParam(':ans1', $ans1);
            $stmt->bindParam(':ans2', $ans2);
            $stmt->bindParam(':ans3', $ans3);
            $stmt->bindParam(':ans4', $ans4);
			$stmt->bindParam(':Right', $Right);
            $stmt->bindParam(':id', $id);



            if ($stmt->execute()) {
            ?>
                <script>
                    alert('Update Successful...');
                    window.location.href = 'question-add';
                </script>
<?php }
        } else {
            $errMSG = "Sorry Data Could Not Updated !";
        }
    }



}



?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <link rel="stylesheet" href="css/table_data_center.css">
    <link rel="stylesheet" href="css/buttons.css">
</head>

<body>

<div class="container">

    <center>
        <h4>
            <ol class="breadcrumb">
                <li class="active">  Add New Questions</li>
            </ol>
        </h4>
    </center>
 
 
          <form method="post" enctype="multipart/form-data" class="form-horizontal" >
		  
                <?php
                if (isset($errMSG)) {
                ?>
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
                    </div>
                <?php
                } else if (isset($successMSG)) {
                ?>
                    <div class="alert alert-success">
                        <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
                    </div>
                <?php
                }

                $pq = mysqli_query($con, "select * from user where userid='" . $_SESSION['id'] . "'");
                $pqrow = mysqli_fetch_array($pq);

                if (isset($_GET['edit_id'])) {
                    $r_row = mysqli_query($con, "select * from questions_list where id='" . $_GET['edit_id'] . "'");
                    $row = mysqli_fetch_array($r_row);
                }
                ?>


                <input type="hidden" name="id" id="id" value="<?= isset($_GET['edit_id']) ? $_GET['edit_id'] : 0 ?>">
                <input class="form-control" type="hidden" name="user_id" value="<?php echo $pqrow['userid']; ?>" />
                <table class="table table-hover table-responsive">
                    <tr>
                        <td><label for="" class="control-label">Category</label></td>
                        <td>
                            <select name="category_id" id="category_id" class="form-control"> 							
                                <?php
                                $category = mysqli_query($con, "select * from question_category where user_id='" . $_SESSION['id'] . "'");
                                while ($cat = mysqli_fetch_assoc($category)) { ?>
                                    <option value='<?= $cat['id'] ?>' <?= (isset($row) && $row['category_id'] == $cat['id']) ? 'selected' : '' ?>> <?= $cat['category'] ?> </option>
                                <?php }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="" class="control-label">Question</label></td>
                        <td><input type="text" name="question" class="form-control" placeholder="Question" value="<?= isset($row) ? $row['question'] : '' ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="" class="control-label">Answer 1</label></td>
                        <td><input type="text" name="ans1" class="form-control" placeholder="Answer 1" value="<?= isset($row) ? $row['ans1'] : '' ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="" class="control-label">Answer 2</label></td>
                        <td><input type="text" name="ans2" class="form-control" placeholder="Answer 2" value="<?= isset($row) ? $row['ans2'] : '' ?>"></td>
                    </tr>
                    <tr>
                        <td><label for="" class="control-label">Answer 3</label></td>
                        <td><input type="text" name="ans3" class="form-control" placeholder="Answer 3" value="<?= isset($row) ? $row['ans3'] : '' ?>"></td>
                    </tr>
                    
					<tr>
                        <td><label for="" class="control-label">Answer 4</label></td>
                        <td><input type="text" name="ans4" class="form-control" placeholder="Answer 4" value="<?= isset($row) ? $row['ans4'] : '' ?>"></td>
                    </tr>
					
					<tr>
                        <td><label for="" class="control-label">Right Answer </label></td>
                        <td><input type="text" name="Right" class="form-control" placeholder="Right Answer" value="<?= isset($row) ? $row['Right'] : '' ?>"></td>
                    </tr>

                </table>
                <button type="submit" class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
            </form>
        </div>
         
    </div>