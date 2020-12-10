<div class="container">
  <h2>Received Applications</h2>
  <p>All jobs that have been applied</p>            
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Job Title</th>              
        <th>Description</th>
        <th>Applicant Name</th>
        <th>Cover Letter</th>
        <th>Applied On</th>
        <th>Status</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT
      tbl_job_list.job_title,
      tbl_job_list.job_description,
      tbl_job_applications.cover_letter,
      tbl_job_applications.application_date,
      tbl_job_applications.application_status,
      CONCAT( tbl_applicants.first_name, ' ', tbl_applicants.last_name ) AS applicant_name,
      tbl_job_applications.application_id 
  FROM
      tbl_job_applications
      INNER JOIN tbl_job_list ON tbl_job_applications.job_id = tbl_job_list.job_id
      INNER JOIN tbl_applicants ON tbl_job_applications.applicant_id = tbl_applicants.applicant_id 
  WHERE
      tbl_job_list.employer_id = ". $_SESSION["employer_id"];
      $result = mysqli_query($link, $sql);
      
      if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
              echo "
              <tr>
              <td>" . $row["job_title"]. "</td>
              <td>" . $row["job_description"]. "</td>
              <td>" . $row["applicant_name"]. "</td>
              <td>" . $row["cover_letter"]. "</td>
              <td>" . $row["application_date"]. "</td>
              <td>" . $row["application_status"]. "</td> 
              <td><a class='btn btn-outline-primary' href='edit_application.php?id=" . $row["application_id"]. "'>Edit</a></td>            
                </tr>";
             
          }
      } else {
          echo "<h4 class='alert alert-danger'>No job application found</h4>";
      }      
      mysqli_close($link);
      ?>
    </tbody>
  </table>
</div>