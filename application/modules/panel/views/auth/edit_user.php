
      <div class="row">
        <div class="col-xs-6">
          <div class="box">
            <div class="box-header">

              <h3 class="box-title"><?php echo lang('edit_user_heading');?>
              <small><?php echo lang('edit_user_subheading');?></small></h3>



            </div>
                        <div id="infoMessage"><?php echo $message;?></div>

            <!-- /.box-header -->
            <div class="box-body">

<?php echo form_open_multipart(uri_string());?>
    
      <p>
            <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
            <?php echo form_input($first_name, '', 'class="form-control"');?>
      </p>

      <p>
            <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
            <?php echo form_input($last_name, '', 'class="form-control"');?>
      </p>

      <p>
            <?php echo lang('edit_user_company_label', 'company');?> <br />
            <?php echo form_input($company, '', 'class="form-control"');?>
      </p>

     

      <p>
            <?php echo lang('edit_user_password_label', 'password');?> <br />
            <?php echo form_input($password, '', 'class="form-control"');?>
      </p>

      <p>
            <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
            <?php echo form_input($password_confirm, '', 'class="form-control"');?>
      </p>
      <div class="form-group">
          <label for="user_image"><?php echo lang('user_image_upload'); ?></label> 
          <center><div style="image image-responsive"><img height="60px" src="<?= base_url(); ?>assets/uploads/members/<?= $image; ?>"></div>    </center>                   

          <input id="user_image" type="file" name="user_image" data-show-upload="false" data-show-preview="false" accept="image/*" class="form-control file">
      </div>

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

     


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <div class="box">
           

            <!-- /.box-header -->
            <div class="box-body">
 <p>
            <?php echo lang('edit_user_phone_label', 'phone');?> <br />
            <?php echo form_input($phone, '', 'class="form-control"');?>
      </p>
   
      <div class="form-group">
        <label for="gender"><?php echo lang('user_gender_label') ?></label>
        <select class="form-control" id="gender" name="gender" required="required">
          <option value="Male"><?php echo lang('user_gender_male') ?></option>
          <option value="Female"><?php echo lang('user_gender_female') ?></option>
          <option value="Other"><?php echo lang('user_gender_other') ?></option>
        </select>

      </div>
     
      <div class="form-group">
            <?php echo lang('user_address_label');?> <br />

            <?php echo form_input($address, '', 'class="form-control"');?>
        

      </div>
      <div class="form-group">
                    
                    <label class="control-label" for="borrowertype"><?= lang('memtype_name_label')?></label>

                        <select id="member_type" name="member_type" class="form-control">
                          <?php if(isset($member_types)): ?>
                          <?php foreach($member_types as $type): ?>
                            <option value="<?= $type->type_id; ?>" <?php if($type->type_id == $memtype){echo "selected";} ?>>
                              <?= $type->borrowertype; ?>
                            </option>
                          <?php endforeach; ?>  
                          <?php endif; ?>  
                        </select>
                       
                    </div> 
                    <div class="form-group">
                    
                    <label class="control-label" for="borrowertype"><?= lang('occu_name_label')?></label>

                        <select id="class" name="class" class="form-control">
                          <?php if(isset($class_id[0])): ?>
                            <option value="<?= $class_id[0]->class_id ?>"><?= $class_id[0]->name ?></option>
                          <?php else: ?>
                            <option></option>

                          <?php endif; ?>

                        </select>
                    </div> 
                    
      <?php if ($this->ion_auth->is_admin()): ?>
          <h3><?php echo lang('edit_user_groups_heading');?></h3>
        
 <div class="form-group">
    <div class=" col-sm-12">
          <?php foreach ($groups as $group):?>
              <label class="checkbox">
              <?php
                  $gID=$group['id'];
                  $checked = null;
                  $item = null;
                  foreach($currentGroups as $grp) {
                      if ($gID == $grp->id) {
                          $checked= ' checked="checked"';
                      break;
                      }
                  }
              ?>
              <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
              <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
              </label>
          <?php endforeach?>
    </div>
  </div>
      <?php endif ?>

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

    

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        </div>
       
        <div class="col-xs-12">
              <p>
                      <?php echo form_submit('submit', lang('edit_user_submit_btn'), 'class="btn btn-success form-control"');?>
                      <a href="<?php echo base_url('panel/auth/index'); ?>" class="btn btn-primary form-control">Cancel</a>
                    </p>

              <?php echo form_close();?>
          </div>
         
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

<script type="text/javascript">
  $("#member_type").select2({
      placeholder: 'Select Member Type'
    });

  $("#class").select2({
  placeholder: '',
  ajax: {
    url: '<?= base_url();?>panel/auth/json_occu',
    type: 'POST',
    data: function (params) {
      return {
        id: $("#member_type").val(),
        search: params.term
      }
    },
     processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.text,
                        id: item.id
                    }
                })
            };
        }
  }
});


</script>