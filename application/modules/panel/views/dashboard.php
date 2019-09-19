
 <div class="row">
          
                    
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                                   <h3><?=  $count['books']; ?></h3>
                  <p><?= lang('book_total_label'); ?></p>
                </div>
                <div class="icon">
                  <!-- <i class="ion ion-bag"></i> -->
                  <img src="<?= base_url(); ?>assets/images/library_icon.png" width="80px">
                </div>
                <a href="books" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
             
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                                    <h3><?=  $count['borrowed']; ?></h3>
                  <p><?= lang('borrowed_books_label'); ?></p>
                </div>
                <div class="icon">
                  <!-- <i class="ion ion-stats-bars"></i> -->
                 <img src="<?= base_url(); ?>assets/images/borrowed.png" width="80px">

                </div>
                <a href="<?= base_url(); ?>panel/borrow/borrowed/pending" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                
              </div>
            </div><!-- ./col -->
           <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?= lang('return_book_label'); ?></h3>
                  <p><?= lang('book_label'); ?></p>
                </div>
                <div class="icon">
                  <!-- <i class="ion ion-pie-graph"></i>-->  
                  <img src="<?= base_url(); ?>assets/images/ret1.png" width="50px"> 
                </div>
                <a href="borrow/bookreturn" class="small-box-footer"><?= lang('return_book_label'); ?>  <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?= lang('issue_book_label'); ?></h3>
                  <p><?= lang('book_label'); ?></p>
                </div>
                <div class="icon">
<!--                   <i class="ion ion-pie-graph"></i>-->    
                   <img src="<?= base_url(); ?>assets/images/borow.png" width="50px">      
                </div>
                <a href="borrow" class="small-box-footer"><?= lang('issue_book_label'); ?> <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><?= lang('today_dues'); ?></h3>
                </div>
                <!-- /.box-header -->
                  <div class="box-body no-padding">
                    <table class="table table-striped" id="example2">
                    <thead>
                      <tr>
                        <th><?= lang('books_name_label'); ?></th>
                        <th><?= lang('borrower_name_label'); ?></th>
                        <th><?= lang('date_borrow_label'); ?></th>
                        <th><?= lang('contact_label'); ?></th>  
                      </tr>
                    </thead>
                    <tbody>
                     
                       <?php 
                       if($dues['due_today']){
                        foreach ($dues['due_today'] as $value):
                          if ($settings->issue_conf == 1 && !($settings->issue_limit_days == -1 || $settings->issue_limit_days == 0)):
                          ?>
                          <tr>
                            <td><?= $value->title ?></td>
                            <td><?= $value->name ?></td>
                            <td><?= $value->due_date ?></td>
                            <td><?= $value->contacts ?></td>
                          </tr>
                          <?php
                          endif;
                          if ($settings->issue_conf == 2 && !($value->issue_limit_day == -1 || $value->issue_limit_day == 0)):
                          ?>
                          <tr>
                            <td><?= $value->title ?></td>
                            <td><?= $value->name ?></td>
                            <td><?= $value->due_date ?></td>
                            <td><?= $value->contacts ?></td>
                          </tr>
                          <?php
                          endif;
                        endforeach;
                      }else{ ?>
                        <td><?= lang('no_dues'); ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      <?php }
                      ?>
                      </tbody>
                      <tfoot>
                      <tr>
                        <th><?= lang('books_name_label'); ?></th>
                        <th><?= lang('borrower_name_label'); ?></th>
                        <th><?= lang('date_borrow_label'); ?></th>
                        <th><?= lang('contact_label'); ?></th> 
                      </tr>
                    </tfoot>
                    </table>
                  </div>
                <!-- /.box-body -->
              </div>
              </div>
            </div>
            <div class="row">

            <section class="col-lg-7 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              

             <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?= lang('tommorow_dues'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped" id="example2">
                <thead>
                  <tr>
                      <th><?= lang('books_name_label'); ?></th>
                      <th><?= lang('borrower_name_label'); ?></th>
                      <th><?= lang('date_borrow_label'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                       if($dues['due_tommorow']){
                        foreach ($dues['due_tommorow'] as $value) {
                         if ($settings->issue_conf == 1 && !($settings->issue_limit_days == -1 || $settings->issue_limit_days == 0)):
                          ?>
                          <tr>
                            <td><?= $value->title ?></td>
                            <td><?= $value->name ?></td>
                            <td><?= $value->due_date ?></td>
                          </tr>
                          <?php
                          endif;
                          if ($settings->issue_conf == 2 && !($value->issue_limit_day == -1 || $value->issue_limit_day == 0)):
                          ?>
                          <tr>
                            <td><?= $value->title ?></td>
                            <td><?= $value->name ?></td>
                            <td><?= $value->due_date ?></td>
                          </tr>
                          <?php
                          endif;
                        }
                      }else{ ?>
                        <td colspan=3 class="text-center">No DUEs for Tomorrow</td>
                      <?php }
                      ?>
                </tbody>
                 <tfoot>
                  <tr>
                      <th><?= lang('books_name_label'); ?></th>
                      <th><?= lang('borrower_name_label'); ?></th>
                      <th><?= lang('date_borrow_label'); ?></th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
              <!-- Chat box -->
            <div class="box">
              <div class="box-header">
                <h3 class="box-title"><?= lang('most_issue'); ?></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body no-padding">
               <div id="books-bar" class="graph"></div>
              </div>
            </div>
            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

         
 <!-- Custom tabs (Charts with tabs)-->
          <div id="donut-example"></div>

            </section><!-- right col -->
          </div><!-- /.row (main row) -->

           <script>
/*
 * Play with this code and it'll update in the panel opposite.
 *
 * Why not try some of the options above?
 */
Morris.Donut({
element: 'donut-example',
  data: [
    {label: "<?= lang('books_issued_till_date'); ?>", value: <?= $chartdata['tilldate']; ?>},
    {label: "<?= lang('pending_books_label'); ?>", value: <?= $chartdata['pending']; ?>},
    {label: "<?= lang('lost_books_label'); ?>", value: <?= $chartdata['lost']; ?>},
    {label: "<?= lang('due_not_returned_books_label'); ?>", value:  <?= $chartdata['notreturned']; ?>}
  ], 
  colors: ["#3c8dbc", "#f56954", "#00a65a", "#666"],

});
Morris.Bar({
    element: 'books-bar',
    data: [
      
      <?php foreach ($barchart as $value) { ?>
        {device: "<?= $value->title;?>", geekbench: <?= $value->sales ?> },
      <?php } ?>
    ],
    xkey: 'device',
    ykeys: ['geekbench'],
    labels: ['Total'],
    barRatio: 0.4,
    xLabelAngle: 55,
    hideHover: 'auto',
    stacked: true,
  });
$('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "iDisplayLength": 5,

    });

 </script>
 <style type="text/css">
   #books-bar text[text-anchor="middle"]{
    display:none
  }
 </style>