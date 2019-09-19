
      <div class="row">

        <div class="col-xs-12">
        
          <div class="box">
            <div class="box-header">
            <h2 class="box-title"><?php echo lang('member_types_title');?></h2>
            <p>
					
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addAuthor">
           <?= lang('add_memtype_title');?>
          </button>

          <!-- Modal -->
          <div class="modal fade" id="addAuthor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel"><?= lang('add_memtype_title');?></h4>
                </div>
                <div class="modal-body">
      
              <?= form_open('panel/auth/add_memtype'); ?>
              <div class="form-group">
                <label class="control-label" for="member_type"><?= lang('memtype_name_label')?></label>
                <?php echo form_input('member_type', '', 'class="form-control" id="member_type"');?>
              </div>  
              <?php if($settings->issue_conf == 2): ?>
                <div class="form-group">
                  <label class="control-label" for="issue_limit_books"><?= lang('settings_fine_limit_book')?></label>
                  <?php echo form_input('issue_limit_books', '', 'class="form-control" id="issue_limit_books"');?>
                </div>  
                <div class="form-group">
                  <label class="control-label" for="issue_limit_days"><?= lang('settings_fine_limit_days')?></label>
                  <?php echo form_input('issue_limit_days', '', 'class="form-control" id="issue_limit_days"');?>
                </div>  
              <?php endif; ?>
              <div class="form-group">
                  <?php echo form_submit('submit','Submit', 'class="form-control" id="submit"'); ?>
                  </div>
              <?= form_close();?>
            </div>
                
              </div>
            </div>
          </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                <th>#</th>
                <th><?= lang('member_label'); ?></th>
                <?php if($settings->issue_conf == 2): ?>
                  <th><?= lang('settings_fine_limit_book'); ?></th>
					        <th><?= lang('settings_fine_limit_days'); ?></th>
                <?php endif; ?>
                 <th></th>
				        </tr>
                </thead>
                <tbody>
                <?php if (!empty($member_types)): ?>

                  <?php foreach ($member_types as $type): ?>
                    <tr>
                       <td><?= $type->type_id; ?></td>
                       <td><?= $type->borrowertype; ?></td>
                      <?php if($settings->issue_conf == 2): ?>
                        
                       <td><?= ($type->issue_limit_books == 0 || $type->issue_limit_books == -1) ? '&infin;' : $type->issue_limit_books; ?></td>
                       <td><?= ($type->issue_limit_day == 0 || $type->issue_limit_day == -1) ? '&infin;' : $type->issue_limit_day ?></td>
                      <?php endif; ?>

                       <td><a href="<?= base_url();?>panel/auth/editMemTypeModal/<?= $type->type_id;?>" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a></td>
                    </tr>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
                
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
      <script type="text/javascript">

        $(document).ready(function(){
            $('#member_type').attr('required', 'required');
            $('form[data-toggle="validator"]').bootstrapValidator('addField', 'member_type');
            <?php if($settings->issue_conf == 2): ?>
            $('#issue_limit_books').attr('required', 'required');
            $('#issue_limit_days').attr('required', 'required');
            $('form[data-toggle="validator"]').bootstrapValidator('addField', 'issue_limit_books');
            $('form[data-toggle="validator"]').bootstrapValidator('addField', 'issue_limit_days');
            <?php endif; ?>
            

        });
      </script>
