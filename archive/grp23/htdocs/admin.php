<?php
    ob_start();
    session_start();
    if( isset($_SESSION['userName'])!="" ){
        header('Location: home.php');
    }

    include_once 'dbconnect.php';

    if($_SESSION['userName'] == ''){
    	header('Location: home.php');
    }
    else{
    	$userName = $_SESSION['userName'];
    	$check = "SELECT * FROM \"public\".\"users\" WHERE username = '$userName'";
    	$result = pg_query($query) or die('Query failed: ' . pg_last_error());

    	if(pg_fetch_result($result, 'accesslevel') == 'f'){
            	header('Location: /accessDenied.php'); exit();
        }
    }

    if (isset($_POST['logOut'])){
        $_SESSION['userName'] = "";
        header('Location: index.php'); exit();
    }

?>

<html>
<head> <title>Admin Page</title> </head>

<body>
<h1> Crowd Funding - Admin</h1>
hii
<form method="post" action="<?php echo $_POST['PHP_SELF']; ?>" enctype="multipart/form-data">
        Welcome admine <?php echo $_SESSION['$name']; ?> <input type="submit" name="logOut" value="Log Out"><br><br>
        
        <a href='manage_users.php'>Manage Users</a><br>
        <a href='manage_projects.php'>Manage Projects</a><br>

</form>

</body>
</html>