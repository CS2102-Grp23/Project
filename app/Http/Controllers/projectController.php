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
    echo 'hello world';
  }

  public function getAll() {
    $query = "SELECT * FROM project";

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
//    echo $projectID;

    /*
    if(isset($_FILES['image'])){
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
  /*  if (empty($projectTitle)) {
        $error = true;
        $projectTitleError = "Please enter your project title.";
    }
    // project description validation
    if (empty($shortBlurb)) {
        $error = true;
        $shortBlurbError = "Please enter your project description.";
    }
    if (empty($startDate)) {
        $error = true;
        $startDateError = "Please enter your project start date.";
    }
    else if (empty($endDate)) {
        $error = true;
        $endDateError = "Please enter your project end date.";
    }
    else if ($endDate < $startDate || $startDate < date("d.m.y")) {
        $error = true;
        $endDateError = "Please enter a valid date.";
    }

    // project description validation
    if (empty($targetAmt)) {
        $error = true;
        $targetAmtError = "Please enter an amount.";
    }
    else if (!preg_match("/^[1-9][0-9]*$/", $targetAmt)) {
        $error = true;
        $targetAmtError = "Please enter a valid amount";
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
        $query = "INSERT INTO project VALUES('$projectID', '$projectTitle','$shortBlurb','$category','$startDate', '$endDate', '$targetAmt', '0', '$imgUrl', '$userName')";
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
}

?>