<?php
    ob_start();
    session_start();
    if( isset($_SESSION['userName'])!="" ){
        header("Location: home.php");
    }

    include_once 'dbconnect.php';

    $error = false;

    $id = $_GET['id'];
    if($id){
        $query = "SELECT name, email FROM \"public\".\"users\" WHERE username = '$id'";
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        $row = pg_fetch_object($result);
        $name = $row->name;
        $email = $row->email;
    }

    if (isset($_POST['submit']) ) {

        // clean user inputs to prevent sql injections
        $name = sanitize($_POST['userFullName']);
        $email = sanitize($_POST['email']);
        $newPassword = sanitize($_POST['newPassword']);
        $password = sanitize($_POST['password']);

        // basic name validation
        if (empty($name)) {
            $error = true;
            $nameError = "Please enter your full name.";
        } else if (strlen($name) < 3) {
            $error = true;
            $nameError = "Name must have at least 3 characters.";
        } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
            $error = true;
            $nameError = "Name must contain alphabets and space.";
        }

        //basic email validation
        if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $error = true;
            $emailError = "Please enter your email address.";
        } else {
            // check email exist or not
            $query = "SELECT email FROM \"public\".\"users\" WHERE email='$email' AND username <> '$id'";
            $result = pg_query($query);
            $count = pg_num_rows($result);
            if($count!=0){
                $error = true;
                $emailError = "Email is already in use.";
            }
        }
        
        // password validation
        if (empty($password) && empty($newPassword)){
            $query = "SELECT password FROM \"public\".\"users\" WHERE username = '$id'";
            $result = pg_query($query) or die('Query failed: ' . pg_last_error());
            $row = pg_fetch_object($result);
            $hashPassword = $row->password;
        }
        else{
            if(strlen($password) < 6) {
                $error = true;
                $passwordError = "Password must have at least 6 characters.";
            }
            else if($password != $newPassword) {
                $error = true;
                $passwordError = "You have entered the wrong password.";
            }
            else{
                // password encrypt using SHA256();
                $hashPassword = hash('sha256', $password);
            }
        }

        // if there's no error, continue to signup
        if( !$error ) {
            $query = "UPDATE \"public\".\"users\" SET name = '$name', email = '$email', password = '$hashPassword' WHERE username = '$id'";

            $res = pg_query($query) or die('Query failed: ' . pg_last_error());

            if ($res) {
                unset($name);
                unset($email); 
                unset($userName);
                unset($password);
                unset($newPassword);
                header("Location: manage_users.php");
            } else {
                $errMSG = "Something went wrong, try again."; 
            }
        }
        else{
            unset($name);
            unset($email); 
            unset($userName);
            unset($password);
            unset($newPassword);
        }
    }

    function sanitize($data) {
        $data = trim($data);
        $data = strip_tags($data);
        //$data = htmlspecialchars($data);
        return $data;
    }

?>


<!DOCTYPE HTML>  
<html>
    <body>  
        <h1>Edit User's Information</h1>
        <form method="post" action="<?php echo $_POST['PHP_SELF']; ?>">
            New Name: <input type="text" name="userFullName" value="<?php echo $name;?>"><span style="color:red";><?php echo $nameError;?></span>	
            <br>
            New Email: <input type="text" name="email" value="<?php echo $email;?>"><span style="color:red";><?php echo $emailError;?></span>
            <br>
            New Password: <input type="password" name="newPassword" value="<?php echo $newPassword;?>"><span style="color:red";><?php echo $passwordError;?></span>
            <br>
            Confirmed Password: <input type="password" name="password" value="<?php echo $password;?>"><span style="color:red";><?php echo $passwordError;?></span>
            <br><br>
            <input type="submit" name="submit" value="Submit"><span style="color:red";><?php echo $errMSG; ?></span><br>
        </form>
    </body>
</html>

