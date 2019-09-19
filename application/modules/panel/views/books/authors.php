
      <div class="row">

        <div class="col-xs-12">
        
          <div class="box">
            <div class="box-header">
            <h2 class="box-title"><?php echo lang('authors_title');?></h2>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAuthor">
           <?= lang('add_authors_title');?>
          </button>

          <!-- Modal -->
          <div class="modal fade" id="addAuthor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel"><?= lang('add_authors_title');?></h4>
                </div>
                <div class="modal-body">
      
              <?= form_open('panel/books/add_author'); ?>
              <div class="form-group">
                          <label class="control-label" for="author"><?= lang('authors_name_label')?></label>
                          <?php echo form_input('author', '', 'class="form-control"');?>
              </div>  
              <div class="form-group">
                  <?php echo form_submit('submit','Submit', 'class="form-control" id="submit"'); ?>
                  </div>
              <?= form_close();?>
            </div>
                
              </div>
            </div>
          </div>
          
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAuthorCSV">
            <?= lang('import_authors_by_csv');?>
          </button>
          <div class="modal fade" id="addAuthorCSV" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
                      </button>
                      <h4 class="modal-title" id="myModalLabel"><?php echo lang('import_authors_by_csv'); ?></h4>
                  </div>
                  <?php
                  $attrib = array('class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form');
                  echo form_open_multipart("panel/books/import_authors", $attrib)
                  ?>
                  <div class="modal-body">
                      <a href="<?php echo base_url(); ?>assets/csv/sample_authors.csv" class="btn btn-primary pull-right">
                          <i class="fa fa-download"></i> <?= lang("download_sample_file") ?>
                      </a>
                      

                      <div class="well well-small">
                          <span class="text-warning"><?= lang("import_authors_by_csv"); ?></span><br/>
                          <span class="text-info">
                              (<?= lang("authors_name_label"); ?>)
                          </span> 
                      </div>
                      

                       <div class="col-md-12">
                          <div class="form-group">
                              <label for="csv_file"><?= lang("upload_file"); ?></label>
                              <input type="file" data-browse-label="<?= lang('browse'); ?>" name="userfile" class="form-control file" data-show-upload="false"
                              data-show-preview="false" id="csv_file" required="required"/>
                          </div>
                      </div>
              
                      <div class="clearfix"></div>
                  </div>
                  <div class="modal-footer">
                      <?php echo form_submit('import', lang('import_csv'), 'class="btn btn-primary"'); ?>
                  </div>
              </div>
              <?php echo form_close(); ?>
          </div>
        </div>
					
          <a data-toggle="tooltip" title="<?= lang('export_to_pdf'); ?>" class="btn btn-primary pull-right" href="<?= base_url();?>/panel/books/export_authors/pdf">
            <i class="fa fa-file-pdf-o fa-2x"></i>
          </a>
          <a  data-toggle="tooltip" title="<?= lang('export_to_excel'); ?>" class="btn btn-primary pull-right" style="margin-right: 5px" href="<?= base_url();?>/panel/books/export_authors/xls">
            <i class="fa fa-file-excel-o fa-2x"></i>
          </a>

            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                 <th>#</th>
					       <th><?= lang('authors_name_label'); ?></th>
                 <td><?= lang('actions_label'); ?></td>
				        </tr>
                </thead>
                <tbody>
                  <?php 
                    if (!empty($authors)): ?>
                      <?php foreach ($authors as $author): ?>
                    <tr>
                       <td><?= $author->id; ?></td>
                       <td><?= $author->author_name; ?></td>
                       <td>


                      <a href="<?= base_url();?>panel/books/editAuthorModal/<?= $author->id;?>" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                      <a class="btn btn-sm btn-danger" href="<?= base_url(); ?>panel/books/delAuthor/<?= $author->id; ?>"><i class="fa fa-trash-o"></i></a>
                      <a class="btn btn-sm btn-default" href="<?= base_url(); ?>panel/books/print_barcodes/?authors=<?= $author->id; ?>"><i class="fa fa-print"></i></a>
                       </td>


                    </tr>
                  <?php endforeach ?>
                   <?php endif;?>
                </tbody>
                <tfoot>
                 <td>#</td>
                 <td><?= lang('authors_name_label'); ?></td>
                 <td><?= lang('actions_label'); ?></td>
                </tfoot>
              </table>
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
