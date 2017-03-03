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
  
  public function getAllUsers() {
    $query = "SELECT * FROM users";

    return DB::select($query);
  }
  
  public function getUser() {
    $value = session('email');
    $query = "SELECT * FROM users WHERE email='$value'";
    
    return  DB::select($query);
  }
  
  public function logout() {
    session()->flush();
  }

  public function login(Request $req) {
    $email = $req->input('email');
    $password = $req->input('password');

    $password = hash('sha256', $password);

    $query = "SELECT email FROM users WHERE email='$email' AND password='$password'";
    $res = DB::select($query);
    $count = count($res);

    if($count > 0) {
      session(['email' => $email]);
      
      return 'SUCCESS';
    } else {
      return 'ERROR';
    }
  }

  public function signup(Request $req) {
    $error = false;
    $errorMessage = "none";

    $name = $req->input('name');
    $userName = $req->input('userName');
    $email = $req->input('email');
    $password = $req->input('password');
    $confirmPassword = $req->input('confirmPassword');

    // basic name validation
    if (empty($name)) {
      $error = true;
      $errorMessage = "Please enter your full name.";
    } else if (strlen($name) < 3) {
      $error = true;
      $errorMessage = "Name must have at least 3 characters.";
    } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
      $error = true;
      $errorMessage = "Name must contain alphabets and space.";
    }

    // basic username validation
    if (empty($userName)) {
      $error = true;
      $errorMessage = "Please enter a valid user name .";
    } else if (strlen($userName) < 6) {
      $error = true;
      $errorMessage = "Name must have at least 6 characters.";
    } else if (!preg_match("/[a-zA-Z]/", $userName)) {
      $error = true;
      $errorMessage = "Name must contain alphabets.";
    } else {
      // check username exist or not
      $query = "SELECT username FROM users WHERE username='$userName'";
      $res = DB::select($query);
      $count = count($res);
      if($count != 0){
        $error = true;
        $emailError = "Username is already in use.";
      }
    }

    //basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = true;
      $errorMessage = "Please enter your email address.";
    } else {
      // check email exist or not
      $query = "SELECT email FROM users WHERE email='$email'";
      $res = DB::select($query);
      $count = count($res);
      if($count!=0){
        $error = true;
        $emailError = "Email is already in use.";
      }
    }

    // password validation
    if (empty($password) || empty($confirmPassword)){
      $error = true;
      $errorMessage = "Please enter password.";
    } else if(strlen($password) < 6) {
      $error = true;
      $errorMessage = "Password must have at least 6 characters.";
    } else if($password !== $confirmPassword) {
      $error = true;
      $errorMessage = "You have entered the wrong password.";
    }

    // password encrypt using SHA256();
    $password = hash('sha256', $password);
    // if there's no error, continue to signup
    if(!$error) {
      $query = "INSERT INTO users VALUES('$userName', '$password', 'FALSE', '$email','$name')";
      if (DB::insert($query)) {
        unset($name);
        unset($email);
        unset($userName);
        unset($password);
        
        session(['email' => $email]);
        
        return 'SUCCESS';
      }
    } else {
     return 'ERROR';
    }
  }

  function sanitize($data) {
      $data = trim($data);
      $data = strip_tags($data);
      $data = htmlspecialchars($data);
      return $data;
  }
}

?>
