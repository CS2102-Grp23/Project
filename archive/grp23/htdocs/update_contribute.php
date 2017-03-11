<?php
    ob_start();
    session_start();
    if( isset($_SESSION['userName'])!="" ){
        header("Location: home.php");
    }

    include_once 'dbconnect.php';
    $id = intval($_GET['id']);
    var_dump($id);
    
    if (isset($_POST['submit'])) {

        
        $contribution = sanitize($_POST['contribution']);
        $query = 'SELECT "currentAmount" FROM project WHERE "projectID"='.$id;
        $res = pg_query($query) or die('Query failed: ' . pg_last_error());


        if (pg_num_rows($res) > 0) {
            $row = pg_fetch_object($res);

            $newCurrentAmount = $contribution + $row->currentAmount;
            $query = 'UPDATE project SET "currentAmount"='.$newCurrentAmount.'WHERE "projectID"='.$id;
            $res = pg_query($query) or die('Query failed: ' . pg_last_error());
            if($res) {
                header('Location: view_project.php?id='.$id);
            }
            else {
                echo "Unable to update contribution.";
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