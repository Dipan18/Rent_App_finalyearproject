<?php include('header.php') ?>

<div class="container">

    <div class="row">
        
        <div class="col-md-3">
            <?php $categories = $this->productmodel->get_categories() ?>
            <div class="list-group">
                <?php foreach($categories as $category): ?>
                    <?php echo anchor('/home/sort_by_category/' . $category['cat_id'], $category['cat_name'],
                                     ['class'=>'list-group-item list-group-item-action list-group-item-light']);
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="row">
                <?php if ($search_failed = $this->session->flashdata('search_failed')): ?>
                    <div class="alert alert-dismissible alert-info" style="width: 98%;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= $search_failed ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="row">
                <?php foreach($products as $product): ?>
                    <div class="card product" style="width: 15rem;">
                        <img class="card-img-top" src="<?php echo base_url().$product['img_path']; ?>">
                        <div class="card-body text-center">
                            <?php $pro_id = urlencode($this->encrypt->encode($product['pro_id'])); ?>
                            <a href="<?php echo base_url()?>products/product_details/?q=<?php echo $pro_id; ?>" 
                            class="card-text link"><?php echo $product['pro_title']; ?></a>
                            <p class="card-text"><?php echo '&#x20B9;' . $product['pro_price'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
                
    </div>

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9 page">
            <?php echo $this->pagination->create_links(); ?>
        </div>
    </div>
        
</div>


<script>
    $("a.list-group-item").click(function(e) {
        $(this).addClass('active').siblings().removeClass('active');
    });
</script>

<?php echo link_tag('assets/css/homepage.css'); ?>
<?php include('footer.php') ?>