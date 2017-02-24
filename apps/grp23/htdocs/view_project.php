<?php
    ob_start();
    session_start();
    if( isset($_SESSION['userName'])!="" ){
        header("Location: home.php");
    }

    include_once 'dbconnect.php';

    $id = intval($_GET['id']);
    if ($id) {
        $query = 'SELECT "title", "description", "category", "startDate", "endDate", "targetAmount", "currentAmount", "imageURL" FROM project WHERE "projectID"='.$id;
        $res = pg_query($query) or die('Query failed: ' . pg_last_error());


        if (pg_num_rows($res) > 0) {
            $row = pg_fetch_object($res);

            echo "<br><b>Project Title: </b>" . $row->title . "<br>"; 
            echo "<br><b>Description: </b>" . $row->description. "<br>";
            echo "<br><b>Category: </b>" . $row->category . "<br>";
            echo "<br><b>Start Date: </b>" . $row->startDate . "<br>";
            echo "<br><b>End Date: </b>" . $row->endDate . "<br>";
            echo "<br><b>Current Amount Raised: </b>" . $row->currentAmount . "<br><br>";

            $location = "./image/".$row->imageURL;
            echo '<img src="'.$location.'"/><br><br>';

        }

    }

    echo '<br><b>Contribute To This Project</b><br><form action="update_contribute.php?id='.$id.'" method="post">
            <input type="text" name="contribution"> 
            <input type="submit" value="Submit" name="submit">
        </form>';


?>