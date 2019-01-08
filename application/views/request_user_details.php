<?php include('header.php') ?>
<?php include('profile_sidebar.php') ?>      

    <div class="col-md-9">
        <h5>Request made by user</h5>
        <hr>

         <div class="card bg-light">
            <div class="card-body">
                <div class="header">
                    <h5>Name</h5>
                    <p><?php echo $request_user_details['request_user_first_name'] . ' ' . 
                                  $request_user_details['request_user_last_name']; ?></p>
                </div>
                <h5>E-mail</h5>
                <p><?php echo $request_user_details['request_user_email']; ?>
                <h5>Phone No</h5>
                <p><?php echo $request_user_details['request_user_phone_no']; ?>
                <h5>Pincode</h5>
                <p><?php echo $request_user_details['request_user_pincode']; ?>
                <h5>Address</h5>
                <p><?php echo $request_user_details['request_user_address']; ?>
            </div>
        </div>
    </div>    

</div>   <!-- for row div in profile_sidebar -->

</div>   <!-- for container div in profile_sidebar -->


<?php echo link_tag('assets/css/profile.css'); ?>
<?php include('footer.php') ?>