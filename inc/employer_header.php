<div class='container'>
    <div class="page-header">
        <h2>Hi, <b><?php echo htmlspecialchars($_SESSION["employer_name"]); ?></b>. Welcome to online jobs system.</h2>
    </div>
    <p>   
        <a href='add_job.php' class='btn btn-success' >Add New Job</a>
        <a href="employer_jobs.php" class="btn btn-primary">Jobs List</a>
        <a href="received_applications.php" class="btn btn-primary">View Applications</a>     
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>        
    </p>
<div>