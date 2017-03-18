<?php
    ob_start();
    session_start();
    if( isset($_SESSION['userName'])!="" ){
        header("Location: home.php");
    }

    include_once 'dbconnect.php';

    $query = 'SELECT "projectID", "title", "category", "startDate", "endDate", "targetAmount", "username" FROM project';

    if(isset($_POST['edit'])){
        $projectid = $_POST['editProject'];
        header('Location: edit_project.php?id='.$projectid);
    }

    if(isset($_POST['delete'])){
    	$projectid = $_POST['deleteProject'];
    	$dQuery = 'DELETE FROM project WHERE "projectID" =' .$projectid;
    	$result = pg_query($dQuery) or die('Query failed: ' . pg_last_error());
    }

?>

<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <h1> Manage Projects </h1>
        <table class="fTable" align="center">
		<tr>
        	<th>Project ID</th>
        	<th>Title</th>
        	<th>Category</th>
        	<th>Start Date</th>
        	<th>End Date</th>
        	<th>Target Amount</th>
        	<th>User Name</th>
        	<th> </th>
    	</tr>
        
        <?php
            $result = pg_query($query) or die('Query failed: ' . pg_last_error());
            $i = 0;

            if(pg_num_rows($result) > 0){
				while($row = pg_fetch_row($result)){?>
					<tr>
					<td align="center"><?php echo $row[0]; ?></td>
					<td align="center"><?php echo $row[1]; ?></td>
					<td align="center"><?php echo $row[2]; ?></td>
					<td align="center"><?php echo $row[3]; ?></td>
					<td align="center"><?php echo $row[4]; ?></td>
					<td align="center"><?php echo $row[5]; ?></td>
					<td align="center"><?php echo $row[6]; ?></td>
                    <td align="center">
                        <form method="post" action="<?php echo $_POST['PHP_SELF']; ?>" enctype="multipart/form-data">
                            <input type="submit" name="edit" value="Edit"/>
                            <input type="hidden" name="editProject" value="<?php echo $row[0]?>"/>
                        </form>
                    </td>
            		<td align="center">
						<form method="post" action="<?php echo $_POST['PHP_SELF']; ?>" enctype="multipart/form-data">
							<input type="submit" name="delete" value="Delete"/>
							<input type="hidden" name="deleteProject" value="<?php echo $row[0]?>"/>
            			</form>
            		</td>
            		</tr>
            		<?php
            		$i = $i + 1;
        		}
        	}
        	echo $i. " projects";
        ?>
        </table>

    </body>
</html>