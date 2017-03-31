<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class authController extends BaseController {
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function test() {
    echo 'hello world!';
  }

  //search based on input for title/description, order by most popular (most number of contributes, not amount contributed)
  public function searchQuery(Request $req) {
    
	$searchQuery = $req->input('search');
	$query = "SELECT DISTINCT(p.\"projectID\"), p.title, p.category, p.\"startDate\", p.\"endDate\", p.\"targetAmount\" FROM project p, contribute c WHERE (title LIKE '%".$searchQuery."%' OR description LIKE '%".$searchQuery."%') AND p.\"projectID\" = c.\"projectID\" GROUP BY p.\"projectID\", c.\"projectID\" ORDER BY COUNT(c.username) DESC";

    return DB::select($query);
  }
  
  //search based on input for title/description, order by most popular (most number of contributes, not amount contributed)
  //check additional based on UI branch
  public function searchQuery(Request $req) {
    
	$searchQuery = $req->input('search');
	$username = $_SESSION['userName'];
	//$startDate = $req->input('startDate'); //order by popularity better?
	
	//booleans?
	$ownProject = $req->input('ownProject');
	$contributedProject = $req->input('contributedProject');
	$query = "SELECT DISTINCT(p.\"projectID\"), p.title, p.category, p.\"startDate\", p.\"endDate\", p.\"targetAmount\" FROM project p, contribute c WHERE p.\"projectID\" = c.\"projectID\" ";
	
	if(!empty($searchQuery)) {
		$query = $query . "AND (title LIKE '%".$searchQuery."%' OR description LIKE '%".$searchQuery."%') ";
	}
	if($ownProject && $contributedProject) {
		$query = $query . "AND (p.username = '".$username."' OR c.username = '".$username."') "
	}
	else if(!$ownProject && $contributedProject) {
		$query = $query . "AND c.username = '".$username."' ";
	}
	else if($ownProject && !$contributedProject) {
		$query = $query . "AND p.username = '".$username."' ";
	}
	
	$query = $query . "GROUP BY p.\"projectID\", c.\"projectID\" ORDER BY COUNT(c.username) DESC";
	
	/*
	if($ownProject && $contributedProject) {	//both created and contributed
		$query = "SELECT DISTINCT(p.\"projectID\"), p.title, p.category, p.\"startDate\", p.\"endDate\", p.\"targetAmount\" FROM project p, contribute c WHERE (title LIKE '%".$searchQuery."%' OR description LIKE '%".$searchQuery."%') AND p.\"projectID\" = c.\"projectID\" AND (p.username = '".$username."' or c.username = '".$username."') GROUP BY p.\"projectID\", c.\"projectID\" ORDER BY COUNT(c.username) DESC";
	}
	else if(!$ownProject && $contributedProject) {	//only contributed
		$query = "SELECT DISTINCT(p.\"projectID\"), p.title, p.category, p.\"startDate\", p.\"endDate\", p.\"targetAmount\" FROM project p, contribute c WHERE (title LIKE '%".$searchQuery."%' OR description LIKE '%".$searchQuery."%') AND p.\"projectID\" = c.\"projectID\" AND c.username = '".$username."' GROUP BY p.\"projectID\", c.\"projectID\" ORDER BY COUNT(c.username) DESC";
	}
	else if($ownProject && !$contributedProject) {	//only created
		$query = "SELECT DISTINCT(p.\"projectID\"), p.title, p.category, p.\"startDate\", p.\"endDate\", p.\"targetAmount\" FROM project p, contribute c WHERE (title LIKE '%".$searchQuery."%' OR description LIKE '%".$searchQuery."%') AND p.\"projectID\" = c.\"projectID\" AND p.username = '".$username."' GROUP BY p.\"projectID\", c.\"projectID\" ORDER BY COUNT(c.username) DESC";
	}
	else {
		$query = "SELECT DISTINCT(p.\"projectID\"), p.title, p.category, p.\"startDate\", p.\"endDate\", p.\"targetAmount\" FROM project p, contribute c WHERE (title LIKE '%".$searchQuery."%' OR description LIKE '%".$searchQuery."%') AND p.\"projectID\" = c.\"projectID\" GROUP BY p.\"projectID\", c.\"projectID\" ORDER BY COUNT(c.username) DESC";
	}
	*/

    return DB::select($query);
  }
  
  //search based on category, order by most popular (most number of contributes, not amount contributed)
  public function searchCategory(Request $req) {
    
	$searchCategory = $req->input('category');
	$query = "SELECT DISTINCT(p.\"projectID\"), p.title, p.category, p.\"startDate\", p.\"endDate\", p.\"targetAmount\" FROM project p, contribute c WHERE category = '".$searchQuery."' AND p.\"projectID\" = c.\"projectID\" GROUP BY p.\"projectID\", c.\"projectID\" ORDER BY COUNT(c.username) DESC";

    return DB::select($query);
  }
}

?>
