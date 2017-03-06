<?php
    ob_start();
    session_start();
    if( isset($_SESSION['userName'])!="" ){
        header("Location: home.php");
    }

    include_once 'dbconnect.php';


    $error = false;

    if (isset($_POST['submit']) ) {

        // clean user inputs to prevent sql injections
        $name = sanitize($_POST['userFullName']);
        $userName = sanitize($_POST['userName']);
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

        // basic username validation
        if (empty($userName)) {
            $error = true;
            $userNameError = "Please enter a valid user name .";
        } else if (strlen($userName) < 6) {
            $error = true;
            $userNameError = "Name must have at least 6 characters.";
        } else if (!preg_match("/[a-zA-Z]/", $userName)) {
            $error = true;
            $userNameError = "Name must contain alphabets.";
        }
        else {
            // check username exist or not
            $query = "SELECT username FROM \"public\".\"users\" WHERE username='$userName'";
            $result = pg_query($query);
            $count = pg_num_rows($result);
			
            if($count>0){
                $error = true;
                $emailError = "Username is already in use.";
            }
        }

        //basic email validation
        if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $error = true;
            $emailError = "Please enter your email address.";
        } else {
            // check email exist or not
            $query = "SELECT email FROM \"public\".\"users\" WHERE email='$email'";
            $result = pg_query($query);
            $count = pg_num_rows($result);
            if($count!=0){
                $error = true;
                $emailError = "Email is already in use.";
            }
        }
        
        // password validation
        if (empty($password) || empty($newPassword)){
            $error = true;
            $passwordError = "Please enter password.";
        } else if(strlen($password) < 6) {
            $error = true;
            $passwordError = "Password must have at least 6 characters.";
        }
        else if($password != $newPassword) {
            $error = true;
            $passwordError = "You have entered the wrong password.";
        }

        // password encrypt using SHA256();
        $password = hash('sha256', $password);

        // if there's no error, continue to signup
        if( !$error ) {
            $query = "INSERT INTO \"public\".\"users\" VALUES('$userName', '$password', 'FALSE', '$email','$name')";

            $res = pg_query($query) or die('Query failed: ' . pg_last_error());

            if ($res) {
                unset($name);
                unset($email); 
                unset($userName);
                unset($password);
                header("Location: thank-you-registration.php");
            } else {
                $errMSG = "Something went wrong, try again."; 
            } 

        }

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
    <body>  
        <h1>Sign Up </h1>
        <form method="post" action="<?php echo $_POST['PHP_SELF']; ?>">
            Name: <input type="text" name="userFullName" value="<?php echo $name;?>"><span style="color:red";><?php echo $nameError;?></span>	
            <br>
            Username: <input type="text" name="userName" value="<?php echo $userName;?>"><span style="color:red";><?php echo $userNameError;?></span>
            <br>
            Email: <input type="text" name="email" value="<?php echo $email;?>"><span style="color:red";><?php echo $emailError;?></span>
            <br>
            New Password: <input type="password" name="newPassword" value="<?php echo $newPassword;?>"><span style="color:red";><?php echo $passwordError;?></span>
            <br>
            Confirmed Password: <input type="password" name="password" value="<?php echo $password;?>"><span style="color:red";><?php echo $passwordError;?></span>
            <br><br>
            <input type="submit" name="submit" value="Submit"><span style="color:red";><?php echo $errMSG; ?></span><br> 

        </form>
    </body>
</html>

