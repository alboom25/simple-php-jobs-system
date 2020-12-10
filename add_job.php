<?php

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["employer_loggedin"]) || $_SESSION["employer_loggedin"] !== true){
    header("location: employer_login.php");
    exit;
}
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$job_title = $job_description = $expiry_date = "";
$job_title_err = $job_description_err = $expiry_date_err  = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate job title
    if(empty(trim($_POST["job_title"]))){
        $job_title_err = "Please enter a job title.";
    }
    // Validate job description
    if(empty(trim($_POST["job_description"]))){
        $job_description_err = "Please enter a job description.";     
    }
     
    // Validate expiry date
    if(empty(trim($_POST["expiry_date"]))){
        $expiry_date_err = "Please enter job expiry date.";     
    } 
    
    // Check input errors before inserting in database
    if(empty($job_description_err) && empty($job_title_err) && empty($expiry_date_err)){

        $job_title = trim($_POST["job_title"]);
        $job_description = trim($_POST["job_description"]);
        $expiry_date = trim($_POST["expiry_date"]);
        
        // Prepare an insert statement
        $sql = "INSERT INTO tbl_job_list (job_title, job_description, expiry_date, employer_id) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $job_title, $job_description, $expiry_date, $_SESSION["employer_id"]);
            
                       
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to dashboard page
                header("location: employer_jobs.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Job</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include_once('inc/employer_header.php');?>

<div class='d-flex justify-content-center'>
    <div class="card wrapper-large">
        <h2>Add new job</h2>
        <p>Please fill this form to create a new job.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">            
            <div class="form-group <?php echo (!empty($job_title_err)) ? 'has-error' : ''; ?>">
                <label>Job Title</label>
                <input type="text" name="job_title" class="form-control" value="<?php echo $job_title; ?>">
                <span class="help-block"><?php echo $job_title_err; ?></span>
            </div>                
            <div class="form-group <?php echo (!empty($job_description_err)) ? 'has-error' : ''; ?>">
                <label>Description</label>
                <textarea name="job_description" rows="5" class="form-control" cols="40"><?php echo $job_description;?></textarea>                
                <span class="help-block"><?php echo $job_description_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($expiry_date_err)) ? 'has-error' : ''; ?>">
                <label>Expiry Date</label>
                <input class="form-control" type="date" name="expiry_date" value="<?php echo $expiry_date; ?>">                
                <span class="help-block"><?php echo $expiry_date_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>           
        </form>
    </div> 
    </div>   
</body>
</html>