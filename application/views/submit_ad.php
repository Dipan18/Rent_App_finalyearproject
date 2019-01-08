<?php include('header.php'); ?>

<div class="container border border-dark">
    <?php if ($success = $this->session->flashdata('success')): ?>
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $success; ?>                    
            </div>
    <?php endif; ?>

    <?php if ($image_upload_errors = $this->session->flashdata('upload_errors')): ?>
        <?php foreach($image_upload_errors as $error): ?>
            <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $error['name'], $error['error']; ?>                    
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if ($error = $this->session->flashdata('db_insert_fail')): ?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $error; ?>                    
            </div>
    <?php endif; ?>

    <?php if ($error_img = $this->session->flashdata('db_insert_fail_img')): ?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?= $error_img; ?>                    
            </div>
    <?php endif; ?>

    <?php echo form_open_multipart('submit_ad/upload_ad'); ?>

        <div class="form-group">
            <label class="form-control-label">Item Name</label>
            <?php echo form_input(['name'=>'item_name', 'class'=>'form-control', 'placeholder'=>'Enter item name', 'value'=>set_value('item_name')]); ?>
            <div class="text-danger">
                <?php echo form_error('item_name'); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="form-control-label">Category</label>
            <?php $categories = $this->productmodel->get_categories(); ?>
                <select name="category" class="custom-select">
                    <option></option>
                    <?php foreach($categories as $category): ?>
                        <option value=<?= $category['cat_id'] ?>>
                            <?=  $category['cat_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="text-danger">
                    <?php echo form_error('category'); ?>
                </div>
        </div>
    

         
        <div class="form-group">
            <label class="form-control-label">Item Description</label>
            <?php echo form_textarea(['name'=>'item_desc', 'class'=>'form-control', 'rows'=>3, 'value'=>set_value('item_desc'), 'placeholder'=>'Enter item description here']); ?>
            <div class="text-danger">
                <?php echo form_error('item_desc'); ?>
            </div>
        </div>


        <div class="form-group">
            <label class="form-control-label">Item Price</label>
            <?php echo form_input(['name'=>'price', 'class'=>'form-control', 'value'=>set_value('price'), 'placeholder'=>'&#x20b9;']); ?>
            <div class="text-danger">
                <?php echo form_error('price'); ?>
            </div>
        </div>
    
        <div class="form-group">
            <label class="form-control-label">Rent Period</label>
            <?php echo form_input(['name'=>'rent_time', 'class'=>'form-control', 'value'=>set_value('rent_time'), 'placeholder'=>'Specify rent period in Days']); ?>
            <div class="text-danger">
                <?php echo form_error('rent_time'); ?>
            </div>
        </div>

        <!-- <div class="form-group">
            <div class="custom-file">
                <label class="custom-file-label">Upload image 1</label>
                <input type="file" name="product_images[]" class="custom-file-input" multiple>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-file">
                <label class="custom-file-label">Upload image 2</label>
                <input type="file" name="product_images[]" class="custom-file-input" multiple>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-file">
                <label class="custom-file-label">Upload image 3</label>
                <input type="file" name="product_images[]" class="custom-file-input" multiple>
            </div>
        </div>

        <div class="form-group">
            <div class="custom-file">
                <label class="custom-file-label">Upload image 4</label>
                <input type="file" name="product_images[]" class="custom-file-input" multiple>
            </div>
        </div> -->


        <div class="form-group">
            <label class="form-control-label">Upload item images</label>
            <?php echo form_upload(['name'=>'userfile[]', 'multiple'=>'multiple']); ?>
            <div class="text-danger">
                <?php echo form_error('userfile[]'); ?>
            </div>
        </div>

        <div class="form-group">
            <label>Pincode</label>
            <?php echo form_input(['name'=>'pincode', 'class'=>'form-control', 'value'=>$pincode]); ?>
            <div class="text-danger">
                <?php echo form_error('pincode'); ?>
            </div>
        </div>

        <div class="form-group">
            <label class="form-control-label">Your Address</label>
            <?php echo form_textarea(['name'=>'address', 'class'=>'form-control', 'rows'=>3, 'value'=>$address]); ?>
            <div class="text-danger">
                <?php echo form_error('address'); ?>
            </div>
        </div>

        <?php echo form_submit(['name'=>'submit', 'value'=>'submit', 'class'=>'btn btn-primary']); ?>

    </div>

    <?php echo form_close(); ?> 
</div>

<?php echo link_tag('assets/css/submit_ad.css'); ?>

<?php include('footer.php'); ?>