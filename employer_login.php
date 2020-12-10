<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to jobs page
if(isset($_SESSION["employer_loggedin"]) && $_SESSION["employer_loggedin"] === true){
  header("location: employer_jobs.php");
  exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$employer_email = $password = "";
$employer_email_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["employer_email"]))){
        $employer_email_err = "Please enter your email.";
    } else{
        $employer_email = trim($_POST["employer_email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($employer_email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT employer_id, employer_name, employer_email, employer_password FROM tbl_employers WHERE employer_email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $employer_email);            
           
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $employer_id, $employer_name, $employer_email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["employer_loggedin"] = true;
                            $_SESSION["employer_id"] = $employer_id;
                            $_SESSION["employer_email"] = $employer_email; 
                            $_SESSION["employer_name"] = $employer_name;                                                      
                            
                            // Redirect user to jobs page page
                            header("location: employer_jobs.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $employer_email_err = "No account found with that emails.";
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
    <title>Employer Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class='d-flex justify-content-center container'>
    <div class="card wrapper">
        <h2>Employer Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($employer_email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="employer_email" class="form-control" value="<?php echo $employer_email; ?>">
                <span class="help-block"><?php echo $employer_email_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="employer_register.php">Sign up now</a>.</p>
        </form>
    </div> 
</div>   
</body>
</html>