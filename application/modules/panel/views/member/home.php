
 <div class="row">
          <?php if($chartdata['tilldate'] > 0 && $chartdata['pending'] > 0 && $chartdata['returned'] > 0): ?>
           <div class="col-md-12">
            <div id="donut-example"></div>

           </div>
          <?php endif; ?>
           <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?= lang('borrowed_books_label_sh'); ?></h3>
                  <p><?= lang('book_total_label'); ?></p>
                </div>
                <div class="icon">
                   <i class="ion ion-ios-book"></i>  
                  <!-- <img src="<?= base_url(); ?>assets/images/ret1.png" width="50px">  -->
                </div>
                <a href="issued" class="small-box-footer"><?= lang('view_label'); ?> <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            

          </div><!-- /.row -->
          <!-- Main row -->
          <?php if($chartdata['tilldate'] > 0 && $chartdata['pending'] > 0 && $chartdata['returned'] > 0): ?>
          
<script type="text/javascript">

  Morris.Donut({
    element: 'donut-example',
      data: [
        {label: '<?= lang('borrowed_books_label'); ?>', value:<?= $chartdata['tilldate']; ?>},
        {label: '<?= lang('pending_books_label'); ?>', value: <?= $chartdata['pending']; ?>},
        {label: '<?= lang('ret_books_label'); ?>', value: <?= $chartdata['returned']; ?>},
       
      ], 
      colors: [ "#f56954", "#00a65a", "#666"],

    });
</script>
          <?php endif; ?>
