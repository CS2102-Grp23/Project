<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class projectController extends BaseController {
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function test() {
    $getProjectID = 'SELECT "projectID" FROM project ORDER BY "projectID" DESC LIMIT 1';
    return DB::select($getProjectID);
    if ($resID) {
        $projectID = $resID[0]->projectID + 1;
    }

    return $projectID;
    /*
    $projectTitle = 'title';
    $shortBlurb = 'huh';
    $startDate = '12/12/2018';
    $endDate = '1/12/2018';
    $targetAmt = '500';
    $category = 'art';
    $imgUrl = 'C:/test/';
    $userName = 'turkey'; // make sure your database has a user named turkey
    $query = "INSERT INTO project VALUES('$projectID', '$projectTitle','$shortBlurb','$category','$startDate', '$endDate', '$targetAmt', '$imgUrl', '$userName')";
    return DB::insert($query*/
  }

  public function getAll() {
    $query = 'SELECT * FROM project ORDER BY "projectID" DESC';

    return DB::select($query);
  }

  public function getProject(Request $req, $id) {
    $query = "SELECT * FROM project where \"projectID\"='$id'";

    return DB::select($query);
  }

  public function create(Request $req) {
    $error = false;

    $projectID = 0;
    $projectTitle = $req->input('title');
    $shortBlurb = $req->input('description');
    $startDate = $req->input('startDate');
    $endDate = $req->input('endDate');
    $targetAmt = $req->input('targetAmount');
    $category = $req->input('category');
    $imgUrl = $req->input('imageUrl');
    $userName = 'turkey'; // make sure your database has a user named turkey

    $getProjectID = 'SELECT "projectID" FROM project ORDER BY "projectID" DESC LIMIT 1';
    $resID = DB::select($getProjectID);
    if ($resID) {
        $projectID = $resID[0]->projectID + 1;
    }

    //$imgUrl = file_get_contents($imgUrl);
    $imgUrl = '';

    /*
    if($imgUrl){
        $errors= array();
        $file_name = $_FILES['image']['name'];
        $file_size =$_FILES['image']['size'];
        $file_tmp =$_FILES['image']['tmp_name'];
        $file_type=$_FILES['image']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
        $expensions= array("jpeg","jpg","png");
        if(in_array($file_ext,$expensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        if($file_size > 2097152){
            $errors[]='File size must be excately 2 MB';
        }
        if(empty($errors)==true){
            $temp = end(explode(".", $file_name));
            $newfilename = $projectID . "." . $temp;
        }else{
            print_r($errors);
        }
    }*/

    // project title validation
    if (empty($projectTitle)) {
        $error = true;
        return "Please enter your project title.";
    }
    // project description validation
    if (empty($shortBlurb)) {
        $error = true;
        return "Please enter your project description.";
    }

    /*
    if (empty($startDate)) {
        $error = true;
        return "Please enter your project start date.";
    }
    else if (empty($endDate)) {
        $error = true;
        return "Please enter your project end date.";
    }
    else if ($endDate < $startDate || $startDate < date("d.m.y")) {
        $error = true;
        return "Please enter a valid date.";
    } */

    // project description validation
    if (empty($targetAmt)) {
        $error = true;
        return "Please enter an amount.";
    }
    else if (!preg_match("/^[1-9][0-9]*$/", $targetAmt)) {
        $error = true;
        return "Please enter a valid amount";
    }

    /*
    // redirect to sign up page if a non-member of the website is trying to create a project.
    if ($_SESSION['userName'] == '') {
        header("Location: register.php");
    }
    else{
        $username = $_SESSION['userName'];
    } */

    // if there's no error, continue to signup
    if( !$error ) {
        $query = "INSERT INTO project VALUES('$projectID', '$projectTitle','$shortBlurb','$category','$startDate', '$endDate', '$targetAmt', '$imgUrl', '$userName')";
        if (DB::insert($query)) {
            /*
            move_uploaded_file($file_tmp,"./image/".$newfilename);
            header('Location: view_project.php?id='.$projectID); */
            return 'SUCCESS';
        } else {
            $errMSG = "Something went wrong, please try again.";
            return 'ERROR';
        }
    } else {
      return 'ERROR';
    }
  }
  public function contribute(Request $req) {

        $contribution = sanitize($req->input('contribution'));
        $projectID = $req->input('projectID');

        if (empty($contribution) || $contribution < 0) {
            $error = true;
            $errorMessage = "Please enter a valid contribution.";
        }

		$username = $_SESSION['userName'];
		//using stored function in postgres, increments if same user contributing to same project, else insert
		$query = "DO $$ BEGIN PERFORM add_contribute(integer '".$projectID."', varchar '".$username."', '".$contribution."'::float8::numeric::money); END $$";

		/*
        $query = 'SELECT p.\"currentAmount\" FROM project p WHERE \"projectID\"='.$projectID;
        $newAmount = $contribution + $query;

        $query = "INSERT INTO project(\"currentAmount\") VALUES('$newAmount') WHERE \"projectID\" = $projectID"
        if (DB::insert($query)) {
                return 'SUCCESS';
            } else {
                $errMSG = "Something went wrong, please try again.";
                return 'ERROR';
            }
		*/

    }
    function sanitize($data) {
        $data = trim($data);
        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

?>
