<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class searchController extends BaseController {
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function test() {
    echo 'hello world!';
  }
    
  //search based on input for title/description, order by most popular (most number of contributes, not amount contributed)
  //check additional based on UI branch
  public function searchQuery(Request $req) {
    
	$searchQuery = $req->input('search');
	$username = app('App\Http\Controllers\authController')->getUsername();
	//$startDate = $req->input('startDate'); //order by popularity better?
	
	//booleans?
	$ownProject = $req->input('ownProject');
	$contributedProject = $req->input('contributedProject');
	
	/* //test vars
	$searchQuery = 'test';
	//$username = 'test1';
	$ownProject = true;
	$contributedProject = false;
	*/
	
	$query = "SELECT DISTINCT(p.\"projectID\"), p.title, p.category, p.\"startDate\", p.\"endDate\", p.\"targetAmount\", COUNT(c.username), c.\"projectID\" FROM project p, contribute c WHERE p.\"projectID\" = c.\"projectID\" ";
	
	if(!empty($searchQuery)) {
		$query = $query . "AND (title LIKE '%".$searchQuery."%' OR description LIKE '%".$searchQuery."%') ";
	}
	if($ownProject && $contributedProject) {
		$query = $query . "AND (p.username = '".$username."' OR c.username = '".$username."') ";
	}
	else if(!$ownProject && $contributedProject) {
		$query = $query . "AND c.username = '".$username."' ";
	}
	else if($ownProject && !$contributedProject) {
		$query = $query . "AND p.username = '".$username."' ";
	}
	
	$query = $query . "GROUP BY p.\"projectID\", c.\"projectID\" ORDER BY COUNT(c.username) DESC";

    return DB::select($query);
  }
  
  //search based on category, order by most popular (most number of contributes, not amount contributed)
  public function searchCategory(Request $req) {
    
	$searchCategory = $req->input('category');
	
	//test vars
	//$searchCategory = 'Technology';
	
	$query = "SELECT DISTINCT(p.\"projectID\"), p.title, p.category, p.\"startDate\", p.\"endDate\", p.\"targetAmount\", COUNT(c.username), c.\"projectID\" FROM project p, contribute c WHERE category = '".$searchCategory."' AND p.\"projectID\" = c.\"projectID\" GROUP BY p.\"projectID\", c.\"projectID\" ORDER BY COUNT(c.username) DESC";
	
    return DB::select($query);
  }
}

?>
