<?php
require_once 'header.php'; ?>

<?php

if (isset($_POST['save'])) {
    $category = $_POST['category'];
    $id = $_POST['id'];
    $user_id = $_POST['UserId'];

    if (empty($category)) {
        $errMSG = "Please Enter Category Name.";
    }

    if ($id == '0') {
        // if no error occured, continue ....
        if (!isset($errMSG)) {

            $stmt = $DB_con->prepare('INSERT INTO question_category (user_id, category, status)VALUES(:user_id,:category, 1)');


            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':category', $category);

            if ($stmt->execute()) {
?>
                <script>
                    alert('Category Data Successfully Add ...');
                    window.location.href = 'question-category';
                </script>
            <?php

            } else {
                $errMSG = "error while inserting....";
            }
        }
    } else {
        // Update Code 
        if (!isset($errMSG)) {
            $stmt = $DB_con->prepare('UPDATE question_category SET category=:category, user_id=:user_id WHERE  id =:id');

            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
            ?>
                <script>
                    alert('Update Successful...');
                    window.location.href = 'question-category';
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
                <li class="active"> Question Category Add </li>
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
                    $r_row = mysqli_query($con, "select * from question_category where id='" . $_GET['edit_id'] . "'");
                    $row = mysqli_fetch_array($r_row);
                }
                ?>


                <input type="hidden" name="id" id="id" value="<?= isset($_GET['edit_id']) ? $_GET['edit_id'] : 0 ?>">
                <input class="form-control" type="hidden" name="UserId" value="<?php echo $pqrow['userid']; ?>" />
                <table class="table table-hover table-responsive">
                    <tr>
                        <td><label for="" class="control-label">Category Name</label></td>
                        <td><input type="text" name="category" class="form-control" placeholder="Category" value="<?= isset($row) ? $row['category'] : '' ?>"></td>
                    </tr>
                </table>
                <button type="submit" class="btn btn-primary" name="save"><span class="glyphicon glyphicon-save"></span> Save</button>
            </form>
			
			
        </div>
     