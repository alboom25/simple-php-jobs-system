<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to jobs page
if(isset($_SESSION["applicant_loggedin"]) && $_SESSION["applicant_loggedin"] === true){
  header("location: job_list.php");
  exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email_address = $password = "";
$email_address_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["email_address"]))){
        $email_address_err = "Please enter your email.";
    } else{
        $email_address = trim($_POST["email_address"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_address_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT applicant_id, first_name, last_name, email_address, `password` FROM tbl_applicants WHERE email_address = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $email_address);            
           
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $applicant_id, $first_name, $last_name, $email_address, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["applicant_loggedin"] = true;
                            $_SESSION["applicant_id"] = $applicant_id;
                            $_SESSION["applicant_email_address"] = $email_address; 
                            $_SESSION["applicant_first_name"] = $first_name; 
                            $_SESSION["applicant_last_name"] = $last_name;                           
                            
                            // Redirect user to jobs page
                            header("location: job_list.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_address_err = "No account found with that emails.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Applicant Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class='d-flex justify-content-center container'>
    <div class="card wrapper">
        <h2>Applicant Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_address_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email_address" class="form-control" value="<?php echo $email_address; ?>">
                <span class="help-block"><?php echo $email_address_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="applicant_register.php">Sign up now</a>.</p>
        </form>
    </div> 
</div>   
</body>
</html>