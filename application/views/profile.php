<?php include('header.php') ?>
<?php include('profile_sidebar.php') ?>      

    <div class="col-md-9 tst">
        <h5>Personal Information</h5>
        <hr>
        
        <div class="form-container">
        
            <div class="form-group">
                <label>First Name</label>
                <?php echo form_input(['name'=>'first_name', 'class'=>'form-control', 'disabled'=>'TRUE', 'value'=>$first_name]); ?>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <?php echo form_input(['name'=>'last_name', 'class'=>'form-control', 'disabled'=>'TRUE', 'value'=>$last_name]); ?>
            </div>

            <div class="form-group">
                <label>Email</label>
                <?php echo form_input(['name'=>'email', 'class'=>'form-control', 'disabled'=>'TRUE', 'value'=>$email]); ?>
            </div>

            <div class="form-group">
                <label>Phone no.</label>
                <?php echo form_input(['name'=>'phone_no', 'class'=>'form-control', 'disabled'=>'TRUE', 'value'=>$phone_no]); ?>
            </div>

            <div class="form-group">
                <label>Pincode</label>
                <?php echo form_input(['name'=>'pincode', 'class'=>'form-control', 'disabled'=>'TRUE', 'value'=>$pincode]); ?>
            </div>

            <div class="form-group">
                <label>Address</label>
                <?php echo form_textarea(['name'=>'address', 'class'=>'form-control', 'disabled'=>'TRUE', 'rows'=>3, 'value'=>$address]); ?>
            </div>

        </div>
            
    </div>    

</div>   <!-- for row div in profile_sidebar -->

</div>   <!-- for container div in profile_sidebar -->


<?php echo link_tag('assets/css/profile.css'); ?>
<?php include('footer.php') ?>