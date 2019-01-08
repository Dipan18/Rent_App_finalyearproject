<?php include('header.php') ?>
<?php include('profile_sidebar.php') ?>

<div class="col-md-9 tst">
    
    <h5>Update Details</h5>
    <hr>
    
    <div class="form-container">

        <?php if ($update_failed = $this->session->flashdata('update_failed')): ?>
            <div class="alert alert-dismissible alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $update_failed ?>
            </div>
        <?php endif; ?>

        <?php echo form_open('user/update_userdata'); ?>

            <div class="form-group">
                <label>First Name</label>
                <?php echo form_input(['name'=>'first_name',' id'=>'first_name', 'class'=>'form-control',
                                    'placeholder'=>$first_name, 'value'=>set_value('first_name')]); ?>
                <div class="text-danger">
                    <?php echo form_error('first_name'); ?>
                </div>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <?php echo form_input(['name'=>'last_name', 'id'=>'last_name', 'class'=>'form-control',
                                        'placeholder'=>$last_name, 'value'=>set_value('last_name')]); ?>
                <div class="text-danger">
                    <?php echo form_error('last_name'); ?>
                </div>
            </div>

            <div class="form-group">
                <label>Pincode</label>
                <?php echo form_input(['name'=>'pincode', 'id'=>'pincode', 'class'=>'form-control', 
                                    'placeholder'=>$pincode, 'value'=>set_value('pincode')]); ?>
                <div class="text-danger">
                    <?php echo form_error('pincode'); ?>
                </div>
            </div>

            <div class="form-group">
                <label>Address</label>
                <?php echo form_textarea(['name'=>'address', 'id'=>'address', 'class'=>'form-control', 'rows'=>3, 
                                        'placeholder'=>$address, 'value'=>set_value('address')]); ?>
                <div class="text-danger">
                    <?php echo form_error('address'); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo form_submit(['name'=>'submit', 'value'=>'update', 'class'=>'btn btn-primary mrgn']); ?>
                <?php echo anchor('user/profile', 'Cancel', ['role'=>'button', 'class'=>'btn btn-secondary']); ?>
            </div>

        <?php echo form_close(); ?>

    </div>

</div>

</div>   <!-- for row div in profile_sidebar -->

</div>   <!-- for container div in profile_sidebar -->


<?php echo link_tag('assets/css/profile.css'); ?>
<?php include('footer.php') ?>