<div class="col-md-12 col-sm-12 col-xs-12 main post-inherit">
    <div class="x_panel post-inherit">
        
        <!-- Indicates a successful or positive action -->

        <div class="strong">
            <h1>Human Resources Administration System</h1>
            <h4><p>PT. Sumber Alfaria Trijaya, Tbk - Branch Cileungsi 2</p><h4>
            <p>Web Based Application </p>
            <br>
            <br>
            
            <img width=370 height=260 src="<?php echo media_url() ?>/images/logo.jpg" alt="">
  
            <br><br><br>
            <br>
            <strong><?php echo $this->session->userdata('user_full_name'); ?> (<?php echo $this->session->userdata('user_name'); ?>) </strong>
            <br>
            <?php echo pretty_date(date('Y-m-d'), 'l, d F Y',FALSE) ?> 
        </div>
    </div>
</div>