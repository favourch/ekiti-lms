 <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
    
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-md-2 invoice-col">
          <img style="width: 120px;" src="<?=base_url(); ?>assets/uploads/logos/<?= $settings->logo; ?>">
        </div>
        <!-- /.col -->
        <div class="col-md-10 invoice-col">
            <h2><strong><?= $settings->title; ?></strong></h2>
            <address style="font-size: 1pc; margin:0;"><?= $settings->address; ?></address>
            <p style="font-size: 1pc;"><strong><?= lang('quick_inventory'); ?></strong></p>
        </div>
        <!-- /.col -->
       
        <!-- /.col -->
      </div>
    <small style="font-weight: bold;" class="pull-right">Date: <?= date('D,  d M Y '); ?></small>  <!-- /.row -->
<hr>
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            
            <tbody>
            <tr>
              <td><?= lang('total_books'); ?>:</td>
              <td style="text-align: right; font-weight: bold;"><?= $books_count; ?></td>
            </tr>
            <tr>
              <td><?= lang('total_member'); ?>:</td>
              <td style="text-align: right; font-weight: bold;"><?php print_r($sumMembers); ?></td>
            </tr>
            <tr>
              <td><?= lang('total_books_price'); ?>:</td>
              <td style="text-align: right; font-weight: bold;"><?= $settings->currency; ?> <?= ($sumBookPrices); ?></td>
            </tr> 
            <tr>
              <td><?= lang('total_books_lost'); ?>:</td>
              <td style="text-align: right; font-weight: bold;"><?= $countBooksLost; ?></td>
            </tr>
            <tr>
              <td><?= lang('total_books_borrowed'); ?>:</td>
              <td style="text-align: right; font-weight: bold;"><?= $countBooksBorrowed; ?></td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- this row will not appear when printing -->
    
    </section>
    <!-- /.content -->