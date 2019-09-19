 
      <div class="row">
       <!-- /.col -->
        <div class="col-xs-8">
          <div class="box">
            <div class="box-header">

              <h3 class="box-title"><?php echo lang('create_group_heading');?> <small><?php echo lang('create_group_subheading');?></small></h3>
              



            </div>

            <!-- /.box-header -->
            <div class="box-body">
            <table class="table table-responsive" id="example1">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?= lang('create_group_name_label');?></th>
                  <th><?= lang('create_group_desc_label');?></th>
                  <th><?= lang('index_action_th');?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($groups as $group) { ?>
                  <tr>
                    <td><?= $group->id; ?></td>
                    <td><?= $group->name; ?></td>
                    <td><?= $group->description; ?></td>
                    <td><a href="<?= base_url(); ?>panel/auth/edit_group/<?= $group->id; ?>"><i class="fa fa-edit"></i></a></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        </div>
        <div class="col-xs-4">
          <div class="box">
            <div class="box-header">

              <h3 class="box-title"><?php echo lang('create_group_heading');?> <small><?php echo lang('create_group_subheading');?></small></h3>
              



            </div>

            <!-- /.box-header -->
            <div class="box-body">
             
<?php echo form_open("panel/auth/create_group");?>

       <p>
              <?php echo lang('create_group_name_label', 'group_name');?> <br />
              <?php echo form_input($group_name, '', 'class="form-control"');?>
      </p>

      <p>
              <?php echo lang('create_group_desc_label', 'description');?> <br />
              <?php echo form_input($description, '', 'class="form-control"');?>
      </p>

      <p>
        <?php echo form_submit('submit', lang('create_group_submit_btn'), 'class="btn btn-primary"');?>
        
        <!-- <a href="<?php //echo base_url('panel/auth/index'); ?>" class="btn btn-danger pull-right">Cancel</a> -->
      </p>

     

<?php echo form_close();?>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        </div>
       
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
