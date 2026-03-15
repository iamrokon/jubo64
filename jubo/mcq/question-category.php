<?php require_once 'header.php'; ?>

<?php
if (isset($_GET['delete_id'])) {
    $stmt_delete = $DB_con->prepare('DELETE FROM question_category WHERE id =:id');
    $stmt_delete->bindParam(':id', $_GET['delete_id']);
    if ($stmt_delete->execute()) {
    //    header('location: question-catetory.php');
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
                <li class="active"> Question Category </li>
            </ol>
        </h4>
    </center>

     <div class="buttons">
        <div class="col-md-2">
            <a class="btn btn-primary text-black" href="question-category-add"> <span class="glyphicon glyphicon-plus"></span> Add New Category </a>
        </div>
      </div>
        

        <table width="100%" class="table  table-bordered table-responsive table-hover" group_id="dataTables-example">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Edit</th>
           <!--         <th>Delete</th>     -->
                </tr>
            </thead>

            <tbody id="tbody">

                <?php
                $sl = 0;
                $eq = mysqli_query($con, "select * from question_category where user_id='" . $_SESSION['id'] . "'  ORDER BY id DESC ");
                while ($eqrow = mysqli_fetch_array($eq)) {
                ?>
                    <tr>
                        <td><?php echo ++$sl; ?></td>
                        <td><?php echo $eqrow['category']; ?></td>


                        <td><a class="btn btn-info" href="question-category-add?edit_id=<?php echo $eqrow['id']; ?>" title="click for edit" onclick="return confirm('Do You Want To Edit ?')"><span class="glyphicon glyphicon-edit"></span> Edit</a> </td>
 <!-- 
                        <td><a class="btn btn-danger" href="?delete_id=<?php echo $eqrow['id']; ?>" title="click for delete" onclick="return confirm('Do You Want To Delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a> </td>
   -->

                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
       
    </div>