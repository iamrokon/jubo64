<table width="100%" class="table table-hover" customer_id="dataTables-example">
            <thead>
                <tr>
                    <th>SL</th> 
                    <th>Category</th> 
                    <th>Total</th> 
                </tr>
            </thead>

            <tbody id="tbody">

                <?php
				
                $sl = 0; 
				
                $sql = "SELECT count(questions_list.category_id) as total, question_category.category 
                FROM questions_list
                left join question_category ON questions_list.category_id = question_category.id    group by questions_list.category_id
				";
                $result = mysqli_query($con, $sql);
                while ($eqrow = mysqli_fetch_array($result)) {
				 
                ?>
                    <tr>
                        <td><?php echo ++$sl; ?></td> 
                        <td><?php echo $eqrow['category']; ?></td>  
                        <td><?php echo $eqrow['total']; ?></td>    

                    </tr>
                <?php
                }
                ?>

            </tbody>
        </table>

