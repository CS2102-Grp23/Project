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
}

?>
