<?php include('header.php'); ?>

<div class="container my-container">
	
	<?php echo form_open('signup/register_user'); ?>

	<div class="form-group">
      	<label class="form-control-label" for="first_name">First Name</label>
 	 	<?php echo form_input(['name'=>'first_name', 'class'=>'form-control', 'placeholder'=>'Enter first name', 'id'=>'first_name', 'value'=>set_value('first_name')]); ?>
	    <div class="text-danger">
	    	<?php echo form_error('first_name'); ?>
		</div>
    </div>
	
	<div class="form-group">
      	<label class="form-control-label" for="last_name">Last Name</label>
 	 	<?php echo form_input(['name'=>'last_name', 'class'=>'form-control', 'placeholder'=>'Enter last name', 'id'=>'last_name', 'value'=>set_value('last_name')]); ?>
	    <div class="text-danger">
	    	<?php echo form_error('last_name'); ?>
		</div>
    </div>

    <div class="form-group">
      	<label class="form-control-label" for="email">Email address</label>
 	 	<?php echo form_input(['name'=>'email', 'class'=>'form-control', 'placeholder'=>'Enter email', 'id'=>'email', 'value'=>set_value('email')]); ?>
		    <div class="text-danger">
		    	<?php echo form_error('email'); ?>
    		</div>
    </div>

	<div class="form-group">
      	<label class="form-control-label" for="phone_no">Phone no</label>
 	 	<?php echo form_input(['name'=>'phone_no', 'class'=>'form-control', 'placeholder'=>'Enter phone no', 'id'=>'phone_no', 'value'=>set_value('phone_no')]); ?>
		    <div class="text-danger">
		    	<?php echo form_error('phone_no'); ?>
    		</div>
    </div>

    <div class="form-group">
      <label class="form-control-label" for="password">Password</label>
      <?php echo form_password(['name'=>'password', 'class'=>'form-control', 'id'=>'password', 'placeholder'=>'Enter password', 
      'data-toggle'=>'password']); ?>
	    	<div class="text-danger">
				<?php echo form_error('password'); ?>
			</div>
    </div>

	<?php echo form_submit(['name'=>'submit', 'value'=>'Sign up', 'class'=>'btn btn-primary']); ?>
	
	<?php if ($signup_error = $this->session->flashdata('registration_fail')): ?>
		<div class="alert alert-dismissible alert-danger">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
			<?= $signup_error ?>
		</div>
	<?php endif; ?>

</div>


<?php echo link_tag('assets/css/login_signup.css'); ?>
<?php include('footer.php'); ?>