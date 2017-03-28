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
  
  //search based on category, order by most popular (most number of contributes, not amount contributed)
  public function searchCategory(Request $req) {
    
	$searchCategory = $req->input('category');
	$query = "SELECT DISTINCT(p.\"projectID\"), p.title, p.category, p.\"startDate\", p.\"endDate\", p.\"targetAmount\" FROM project p, contribute c WHERE category = '".$searchQuery."' AND p.\"projectID\" = c.\"projectID\" GROUP BY p.\"projectID\", c.\"projectID\" ORDER BY COUNT(c.username) DESC";

    return DB::select($query);
  }
}

?>
