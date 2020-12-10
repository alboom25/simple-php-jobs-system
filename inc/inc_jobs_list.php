<div class="container">
  <h2>All Available Jobs</h2>
  <p>Find your desired job and click the apply button next to it</p>            
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Job Id</th>
        <th>Employer</th>
        <th>Title</th>
        <th>Description</th>
        <th>Expiry Date</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT
      tbl_job_list.job_id,
      tbl_employers.employer_name,
      tbl_job_list.job_title,
      tbl_job_list.job_description,
      tbl_job_list.expiry_date 
  FROM
      tbl_job_list
      INNER JOIN tbl_employers ON tbl_job_list.employer_id = tbl_employers.employer_id 
  WHERE
      DATE( tbl_job_list.expiry_date ) > Now();";
      $result = mysqli_query($link, $sql);
      
      if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
              echo "
              <tr>
              <td>" . $row["job_id"]. "</td>
              <td>" . $row["employer_name"]. "</td>
              <td>" . $row["job_title"]. "</td>
              <td>" . $row["job_description"]. "</td>
              <td>" . $row["expiry_date"]. "</td>
              <td><a class='btn btn-success' href='apply_job.php?id=" . $row["job_id"]. "'>Apply</a></td>
                </tr>";
             
          }
      } else {
          echo "<h4 class='alert alert-danger'>No active jobs available right now</h4>";
      }      
      mysqli_close($link);
      ?>
    </tbody>
  </table>
</div>