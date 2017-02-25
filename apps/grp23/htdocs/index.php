<html>
<head> <title>Main Page</title> </head>

<body>
<table>
<tr> <td colspan="2" style="background-color:#FFA500; text-align:center;">
<h1> Crowd Funding</h1>


<!--connect db by using php
    reference demo-3.php
-->

<form method="post">
        ID: <input type="text" name="userID" id="userID">
        Password: <input type="password" name="password" id="password">


        <input type="submit" name="loginSubmit" value="Log In" >
        <input type="hidden" name="inputIsFilled" value="true"/>
</form>
<a href='register.php'>Click here to register</a>
<br\>
</td> </tr>

<tr>
<td style="background-color:#eeeeee;">
<form>
        Project Name: <input type="text" name="projectName" id="projectName">
        <select name="Category"> <option value="">Select Category</option>
        <!--print categories by using php
        	reference demo-3.php
        < ?php
        $query = 'SELECT DISTINCT category FROM project';
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
         
        while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
           foreach ($line as $col_value) {
              echo "<option value=\"".$col_value."\">".$col_value."</option><br>";
            }
        }
        pg_free_result($result);
        ?>
        -->
        </select>


        <input type="submit" name="searchSubmit" value="Search" >
        <input type="hidden" name="inputIsFilled" value="true"/>
</form>
</td> </tr>

<tr>
<td style="background-color:#ffffff;">
<form>
		<br>
		Order by: 
		<?php
		if($_GET['formIsFilled'] != "true") { 
		?>
        	<select name="order"> <option value="Popularity">Popularity</option>
        		<option value="Money">Money</option>
        		<option value="Like">Like</option>
        	</select>
        <?php
    	} else { //It was already sorted
        ?>
			<select name="order">
			<?php
				echo "<option value=\"".$_GET['order']."\">".$_GET['order']."</option>"
			?>
				<option value="Popularity">Popularity</option>
        		<option value="Money">Money</option>
        		<option value="Like">Like</option>
        	</select>
		<?php
		}
		?>

        <input type="submit" name="sorting" value="Select"/>
        <input type="hidden" name="formIsFilled" value="true"/>
		<br><br>
        
        <!--print projects by using php
        ADD (title, category condition)

        $query = 'SELECT p.pid FROM project ORDER BY ?';
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());

        if(".$_GET['order']." = "Money") {
        	$query = 'SELECT category FROM project ORDER BY ??';
        	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
        }
        else if(".$_GET['order']." = "Like") {
        	$query = 'SELECT category FROM project ORDER BY ???';
        	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
        }
         
        while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
           foreach ($line as $col_value) {
              echo "<option value=\"".$col_value."\">".$col_value."</option><br>";
            }
        }
        pg_free_result($result);
        -->

        <!--It is just for print-->
        <input type="submit" name="projectID" id="Format1" value="project1" style="height:50px; width:100px"/>
        <input type="submit" name="projectID" id="Format2" value="project2" style="height:50px; width:100px"/>
        <input type="submit" name="projectID" id="Format3" value="project3" style="height:50px; width:100px"/>
        <input type="submit" name="projectID" id="Format4" value="project4" style="height:50px; width:100px"/>
        <input type="submit" name="projectID" id="Format5" value="project5" style="height:50px; width:100px"/>
        <input type="submit" name="projectID" id="Format6" value="project6" style="height:50px; width:100px"/>

        <?php
        if($_GET['projectID'] == "project1") //redirection
        {
        	header('Location: /helloworld.php'); exit();
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
