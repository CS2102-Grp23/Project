<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class adminController extends BaseController {
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function test() {
    echo 'hello world!';
  }

  public function getNoActivity() {
    $query = 'SELECT u.username FROM users u WHERE u.username NOT IN(SELECT p.username FROM project p UNION SELECT c.username FROM contribute c)';

    return DB::select($query);
  }
  
  public function getNoActivitySummary() {
    $query = 'SELECT u.username FROM users u WHERE u.username NOT IN(SELECT p.username FROM project p UNION SELECT c.username FROM contribute c) LIMIT 10';

    return DB::select($query);
  }
  
  public function getNoProject() {
    $query = 'SELECT u.username FROM users u WHERE u.username NOT IN(SELECT p.username FROM project p)';

    return DB::select($query);
  }
  
  public function getNoProjectSummary() {
    $query = 'SELECT u.username FROM users u WHERE u.username NOT IN(SELECT p.username FROM project p) LIMIT 10';

    return DB::select($query);
  }
  
  public function getNoContribute() {
    $query = 'SELECT u.username FROM users u WHERE u.username NOT IN(SELECT c.username FROM contribute c)';

    return DB::select($query);
  }
  
   public function getNoContributeSummary() {
    $query = 'SELECT u.username FROM users u WHERE u.username NOT IN(SELECT c.username FROM contribute c) LIMIT 10';

    return DB::select($query);
  }
  
  public function getTopContributors() {
    $query = 'SELECT c.username, SUM(c.amount) FROM contribute c GROUP BY c.username ORDER BY SUM(c.amount) DESC';

    return DB::select($query);
  }
  
  public function getTopContributorsSummary() {
    $query = 'SELECT c.username, SUM(c.amount) FROM contribute c GROUP BY c.username ORDER BY SUM(c.amount) DESC LIMIT 10';

    return DB::select($query);
  }
  
  public function getTopFulfilledProjects() {
	$query = 'SELECT p.username, COUNT(*) FROM project p, (SELECT p1."projectID", SUM(c.amount) as raised FROM project p1, contribute c WHERE c."projectID" = p1."projectID" GROUP BY p1."projectID") p2 WHERE p."targetAmount" <= p2.raised AND p."projectID" = p2."projectID" GROUP BY p.username ORDER BY COUNT(*) DESC LIMIT 10';

    return DB::select($query);
  }
  
  public function getTopFulfilledProjectsSummary() {
	$query = 'SELECT p.username, COUNT(*) FROM project p, (SELECT p1."projectID", SUM(c.amount) as raised FROM project p1, contribute c WHERE c."projectID" = p1."projectID" GROUP BY p1."projectID") p2 WHERE p."targetAmount" <= p2.raised AND p."projectID" = p2."projectID" GROUP BY p.username ORDER BY COUNT(*) DESC LIMIT 10';

    return DB::select($query);
  }
  
  public function getTopPairOfSimilarUsers() {
	$query = 'SELECT u1.username, u2.username, COUNT(*) FROM public.users u1 LEFT JOIN public.contribute c1 ON c1.username = u1.username, public.users u2 LEFT JOIN public.contribute c2 ON c2.username = u2.username WHERE u1.email < u2.email AND c1."projectID" = c2."projectID" GROUP BY u1.username, u2.username ORDER BY COUNT(*) DESC';

    return DB::select($query);
  }
  
  public function getTopPairOfSimilarUsersSummary() {
	$query = 'SELECT u1.username, u2.username, COUNT(*) FROM public.users u1 LEFT JOIN public.contribute c1 ON c1.username = u1.username, public.users u2 LEFT JOIN public.contribute c2 ON c2.username = u2.username WHERE u1.email < u2.email AND c1."projectID" = c2."projectID" GROUP BY u1.username, u2.username ORDER BY COUNT(*) DESC LIMIT 10';

    return DB::select($query);
  }
  
  public function getTopNationContributor() {
	$query = 'SELECT u.nationality, SUM(c.amount) FROM users u, contribute c WHERE u.username = c.username AND u.nationality IS NOT NULL GROUP BY u.nationality ORDER BY SUM(c.amount) DESC';

    return DB::select($query);
  }
  
  public function getTopNationContributorSummary() {
	$query = 'SELECT u.nationality, SUM(c.amount) FROM users u, contribute c WHERE u.username = c.username AND u.nationality IS NOT NULL GROUP BY u.nationality ORDER BY SUM(c.amount) DESC LIMIT 10';

    return DB::select($query);
  }
  
  public function getTopNationProjectCount() {
	$query = 'SELECT u.nationality, COUNT(*) FROM users u, project p WHERE u.username = p.username AND u.nationality IS NOT NULL GROUP BY u.nationality ORDER BY COUNT(*) DESC';

    return DB::select($query);
  }
  
  public function getTopNationProjectCountSummary() {
	$query = 'SELECT u.nationality, COUNT(*) FROM users u, project p WHERE u.username = p.username AND u.nationality IS NOT NULL GROUP BY u.nationality ORDER BY COUNT(*) DESC LIMIT 10';

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
}

?>
