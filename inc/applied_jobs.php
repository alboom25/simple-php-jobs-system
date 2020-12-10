<div class="container">
  <h2>My Applications</h2>
  <p>All jobs that have applied</p>            
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Title</th>
        <th>Employer</th>       
        <th>Description</th>
        <th>Cover Letter</th>
        <th>Applied On</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT
      tbl_job_list.job_title,
      tbl_employers.employer_name,
      tbl_job_list.job_description,
      tbl_job_applications.cover_letter,
      tbl_job_applications.application_date,
      tbl_job_applications.application_status 
    FROM
      tbl_job_applications
      INNER JOIN tbl_job_list ON tbl_job_applications.job_id = tbl_job_list.job_id
      INNER JOIN tbl_employers ON tbl_job_list.employer_id = tbl_employers.employer_id 
    WHERE
      tbl_job_applications.applicant_id = ". $_SESSION["applicant_id"];
      $result = mysqli_query($link, $sql);
      
      if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
              echo "
              <tr>
              <td>" . $row["job_title"]. "</td>
              <td>" . $row["employer_name"]. "</td>
              <td>" . $row["job_description"]. "</td>
              <td>" . $row["cover_letter"]. "</td>
              <td>" . $row["application_date"]. "</td>
              <td>" . $row["application_status"]. "</td>             
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