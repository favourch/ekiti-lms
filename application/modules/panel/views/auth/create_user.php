
      <div class="row">
        <div class="col-xs-12">
          <div class="col-xs-6">
          <div class="box">
            <div class="box-header">
<h3 class="box-title"> <?php echo lang('create_user_heading');?>
              <small><?php echo lang('create_user_subheading');?></small></h3>
          



            </div>
                        <div id="infoMessage"><?php echo $message;?></div>

            <!-- /.box-header -->
            <div class="box-body">

              <?php echo form_open_multipart("panel/auth/create_user");?>

                    <p>
                          <?php echo lang('create_user_fname_label', 'first_name');?> <br />
                          <?php echo form_input($first_name, '', 'class="form-control"');?>
                    </p>

                    <p>
                          <?php echo lang('create_user_lname_label', 'last_name');?> <br />
                          <?php echo form_input($last_name, '', 'class="form-control"');?>
                    </p>
                    
                    <?php
                    if($identity_column!=='email') {
                        echo '<p>';
                        echo lang('create_user_identity_label', 'identity');
                        echo '<br />';
                        echo form_error('identity');
                        echo form_input($identity);
                        echo '</p>';
                    }
                    ?>

                    <p>
                          <?php echo lang('create_user_company_label', 'company');?> <br />
                          <?php echo form_input($company, '', 'class="form-control"');?>
                    </p>

                    <p>
                          <?php echo lang('create_user_email_label', 'email');?> <br />
                          <?php echo form_input($email, '', 'class="form-control"');?>
                    </p>
                    <p>
                          <?php echo lang('create_user_username_label', 'username');?> <br />
                          <?php echo form_input($username, '', 'class="form-control"');?>
                    </p>

                    <p>
                          <?php echo lang('create_user_phone_label', 'phone');?> <br />
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

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        </div>
         <div class="col-xs-6">
          <div class="box">

            <!-- /.box-header -->
            <div class="box-body">



                 
                    <p>
                          <?php echo lang('create_user_password_label', 'password');?> <br />
                          <?php echo form_input($password, '', 'class="form-control"');?>
                    </p>

                    <p>
                          <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
                          <?php echo form_input($password_confirm, '', 'class="form-control"');?>
                    </p>
                      <div class="form-group">
                        <label for="user_image"><?php echo lang('user_image_upload'); ?></label>                        
                        <input id="user_image" type="file" name="user_image" data-show-upload="false" data-show-preview="false" accept="image/*" class="form-control file">
                                  


                    </div>
                   
                    <div class="form-group">
                          <?php echo lang('user_address_label');?> <br />

                          <?php echo form_input($address, '', 'class="form-control"');?>
                      

                    </div>
                     <div class="form-group">
                    
                    <label class="control-label" for="borrowertype"><?= lang('memtype_name_label')?></label>

                        <select id="member_type" name="member_type" class="form-control">
                          <?php foreach($member_types as $type): ?>
                            <option value="<?= $type->type_id; ?>">
                              <?= $type->borrowertype; ?>
                            </option>
                          <?php endforeach; ?>  
                        </select>
                       
                    </div> 
                    <div class="form-group">
                    
                    <label class="control-label" for="borrowertype"><?= lang('occu_name_label')?></label>

                         <select id="class" name="class" class="form-control">
                          <option><?= lang('occu_name_label')?></option>
                        </select>
                       
                    </div> 
                    
                    
                  

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
            <div class="col-xs-12">
              <p>
                      <?php echo form_submit('submit', lang('create_user_submit_btn'), 'class="btn btn-success"');?>
                      <a href="<?php echo base_url('panel/auth/index'); ?>" class="btn btn-primary">Cancel</a>
                    </p>

              <?php echo form_close();?>
          </div>
         
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