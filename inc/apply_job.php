<div class='d-flex justify-content-center '>
    <div class="card wrapper-large">       
        <p>Please fill this form to apply for the job.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($cover_letter_err)) ? 'has-error' : ''; ?>">
                <label>Cover Letter</label>
                <textarea name="cover_letter" rows="8" class="form-control" cols="40"><?php echo $cover_letter;?></textarea>                
                <span class="help-block"><?php echo $cover_letter_err; ?></span>
            </div>  
            <input type="hidden" name='job_id' value="<?php echo $job_id;?>">          
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>           
        </form>
    </div> 
    </div>   