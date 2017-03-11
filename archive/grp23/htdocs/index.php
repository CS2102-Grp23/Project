<?php

    ob_start();
    session_start();
    include_once 'dbconnect.php';

    $error = false;
    $projectQuery = 'SELECT "projectID" FROM project';

    if (isset($_POST['logIn'])){
      	$userName = sanitize($_POST['userName']);
        $password = sanitize($_POST['password']);
        $name = "";

        if (empty($userName) || empty($password)){
            $error = true;
            $enterError = "Please enter ID or password.";
        }
        else{
            $query = "SELECT username FROM \"public\".\"users\" WHERE username = '$userName'";
            $result = pg_query($query);
            $count = pg_num_rows($result);
            
            if($count == 0){
                $error = true;
                $nameError = "Username is not matched.";
            }
        	else{
            	$password = hash('sha256', $password);

            	$query = "SELECT username FROM \"public\".\"users\"
                      WHERE username = '$userName' AND password = '$password'";
            	$result = pg_query($query);
            	$count = pg_num_rows($result);
            
            	if($count == 0){
             	   $error = true;
             	   $passwordError = "Password is not matched.";
            	}
            	pg_free_result($result);
        	}
        }

        if (!$error){
            $query = "SELECT * FROM \"public\".\"users\"
                      WHERE username = '$userName' AND password = '$password'";

            $res = pg_query($query) or die('Query failed: ' . pg_last_error());

            if(pg_fetch_result($res, 'accesslevel') == 't'){
            	header('Location: /admin.php'); exit();
            }
            else{
                $name = pg_fetch_result($res, 'name');
            }

            pg_free_result($res);
        }
    }

    if (isset($_POST['logOut'])){
        $_SESSION['userName'] = "";
        header('Location: index.php'); exit();
    }

    if (isset($_POST['searchSubmit']) || isset($_POST['sorting'])){
        $pQuery = 'SELECT "projectID" FROM project';
    	$projectTitle = sanitize($_POST['projectTitle']);
    	$category = $_POST['category'];
    	$sort = $_POST['sort'];

    	if($projectTitle != ""){
    		if($category != ""){
    			switch ($sort){
    				/*case "contribute":
    					$pQuery = 'SELECT "p.projectID" FROM project p
    						LEFT JOIN contribute c ON "p.projectID" = "c.projectID"
    				 		WHERE "p.category" = "$category"
    						AND "p.title" LIKE "%$projectTitle%"
    						GROUP BY "p.projectID"
    						ORDER BY COUNT("c.username")';
    					break;
    				case "money":
    					$pQuery = 'SELECT "p.projectID" FROM project p
    						LEFT JOIN contribute c ON "p.projectID" = "c.projectID"
    				 		WHERE "p.category" = "$category"
    						AND "p.title" LIKE "%$projectTitle%"
    						GROUP BY "p.projectID"
    						ORDER BY COUNT("c.amount")';
    					break;*/
      				default:
    					$pQuery = 'SELECT "projectID" FROM project
    				  		WHERE "category" = "'.$category.'"
    						AND "title" LIKE "%$projectTitle%""
    						ORDER BY "$sort"';
    			}
    		}
    		else{
    			switch ($sort){
    			/*	case "contribute":
    				$pQuery = "SELECT p.projectID FROM \"public\".\"project\" p
    							LEFT JOIN \"public\".\"contribute\" c ON p.projectID = c.projectID
    						  AND p.projectTitle LIKE '%$projectTitle%'
    						  GROUP BY p.projectID
    						  ORDER BY COUNT(c.username)";
    				break;
    			case "money":
    				$pQuery = "SELECT p.projectID FROM \"public\".\"project\" p
    		 					LEFT JOIN \"public\".\"contribute\" c ON p.projectID = c.projectID
    						  AND p.projectTitle LIKE '%$projectTitle%'
    						  GROUP BY p.projectID
    						  ORDER BY COUNT(c.amount)";
    				break;*/
    			default:
    				$pQuery = /*"SELECT 'projectID' FROM \"public\".\"project\"
                        WHERE 'title' LIKE ".$projectTitle;*/
                        'SELECT "projectID" FROM project
                        WHERE "title" LIKE \'$projectTitle\'';
                           // WHERE "title" LIKE \'project2\'';

    				  		  
    						  //ORDER BY "$sort"';
                              //
    			}
    		}
    	}
        else{
            if($category != ""){
                switch ($sort){
                    /*case "contribute":
                        $pQuery = 'SELECT "p.projectID" FROM project p
                            LEFT JOIN contribute c ON "p.projectID" = "c.projectID"
                            WHERE "p.category" = "$category"
                            GROUP BY "p.projectID"
                            ORDER BY COUNT("c.username")';
                        break;
                    case "money":
                        $pQuery = 'SELECT "p.projectID" FROM project p
                            LEFT JOIN contribute c ON "p.projectID" = "c.projectID"
                            WHERE "p.category" = "$category"
                            GROUP BY "p.projectID"
                            ORDER BY COUNT("c.amount")';
                        break;*/
                    default:
                        $pQuery = 'SELECT "projectID" FROM project
                            WHERE "category" = "'.$category.'" ORDER BY "'.$sort.'"';
                }
            }
            else{
                switch ($sort){
                /*  case "contribute":
                    $pQuery = "SELECT p.projectID FROM \"public\".\"project\" p
                                LEFT JOIN \"public\".\"contribute\" c ON p.projectID = c.projectID
                              GROUP BY p.projectID
                              ORDER BY COUNT(c.username)";
                    break;
                    case "money":
                        $pQuery = "SELECT p.projectID FROM \"public\".\"project\" p
                            LEFT JOIN \"public\".\"contribute\" c ON p.projectID = c.projectID
                            GROUP BY p.projectID
                            ORDER BY COUNT(c.amount)";
                    break;*/
                    default:
                        $pQuery = 'SELECT "projectID" FROM project
                            ORDER BY "'.$sort.'"';
                }
            }
        }

        $projectQuery = $pQuery;
    }

    function sanitize($data) {
        $data = trim($data);
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>

<!DOCTYPE HTML>
<html>
	<head> <title>Main Page</title> </head>
    <body>
        <table>
        <tr> <td colspan="2" text-align:center;">
        <h1> Crowd Funding</h1>

        <form method="post" action="<?php echo $_POST['PHP_SELF']; ?>">
            <?php
            if($name != ""){
                echo "Welcome ".$name; ?>
                <input type="submit" name="logOut" value="Log Out"><span style="color:red";><br>
            <?php
            } else{ ?>
            ID: <input type="text" name="userName" value="<?php echo $userName;?>"><span style="color:red";><?php echo $nameError;?></span>
            Password: <input type="password" name="password" value="<?php echo $password;?>"><span style="color:red";><?php echo $passwordError;?></span>

            <input type="submit" name="logIn" value="Log In"><span style="color:red";><?php echo $enterError;?></span><br>
            <input type="hidden" name="login" value="true">
            <?php
            }
            ?>
        </form>
        <a href='register.php'>Click here to register</a>
        <br\>
        </td> </tr>

        <tr>
        <td style="background-color:#eeeeee;">
        <form method="post" action="<?php echo $_POST['PHP_SELF']; ?>" enctype="multipart/form-data">
        	Project Title: <input type="text" name="projectTitle" value="<?php echo $projectTitle;?>">
        	<?php
			if($category != "") { 
			?>
			 	<select name="category">
                    <?php
                    echo "<option value=\"".$category."\">".$category."</option>"
                    ?>
                    <option value="">All</option>
        			<option value="Art">Art</option>
            		<option value="Comic">Comic</option>
            		<option value="Crafts">Crafts</option>
            		<option value="Dance">Dance</option>
            		<option value="Design">Design</option>
            		<option value="Fashion">Fashion</option>
            		<option value="Film&Video">Film and Video</option>
            		<option value="Food">Food</option>
            		<option value="Games">Games</option>
            		<option value="Journalism">Journalism</option>
            		<option value="Music">Music</option>
            		<option value="Photography">Photography</option>
            		<option value="Publishing">Publishing</option>
            		<option value="Technology">Technology</option>
            		<option value="Theather">Theather</option>
        		</select>
			<?php
			}
			else {
			?>
				<select name="category">
                    <option value="">All</option>
					<option value="Art">Art</option>
            		<option value="Comic">Comic</option>
            		<option value="Crafts">Crafts</option>
            		<option value="Dance">Dance</option>
            		<option value="Design">Design</option>
            		<option value="Fashion">Fashion</option>
            		<option value="Film&Video">Film&Video</option>
            		<option value="Food">Food</option>
            		<option value="Games">Games</option>
            		<option value="Journalism">Journalism</option>
            		<option value="Music">Music</option>
            		<option value="Photography">Photography</option>
            		<option value="Publishing">Publishing</option>
            		<option value="Technology">Technology</option>
            		<option value="Theather">Theather</option>
				</select>
			<?php
			}
			?>

			<input type="submit" name="searchSubmit" value="Search"/><span style="color:red";><?php echo $projectTitle; echo $category?></span>
			<input type="hidden" name="searched" value="true"/>
			<br><br><!-- 
		</form>

		<form method="post" action="<?php //echo $_POST['PHP_SELF']; ?>" enctype="multipart/form-data"> -->
        </td> </tr>

        <tr>
        <td style="background-color:#eeeeee;">
        <form method="post" action="<?php echo $_POST['PHP_SELF']; ?>" enctype="multipart/form-data">
			Order by:
			<?php
			if($sort != "startDate" && $sort != "") { 
			?>
				<select name = "sort">
                    <?php
                    echo "<option value=\"".$sort."\">".$sort."</option>"
                    ?>
					<option value="startDate">startDate</option>
					<option value="endDate">endDate</option>
					<option value="contribute">contribute</option>
					<option value="money">money</option>
				</select>
			<?php
			}
			else {
			?>
				<select name = "sort">
					<option value="startDate">startDate</option>
                    <option value="endDate">endDate</option>
                    <option value="contribute">contribute</option>
                    <option value="money">money</option>
				</select>
			<?php
			}
			?>

        	<input type="submit" name="sorting" value="Select"/><span style="color:red";><?php echo $sort;?></span>
        	<input type="hidden" name="sorted" value="true"/>
			<br><br>
        </form>
        <form method="post" action="<?php echo $_POST['PHP_SELF']; ?>">
			<?php
            if($pQuery != $projectQuery)
                $result = pg_query($projectQuery) or die('Query failed: ' . pg_last_error());
            else
                $result = pg_query($pQuery) or die('Query failed: ' . pg_last_error());


			while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
				foreach ($line as $col_value) {
					echo '<input type="submit" name="projectID" value='.$col_value.' style="height:50px; width:100px"/>';
            	}
        	}
			?>
			<input type="hidden" name="selected" value="true">

        	<?php
        	if($_GET['selected'] == "true") //redirection
        	{
        		$projectID = sanitize($_POST['projectID']);
        		header('Location: /view_project.php?id='.$projectID);
        	}
        	?>

        
		</form>
</td> </tr>

<tr>
<td colspan="2" style="background-color:#FFA500; text-align:center;"> Copyright &#169; CS2102_PROJECT23
</td> </tr>
</table>

</body>
</html>