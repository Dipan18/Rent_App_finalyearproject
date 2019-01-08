<?php include('header.php') ?>

<div class="container">
    <?php if ($rent_error = $this->session->flashdata('rent_error')): ?>
        <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?= $rent_error ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="header">
                <h4 class="float-left text-capitalize card-title"><?php echo $product[0]['pro_title']; ?></h4>
                <div class="float-right">
                    <label>Added On:</label>
                    <?php echo $product[0]['created_at'] ?>
                </div>
            </div>
            <hr>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-7 offset-md-1">
            <div class="slider-container">
                <div id="carousel" class="carousel preview" data-ride="carousel">
                    
                    <div class="carousel-inner">
                        
                        <div class="carousel-item active">
                            <?php echo img(['src'=>base_url() . $product_images[0]['img_path'], 'class'=>'d-block w-100 slider-image']); ?> 
                        </div>

                        <?php for($i = 1; $i < sizeof($product_images); $i++): ?>
                            <div class="carousel-item">
                                <?php echo img(['src'=>base_url() . $product_images[$i]['img_path'], 'class'=>'d-block w-100 slider-image']); ?>
                            </div>
                        <?php endfor; ?>
                    </div>
               
                    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                
                    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-white bg-primary card-right">
                <div class="card-body">
                    <h4 class="card-title border-bottom border-dark padding-bottom">Price</h4>
                    <p class="card-text font-size">&#x20B9;<?php echo $product[0]['pro_price']; ?></p>
                    <h4 class="card-title border-bottom border-dark margin-top padding-bottom">Contact User</h4>
                    <p class="card-text"><?php echo $product[0]['first_name'] . ' ' . $product[0]['last_name']; ?></p>
                    <p class="card-text"><?php echo $product[0]['email']; ?></p>
                    <p class="card-text"><?php echo $product[0]['phone_no']; ?></p>
                </div>
            </div>
            <?php if (! isset($product['can_buy'])): ?>
                <?php if ($this->session->userdata('user') && $this->session->user['id'] !== $product[0]['user_id']): ?>
                    <div class="rent-item">
                        <!-- <button class="btn btn-warning">Rent item</button> -->
                        <?php $pro_id = urlencode($this->encrypt->encode($product[0]['pro_id'])); ?>
                        <?php echo anchor('user/rent_item/?q=' . $pro_id, 'Rent Item', ['class'=>'btn btn-warning']); ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    </div>

    <div class="row">
    
        <div class="col-md-10 offset-md-1">
            <div class="card text-black bg-light">  
                
                <div class="card-body">
     

                    <h6 class="font-weight-bold">Description</h6>   
                    <p class="card-text"><?php echo $product[0]['pro_desc']; ?></p>
                    
                    <h6 class="font-weight-bold">Category</h6>
                    <p class="card-text"><?php echo $product[0]['cat_name']; ?></p>
                    
                    <h6 class="font-weight-bold">Item Available For</h6>
                    <p class="card-text"><?php echo $product[0]['rent_period'] . ' days'; ?></p>
                    
                    <hr>
                    
                    <h6 class="font-weight-bold">Pincode</h6>
                    <p><?php echo $product[0]['pro_pincode']; ?></  p>
                    
                    <h6 class="font-weight-bold">Address</h6>
                    <p><?php echo $product[0]['pro_address']; ?></  p>
            
                </div>
            
            </div>
        </div>
    </div>

</div>

<script>
    $('.carousel').carousel({
        interval: false
    });
</script>

<?php echo link_tag('assets/css/product_details.css'); ?>
<?php include('footer.php') ?>