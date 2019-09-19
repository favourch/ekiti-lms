     <div class="row">
        <div class="col-xs-6">
          <div class="box">
            <div class="box-header">

              <h3 class="box-title"><?php echo lang('edit_group_heading');?>
              <small><?php echo lang('edit_group_subheading');?></small></h3>



            </div>
                        <div id="infoMessage"><?php echo $message;?></div>

            <!-- /.box-header -->
            <div class="box-body">
             
<?php echo form_open(current_url());?>

      <p>
            <?php echo lang('edit_group_name_label', 'group_name');?> <br />
            <?php echo form_input($group_name, '', 'class="form-control"');?>
      </p>

      <p>
            <?php echo lang('edit_group_desc_label', 'description');?> <br />
            <?php echo form_input($group_description, '', 'class="form-control"');?>
      </p>

      <p><?php echo form_submit('submit', lang('edit_group_submit_btn'), 'class="btn btn-primary"');?></p>

<?php echo form_close();?>

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