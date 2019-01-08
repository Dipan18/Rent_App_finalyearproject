
<div class="container">

    <div class="row">
    
        <div class="col-md-3">
            <?php echo img(['src'=>'assets/images/user.png', 'class'=>'img img-thumbnail']); ?>
            <?php echo anchor('user/profile', $first_name . ' ' . $last_name, ['class'=>'anchor h5 text-capitalize']); ?>
            <hr>
            <?php echo anchor('user/change_password', 'Change Password', ['class'=>'anchor']); ?>
            <?php echo anchor('user/edit_profile', 'Edit Profile', ['class'=>'anchor']); ?>
            <hr>
            <?php echo anchor('user/your_ads', 'Your Ads', ['class'=>'anchor']); ?>
            <?php echo anchor('user/rented_by_user', 'Rented by you', ['class'=>'anchor']); ?>
            <?php echo anchor('user/rent_requests', 'Rent Requests', ['class'=>'anchor']); ?>
        </div>

