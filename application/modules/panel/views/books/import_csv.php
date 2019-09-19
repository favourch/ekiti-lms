
      <div class="row">

        <div class="col-xs-12">
        
          <div class="box">
            <div class="box-header">
            <h2 class="box-title"><?= lang('import_books_by_csv'); ?></h2>
          

            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <?php
                $attrib = array('class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form');
                echo form_open_multipart("panel/books/import_csv", $attrib)
                ?>
                <div class="row">
                    <div class="col-md-12">

                        <div class="well well-small">
                        

                            <a href="<?php echo base_url(); ?>assets/csv/sample_books.csv"
                               class="btn btn-primary pull-right"><i class="fa fa-download"></i><?= lang('download_sample_file'); ?></a>
                                <span class="text-warning"><?= lang('import_books_by_csv'); ?></span><br/>
                               <span class="text-info"><?= lang('add_isbn_label'); ?>,<?= lang('add_book_label'); ?>,<?= lang('add_qty_label'); ?>,<?= lang('add_publisher_label'); ?>,<?= lang('add_digital_file_label'); ?>,<?= lang('add_isbn_13_label'); ?>,<?= lang('add_price_label'); ?>,<?= lang('add_cp_year_label'); ?>,<?= lang('add_rd_label'); ?>,<?= lang('add_desc_label'); ?>,<?= lang('categories_title'); ?>,<?= lang('authors_title'); ?></span>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="csv_file"><?= lang("upload_file"); ?></label>
                                <input type="file" data-browse-label="<?= lang('browse'); ?>" name="userfile" class="form-control file" data-show-upload="false"
                                       data-show-preview="false" id="csv_file" required="required"/>
                            </div>

                            <div class="form-group">
                                <?php echo form_submit('import', lang('import_csv'), 'class="btn btn-primary"'); ?>
                            </div>
                        </div>
                    </div>
                    <?= form_close(); ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

