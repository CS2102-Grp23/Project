<?php
    ob_start();
    session_start();
    if( isset($_SESSION['userName'])!="" ){
        header("Location: home.php");
    }

    include_once 'dbconnect.php';

    $query = 'SELECT "username", "accesslevel", "email", "name", "creditCard", "nationality" FROM users';

    if(isset($_POST['edit'])){
        $username = $_POST['editUser'];
        header('Location: edit_user.php?id='.$username);
    }

    if(isset($_POST['delete'])){
    	$username = $_POST['deleteUser'];
    	$dQuery = "DELETE FROM \"public\".\"users\" WHERE username = '$username'";
    	$result = pg_query($dQuery) or die('Query failed: ' . pg_last_error());
    }

?>

<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <h1> Manage User </h1>
        <table class="fTable" align="center">
		<tr>
        	<th>User Name</th>
        	<th>Access Level</th>
        	<th>Email</th>
        	<th>Name</th>
            <th>Credit Card</th>
            <th>Nationality</th>
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
                    <td align="center">
                        <form method="post" action="<?php echo $_POST['PHP_SELF']; ?>" enctype="multipart/form-data">
                            <input type="submit" name="edit" value="Edit"/>
                            <input type="hidden" name="editUser" value="<?php echo $row[0]?>"/>
                        </form>
                    </td>
            		<td align="center">
						<form method="post" action="<?php echo $_POST['PHP_SELF']; ?>" enctype="multipart/form-data">
							<input type="submit" name="delete" value="Delete"/>
							<input type="hidden" name="deleteUser" value="<?php echo $row[0]?>"/>
            			</form>
            		</td>
            		</tr>
            		<?php
            		$i = $i + 1;
        		}
        	}
        	echo $i. " users";
        ?>
        </table>

    </body>
</html>