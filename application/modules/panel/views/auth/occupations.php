
      <div class="row">

        <div class="col-xs-12">
        
          <div class="box">
            <div class="box-header">
            <h2 class="box-title"><?php echo lang('occu_title');?></h2>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addAuthor">
             <?= lang('add_occu_title');?>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="addAuthor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?= lang('add_occu_title');?></h4>
                  </div>
                  <div class="modal-body">
        
                <?= form_open('panel/auth/add_occu'); ?>
                <div class="form-group">
                    <label class="control-label" for="occupation"><?= lang('occu_name_label')?></label>
                    <?php echo form_input('occupation', '', 'class="form-control"');?>
                </div>  
                <div class="form-group">
                    <label class="control-label" for="borrowertype"><?= lang('memtype_name_label')?></label>
                
                    <select name="member_type" class="form-control">
                      <?php foreach($member_types as $type): ?>
                        <option value="<?= $type->type_id; ?>">
                          <?= $type->borrowertype; ?>
                        </option>
                      <?php endforeach; ?>  
                    </select>
                   
                </div> 
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
                 <th><?= lang('occu_label'); ?></th>
					       <th><?= lang('member_label'); ?></th>
                 <th></th>
				        </tr>
                </thead>
                <tbody>
                <?php if (!empty($occupations)): ?>

                  <?php foreach ($occupations as $occupation): ?>
                    <tr>
                       <td><?= $occupation->class_id; ?></td>
                       <td><?= $occupation->name; ?></td>
                       <td><?= $occupation->borrowertype; ?></td>
                       <td><a href="<?= base_url();?>panel/auth/editOccuModal/<?= $occupation->class_id;?>" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a></td>
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
