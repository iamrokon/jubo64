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
            <a class="btn btn-primary text-black" href="question-add"> <span class="glyphicon glyphicon-plus"></span> Add Question </a>
        </div>
 </div>
 
 <div style="width:100%" class="form-group input-group">
                 <span style="width:120px;" class="input-group-addon">Search </span>
				 <input id="myInput" style="width:100%;" type="text"  class="form-control" placeholder="Search..">
			  </div>  
			  
       





<?php
// Database connection
// $con = mysqli_connect("localhost", "root", "", "elaeltdc_jubo_48_db"); // Change database name
// if (!$con) {
//     die("Connection failed: " . mysqli_connect_error());
// }

// Pagination setup
$limit = 50; // Records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total count
$count_sql = "SELECT COUNT(*) as total FROM questions_list where questions_list.user_id='" . $_SESSION['id'] . "'";
$count_result = mysqli_query($con, $count_sql) or die(mysqli_error($con));
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $limit);

// Get paginated data
$sql = "SELECT * FROM questions_list where questions_list.user_id='" . $_SESSION['id'] . "' LIMIT $offset, $limit";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
?>


<table width="100%" class="table table-bordered table-responsive table-hover">
    <thead>
        <tr>
            <th>SL</th>
            <th>Question</th>
            <th>Answer 1</th>
            <th>Answer 2</th>
            <th>Answer 3</th>
            <th>Answer 4</th>
            <th>Right Answer</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody id="tbody">
        <?php
        $sl = $offset; // Start numbering from offset
        while ($eqrow = mysqli_fetch_array($result)) {
            $sl++;
        ?>
            <tr>
                <td><?php echo $sl; ?></td>
                <td><?php echo htmlspecialchars($eqrow['question']); ?></td>
                <td><?php echo htmlspecialchars($eqrow['ans1']); ?></td>
                <td><?php echo htmlspecialchars($eqrow['ans2']); ?></td>
                <td><?php echo htmlspecialchars($eqrow['ans3']); ?></td>
                <td><?php echo htmlspecialchars($eqrow['ans4']); ?></td>
                <td><?php echo htmlspecialchars($eqrow['right_ans']); ?></td>
                <td>
                    <a class="btn-sm btn-info" href="short-question-edit?edit_id=<?php echo $eqrow['id']; ?>" title="click for edit" onclick="return confirm('Do You Want To Edit ?')">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                </td>
                <td>
                    <a class="btn-sm btn-danger" href="?delete_id=<?php echo $eqrow['id']; ?>" title="click for delete" onclick="return confirm('Do You Want To Delete ?')">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php if ($total_pages > 1): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center align-items-center mt-4">
            <!-- Previous Button -->
            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo max(1, $page - 1); ?>">Previous</a>
            </li>

            <?php
            $start = max(1, $page - 2);
            $end = min($total_pages, $page + 2);

            if ($start > 1) {
                echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                if ($start > 2) {
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                }
            }

            for ($i = $start; $i <= $end; $i++) {
                echo '<li class="page-item'.($i == $page ? ' active' : '').'">';
                echo '<a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
            }

            if ($end < $total_pages) {
                if ($end < $total_pages - 1) {
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                }
                echo '<li class="page-item"><a class="page-link" href="?page='.$total_pages.'">'.$total_pages.'</a></li>';
            }
            ?>

            <!-- Next Button -->
            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                <a class="page-link" href="?page=<?php echo min($total_pages, $page + 1); ?>">Next</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<?php mysqli_close($con); ?>












 
    </div>