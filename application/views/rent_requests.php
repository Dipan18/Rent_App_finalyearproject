<?php include('header.php') ?>
<?php include('profile_sidebar.php') ?>

<div class="col-md-9">
    <?php if ($request_error = $this->session->flashdata('request_error')): ?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $request_error; ?>                    
            </div>
    <?php endif; ?>

    <?php if ($accept_success = $this->session->flashdata('accept_success')): ?>
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $accept_success; ?>                    
            </div>
    <?php endif; ?>

    <?php if ($reject_success = $this->session->flashdata('reject_success')): ?>
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $reject_success; ?>                    
            </div>
    <?php endif; ?>

    <?php if ($request_sent = $this->session->flashdata('request_sent')): ?>
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $request_sent; ?>                    
            </div>
    <?php endif; ?>

    <div class="row">
        <div class="col">
            <h5>All Requests</h5>
            <hr>
            
            <?php if (empty($buy_rent_requests)): ?>
                <p>No requests available!</p>
            <?php endif; ?>
            
            <?php foreach($buy_rent_requests as $buy_request): ?>
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="header">
                            <?php $id = urlencode($this->encrypt->encode($buy_request['pro_id'])); ?>
                            <a href="<?php echo base_url() ?>user/request_details/?q=<?php echo $id ?>" 
                            class="text-capitalize link"><?php echo $buy_request['pro_title']; ?></a>
                            <div class="float-right">
                                <label>You Requested On:</label>
                                <?php echo $buy_request['requested_on'] ?>
                            </div>
                        </div>
                        <label>Status:</label>
                        <?php echo $buy_request['status']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h5>Rejected requests</h5>
            <hr>
            
            <?php if (empty($rejected_requests)): ?>
                <p>No requests available!</p>
            <?php endif; ?>

            <?php foreach($rejected_requests as $rejected_request): ?>
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="header">
                            <?php $id = urlencode($this->encrypt->encode($rejected_request['pro_id'])); ?>
                            <a href="<?php echo base_url() ?>products/product_details/?q=<?php echo $id ?>" 
                            class="text-capitalize link text-white"><?php echo $rejected_request['pro_title']; ?></a>
                            <div class="float-right">
                                <label>You Requested On:</label>
                                <?php echo $rejected_request['requested_on'] ?>
                            </div>
                        </div>
                        <label>Status:</label>
                        <?php echo $rejected_request['status']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <h5>Requests on your items</h5>
            <hr>

            <?php if (empty($sell_rent_requests)): ?>
                <p>No requests available!</p>
            <?php endif; ?>

            <?php foreach($sell_rent_requests as $sell_request): ?>
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="header">
                            <?php $id = urlencode($this->encrypt->encode($sell_request['pro_id'])); ?>
                            <a href="<?php echo base_url() ?>user/request_details/?q=<?php echo $id ?>" 
                            class="text-capitalize link"><?php echo $sell_request['pro_title']; ?></a>
                            <?php if ($sell_request['status'] === 'Pending'): ?>
                                <div class="float-right">
                                    <?php echo anchor('user/accept_request/?q=' . $id, 'Accept', ['class'=>'btn btn-success']); ?>
                                    <?php echo anchor('user/reject_request/?q=' . $id, 'Reject', ['class'=>'btn btn-danger']); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <label>Status:</label>
                        <?php echo $sell_request['status']; ?>
                        <br>
                        <label>Requested By:</label>
                        <?php $buyer_id = urlencode($this->encrypt->encode($sell_request['buyer_id'])); ?>
                        <a href="<?php echo base_url() ?>user/request_by_user/?q=<?php echo $buyer_id ?>" >
                            <?php echo $sell_request['first_name'] . ' ' . $sell_request['last_name']; ?>
                        </a>  
                        <br>
                        <label>Requested On:</label>
                        <?php echo $sell_request['requested_on'] ?>
                        <?php if ($sell_request['status'] === 'Accepted'): ?>
                            <br>
                            <label>Rented On:</label>
                            <?php echo $sell_request['rented_on'] ?>
                            <br>
                            <label>Days Remaining:</label>
                            <?php echo $sell_request['days_remaining']; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>

</div> <!-- for row div inside profile sidebar -->
</div> <!-- for container div inside profile sidebar -->

<?php echo link_tag('assets/css/profile.css'); ?>
<?php echo link_tag('assets/css/rent_requests.css'); ?>
<?php include('footer.php') ?>