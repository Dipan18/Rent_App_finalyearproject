<?php include('header.php'); ?>
<?php include('profile_sidebar.php'); ?>

<div class="col-md-9">
    <?php foreach($rented_by_user as $rent_item): ?>
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="header border-bottom">
                    <?php $id = urlencode($this->encrypt->encode($rent_item['pro_id'])); ?>
                    <a href="<?php echo base_url() ?>user/request_details/?q=<?php echo $id ?>" 
                    class="text-capitalize text-white link"><?php echo $rent_item['pro_title']; ?></a>
                </div>
                <label>Owner of Item:</label>
                <?php echo $rent_item['first_name'] . ' ' . $rent_item['last_name']; ?>
                <br>
                <label>Requested On:</label>
                <?php echo $rent_item['requested_on'] ?>
                <br>
                <label>Rented On:</label>
                <?php echo $rent_item['rented_on'] ?>
                <br>
                <label>Days Remaining:</label>
                <?php echo $rent_item['days_remaining']; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>


</div> <!-- for row div in profile_sidebar -->

</div> <!-- for container div in profile_sidebar -->

<?php echo link_tag('assets/css/rent_requests.css'); ?>
<?php echo link_tag('assets/css/profile.css'); ?>
<?php include('footer.php'); ?>