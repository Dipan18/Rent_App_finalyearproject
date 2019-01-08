<?php include('header.php'); ?>

<div class="container my-container">

	<?php if ($registration = $this->session->flashdata('registration_success')): ?>
		<div class="alert alert-dismissible alert-success">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
			<?= $registration ?>
		</div>
	<?php endif; ?>
    
 	<?php echo form_open('login/login_user'); ?>

    <div class="form-group">
      	<label class="form-control-label" for="email">Email address</label>
 	 	<?php echo form_input(['name'=>'email', 'class'=>'form-control', 'placeholder'=>'Enter email', 'id'=>'email', 'value'=>set_value('email')]); ?>
		    <div class="text-danger">
		    	<?php echo form_error('email'); ?>
    		</div>
    </div>
  
    <div class="form-group">
      <label class="form-control-label" for="password">Password</label>
      <?php echo form_password(['name'=>'password', 'class'=>'form-control', 'id'=>'password', 'placeholder'=>'Enter password']); ?>
		    <div class="text-danger">
    			<?php echo form_error('password'); ?>
    		</div>
    </div>

    <?php echo form_submit(['name'=>'submit', 'value'=>'Login', 'class'=>'btn btn-primary']); ?>
	<?php echo form_close(); ?>

	<p>Don't have an account?<?php echo anchor('signup', ' Register Here!') ?><p>
  
	</form>

    <?php if ($login_error = $this->session->flashdata('login_failed')): ?>
		<div class="alert alert-dismissible alert-danger">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
			<?= $login_error ?>
		</div>
	<?php endif; ?>

</div>


<?php echo link_tag('assets/css/login_signup.css'); ?>
<?php include('footer.php'); ?>