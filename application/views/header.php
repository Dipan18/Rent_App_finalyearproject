<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<?php echo link_tag('assets/css/bootstrap.css') ?>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>

<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary"> -->
<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> -->
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">

  <!-- <a class="navbar-brand" href="#">Navbar</a> -->
  
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active font-large">
        <?php echo anchor('home', 'Home', 'class=nav-link'); ?>
      </li>

    </ul>

    <?php if (isset($first_name)): ?>
      <ul class="navbar-nav navbar-right"> 	
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $first_name; ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php echo anchor('user/profile', 'Profile', 'class=dropdown-item'); ?>
            <?php echo anchor('user/your_ads', 'Your Ads', 'class=dropdown-item'); ?>
            <div class="dropdown-divider"></div>
            <?php echo anchor('submit_ad', 'Submit Ad', 'class=dropdown-item'); ?>
            <?php echo anchor('logout', 'Logout', 'class=dropdown-item'); ?>
          </div>
        </li>
      </ul>
    <?php else: ?>
      <ul class="navbar-nav navbar-right">
        <li class="nav-item"><?php echo anchor('login', 'Login', 'class=nav-link'); ?></li>
      </ul>
    <?php endif; ?>
		
    <!-- <form class="form-inline my-2 my-lg-0 search"> -->
    <?php echo form_open('home/search', ['method'=>'get', 'class'=>'form-inline my-2 my-lg-0 search']); ?>
      <!-- <input class="form-control mr-sm-2" type="text" placeholder="Search"> -->
      <?php echo form_input(['name'=>'q', 'id'=>'search', 'class'=>'form-control mr-sm-2', 'placeholder'=>'Search', 'autocomplete'=>'off']); ?>
      <button id="btnSubmit" class="btn btn-primary my-2 my-sm-0" type="submit">Search</button>
    <?php echo form_close(); ?>

  </div>
</nav>

<style>

  .search {
    margin-left: 20px;
  }

  .dropdown-toggle {
    cursor: pointer;
  }

  .font-large {
    font-size: 18px;
  }

</style>