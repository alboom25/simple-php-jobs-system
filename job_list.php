<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["applicant_loggedin"]) || $_SESSION["applicant_loggedin"] !== true){
    header("location: applicant_login.php");
    exit;
}
require_once "config.php";

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    
<body>
<?php include_once('inc/applicant_header.php'); ?>
<?php
  if(!empty($_GET["feed"])){
    if($_GET["feed"]=='success'){
        echo '<div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> Your job application was successful
      </div>';
    }else{
      echo '<div class="alert alert-warning alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>Warning!</strong> Unable to submit your job application. Please try again!
    </div>';
    }    
  }
 ?>
<?php include_once('inc/inc_jobs_list.php'); ?>

    
</body>
</html>