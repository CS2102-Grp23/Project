<?php

    ob_start();
    session_start();
    if( isset($_SESSION['userName'])!="" ){
        header("Location: home.php");
    }

    include_once 'dbconnect.php';

    echo "<br><h2>Your access was denied</h2>
        Sorry. You are not our administrator.
        <p><a href='index.php'>Go back to main page</a>"

?>