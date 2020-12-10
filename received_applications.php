<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["employer_loggedin"]) || $_SESSION["employer_loggedin"] !== true){
    header("location: employer_login.php");
    exit;
}
require_once "config.php";

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ReceivedApplications</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    
<body>
<?php include_once('inc/employer_header.php'); ?>
<?php include_once('inc/received_applications.php'); ?>

    
</body>
</html>