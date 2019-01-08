
<div class="footer">

    <div class="footer-container">
        <div class="row footer-row text-dark">
            <div class="col-md-3">
                <p class="text-white">Phone Numbers</p>
                <p>8866808405</p>
                <p>9624371400</p>
                <p>7096285206</p>
            </div>
            <div class="col-md-3">
                <p class="text-white">Social</p>
                <p>Twitter</p>
                <p>Facebook</p>
                <p>Instagram</p>
            </div>
            <div class="col-md-3">
                <p class="text-white">Contact Us</p>
                <p>jadavdeep@ymail.com</p>
                <p>neelpatel2754@gmail.com</p>
                <p>kalpitshah42@gmail.com</p>
            </div>
            <div class="col-md-3">
                <p class="text-white">About Us</p>
                <p>This is our final year project</p>
            </div>
        </div>    
    </div>

</div>

<script>
    $(document).ready(function() {
        $('#btnSubmit').prop('disabled', true);
        $('#search').keyup(function () {
            if ($(this).val() == '') {
                //Check to see if there is any text entered
                // If there is no text within the input ten disable the button
                $('#btnSubmit').prop('disabled', true);
            } else {
                //If there is text in the input, then enable the button
                $('#btnSubmit').prop('disabled', false);
            }
        });
    });
</script>

<?php echo link_tag('assets/css/footer.css'); ?>
</body>
</html>