<?php

    ob_start();
    session_start();
    if( isset($_SESSION['userName'])!="" ){
        header("Location: home.php");
    }

    include_once 'dbconnect.php';

    echo "<br><h2>Thanks for registering!</h2>
        Your registration is now complete.
        <p><a href='login.php'>Click here to login</a>"

?>