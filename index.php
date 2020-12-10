<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ONLINE JOBS STYSTEMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class='container'>
    <h2>ONLINE JOBS SYTEMS</h2>
    <div class="card">
        <div class="card-header">Job Seekers</div>
            <div class="card-body">            
                <?php
                        if(isset($_SESSION["applicant_loggedin"]) && $_SESSION["applicant_loggedin"] === true){ 
                            echo "<h5 class='card-title'> Hi, " .htmlspecialchars($_SESSION["applicant_first_name"]). '. Are you looking for jobs to apply?</h5>';           
                            echo "<a href='job_list.php'><button class='btn btn-primary'>VIEW AVAILABLE JOBS</button></a>";
                        }else{
                            echo '<h5 class="card-title">Are you looking for jobs to apply?</h5>';
                            echo "<a href='applicant_login.php'><button class='btn btn-primary'>PLEASE LOGIN</button></a>";
                        }
                ?>   
        </div>
    </div>

    <div class="card" style='margin-top:20px;'>
        <div class="card-header">Employers</div>
            <div class="card-body">            
                <?php
                        if(isset($_SESSION["employer_loggedin"]) && $_SESSION["employer_loggedin"] === true){ 
                            echo "<h5 class='card-title'> Hi, " .htmlspecialchars($_SESSION["employer_name"]). '. Welcome to online jobs system</h5>';           
                            echo "<a href='employer_jobs.php'><button class='btn btn-primary'>MANAGE JOBS</button></a>";
                        }else{
                            echo '<h5 class="card-title">Are you an employer?</h5>';
                            echo "<a href='employer_login.php'><button class='btn btn-primary'>LOGIN TO MANAGE JOBS</button></a>";
                        }
                ?>   
        </div>
    </div>    
</div>
    

</body>

</html>