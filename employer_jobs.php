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
    <title>Welcome Employer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include_once('inc/employer_header.php');?>

<div class="container">
  <h2>My Jobs</h2>
  
  <p>Manage all your job postings here</p>            
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Job Id</th>       
        <th>Title</th>
        <th>Description</th>
        <th>Expiry Date</th>
        <th>Applications</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT
      tbl_job_list.job_id,
      tbl_job_list.job_title,
      tbl_job_list.job_description,
      tbl_job_list.expiry_date,
      IFNULL( COUNT( tbl_job_applications.application_id ), 0 ) AS applications 
    FROM
      tbl_job_list
      LEFT JOIN tbl_job_applications ON tbl_job_applications.job_id = tbl_job_list.job_id 
    WHERE
      tbl_job_list.employer_id = ". $_SESSION["employer_id"]."
    GROUP BY
      tbl_job_list.job_id;";
      
      $result = mysqli_query($link, $sql);
      
      if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
              echo "
              <tr>
              <td>" . $row["job_id"]. "</td>             
              <td>" . $row["job_title"]. "</td>
              <td>" . $row["job_description"]. "</td>
              <td>" . $row["expiry_date"]. "</td>
              <td>" . $row["applications"]. "</td>
              <td><a class='btn btn-success' href='edit_job.php?id=" . $row["job_id"]. "'>Edit</a></td>
                </tr>";
             
          }
      } else {
          echo "<h4 class='alert alert-danger'>You have not posted any job</h4>";
      }      
      mysqli_close($link);
      ?>
    </tbody>
  </table>
</div>
    
</body>
</html>