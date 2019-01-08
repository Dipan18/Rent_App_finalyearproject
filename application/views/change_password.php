<?php include('header.php') ?>
<?php include('profile_sidebar.php') ?>

<div class="col-md-9 tst">
    <h5>Change Password</h5>
    <hr>

    <div class="form-container">
        <?php if ($password_error = $this->session->flashdata('wrong_password')): ?>
            <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $password_error ?>
            </div>
        <?php endif; ?>

        <?php if ($same_password = $this->session->flashdata('same_password')): ?>
            <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $same_password ?>
            </div>
        <?php endif; ?>

        <?php if ($error = $this->session->flashdata('error')): ?>
            <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $error ?>
            </div>
        <?php endif; ?>
    
        <?php echo form_open('user/update_password'); ?>

        <div class="form-group">
            <label>Current Password</label>
            <?php echo form_password(['name'=>'current_password', 'class'=>'form-control']); ?>
            <div class="text-danger">
                <?php echo form_error('current_password'); ?>
            </div>
        </div>

        <div class="form-group">
            <label>New Password</label>
            <?php echo form_password(['name'=>'new_password', 'class'=>'form-control']); ?>
            <div class="text-danger">
                <?php echo form_error('new_password'); ?>
            </div>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <?php echo form_password(['name'=>'confirm_password', 'class'=>'form-control']); ?>
            <div class="text-danger">
                <?php echo form_error('confirm_password'); ?>
            </div>
        </div>

        <?php echo form_submit(['value'=>'submit', 'class'=>'btn btn-primary mrgn']); ?>
        <?php echo anchor('user/profile', 'cancel', ['class'=>'btn btn-secondary']); ?>

    </div> <!-- for form container -->

</div> <!-- for col-md-9 -->

</div>   <!-- for row div in profile_sidebar -->

</div>   <!-- for container div in profile_sidebar -->

<?php echo link_tag('assets/css/profile.css'); ?>
<?php include('footer.php') ?>