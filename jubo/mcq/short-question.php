<?php require_once 'header.php'; ?>
<?php
if (isset($_GET['delete_id'])) {
    $stmt_delete = $DB_con->prepare('DELETE FROM questions_list WHERE id =:id');
    $stmt_delete->bindParam(':id', $_GET['delete_id']);
    if ($stmt_delete->execute()) {
    //    header('location: question');
    }
}

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <link rel="stylesheet" href="css/table_data_center.css">
    <link rel="stylesheet" href="css/buttons.css">
	<script src="js/search.js"></script>
</head>

<body>

<div class="container-fluid">

    <center>
        <h4>
            <ol class="breadcrumb">
                <li class="active">Short Questions</li>
            </ol>
        </h4>
    </center>
	
 <div class="buttons">
 
        <div class="col-md-2">
            <a class="btn btn-primary text-black" href="short-question-add"> <span class="glyphicon glyphicon-plus"></span> Add Question </a>
        </div>
 </div>
 
 <div style="width:100%" class="form-group input-group">
                 <span style="width:120px;" class="input-group-addon">Search </span>
				 <input id="myInput" style="width:100%;" type="text"  class="form-control" placeholder="Search..">
			  </div>  
			  
        <table width="100%" class="table  table-bordered table-responsive table-hover" group_id="dataTables-example">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Category</th>
                    <th>Question</th> 
                    <th>Right Answer </th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody id="tbody">

                <?php
                $sl = 0;
                $sql = "SELECT questions_list.*, question_category.category 
                FROM questions_list
                JOIN question_category ON questions_list.category_id = question_category.id 
				where questions_list.status=2 and  questions_list.user_id='" . $_SESSION['id'] . "'
				
				";
                $result = mysqli_query($con, $sql);
                while ($eqrow = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo ++$sl; ?></td>
                        <td><?php echo $eqrow['category']; ?></td>
                        <td><?php echo $eqrow['question']; ?></td> 
                        <td><?php echo $eqrow['right_ans']; ?></td>


                        <td><a class="btn-sm btn-info" href="short-question-edit?edit_id=<?php echo $eqrow['id']; ?>" title="click for edit" onclick="return confirm('Do You Want To Edit ?')"><span class="glyphicon glyphicon-edit"></span> </a> </td>

                        <td><a class="btn-sm btn-danger" href="?delete_id=<?php echo $eqrow['id']; ?>" title="click for delete" onclick="return confirm('Do You Want To Delete ?')"><span class="glyphicon glyphicon-trash"></span> </a> </td>


                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>
 
    </div>