<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["applicant_loggedin"]) || $_SESSION["applicant_loggedin"] !== true){
    header("location: applicant_login.php");
    exit;
}
require_once "config.php";
if(!empty($_GET["id"])){
  $job_id = $_GET["id"];
}
  
$cover_letter ='';

$cover_letter_err ='';

if($_SERVER["REQUEST_METHOD"] == "POST"){
// Validate email
if(empty(trim($_POST["cover_letter"]))){
  $cover_letter_err = "Please type your cover letter first.";
}
$cover_letter =trim($_POST["cover_letter"]);
$job_id = trim($_POST["job_id"]);
// Check input errors before inserting in database
if(empty($cover_letter_err)){
  
  $sql = "INSERT INTO tbl_job_applications (applicant_id, job_id, cover_letter) VALUES (?, ?, ?)";
  if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "iis", $_SESSION["applicant_id"], $job_id, $cover_letter);
    if(mysqli_stmt_execute($stmt)){
      // Redirect to jobs page
      header("location: job_list.php?feed=success");
  } else{
      header("location: job_list.php?feed=failed");
  }
            
  }
         
}

}


?>
 
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Apply for job</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include_once('inc/applicant_header.php'); ?>

<div class="container">
  <?php

  
  if(empty($_GET["id"])){
    echo "<h4 class='alert alert-danger'>Invalid job selected</h4>";
  }else{
    //$job_id = $_GET["id"];
    $sql = "SELECT job_title FROM tbl_job_list WHERE DATE( tbl_job_list.expiry_date ) > Now() AND job_id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
       // Bind variables to the prepared statement as parameters
       mysqli_stmt_bind_param($stmt, "s", $job_id);  
       // Attempt to execute the prepared statement
       if(mysqli_stmt_execute($stmt)){
          // Store result
          mysqli_stmt_store_result($stmt);
          if(mysqli_stmt_num_rows($stmt) == 1){ 
            mysqli_stmt_bind_result($stmt, $job_title);
            if(mysqli_stmt_fetch($stmt)){
              echo "<h4 class='alert alert-primary'>Apply Job: ". $job_title ."</h4>";
              include_once('inc/apply_job.php');

            }

          }else{
            echo "<h4 class='alert alert-danger'>The job selected is either invalid or has expired</h4>";
          }
       }
    }
        
  }
  
  ?>
  
</div>
    
</body>
</html>