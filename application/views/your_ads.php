<?php include('header.php') ?>
<?php include('profile_sidebar.php') ?>

<div class="col-md-9">
    <h5>Your Ads</h5>
    <hr>
    <?php if ($remove_error = $this->session->flashdata('remove_error')): ?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $remove_error; ?>                    
            </div>
    <?php endif; ?>

    <?php if ($remove_success = $this->session->flashdata('remove_success')): ?>
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $remove_success; ?>                    
            </div>
    <?php endif; ?>

    <?php foreach($products as $product): ?>
        <!-- <div class="row"> -->
            <div class="card bg-light">
                <div class="card-body">
                    <div class="header">
                        <?php $id = urlencode($this->encrypt->encode($product['pro_id'])); ?>
                        <a href="<?php echo base_url() ?>user/ad_details/?q=<?php echo $id ?>" 
                        class="text-capitalize link"><?php echo $product['pro_title']; ?></a>
                        <div class="float-right">
                            <label>Added On:</label>
                            <?php echo $product['created_at'] ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <?php echo img(['src'=>base_url() . $product['img_path'], 'class'=>'card-img']); ?>
                    </div>
                    <div class="float-right">
                        <button class="btn btn-danger" data-toggle="modal" data-target=".modal">Remove Ad</button>
                    </div>
                </div>
            </div>
        <!-- </div> -->
    <?php endforeach; ?>
    
    <div class="modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Warning!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
                <div class="modal-body">
                    <p>Are you sure you want to remove this Ad?</p>
                </div>
               
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-danger">Remove</button> -->
                    <?php echo anchor('user/remove_ad/?q=' . $id, 'Remove', ['class'=>'btn btn-danger']); ?>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

</div> <!-- for row div inside profile sidebar -->
</div> <!-- for container div inside profile sidebar -->

<?php echo link_tag('assets/css/profile.css'); ?>
<?php echo link_tag('assets/css/user_ads.css'); ?>
<?php include('footer.php') ?>