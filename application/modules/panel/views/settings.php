 
   <!-- Main content -->
    <section class="content">

    <div class="box box-info">
		    	<div class="box-header">
		         <h3 class="box-title"><i class="fa fa-pencil"></i> <?= lang('settings_title');?></h3>
		        </div><!-- /.box-header -->
		       		<!-- form start -->
		    <form class="form-horizontal" enctype="multipart/form-data" action="<?= base_url();?>panel/settings" method="POST">
		    <?php echo validation_errors(); ?>

		        <div class="box-body">
		           		<div class="form-group">
		              	<label class="col-sm-3 control-label" for=""><?= lang('settings_name'); ?> *
		              	</label>
		                	<div class="col-sm-9">
		               			<input name="name" value="<?= $settings->title?>"  class="form-control" type="text">		               
		             			<span class="red"></span>
		             		</div>
		            </div>
		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('settings_address'); ?> *
		             	</label>
	             		<div class="col-sm-9">
	               			<input name="address" value="<?= $settings->address?>"  class="form-control" type="text">		          
	             			<span class="red"></span>
	             		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('settings_email'); ?> *
		             	</label>
	             		<div class="col-sm-9">
	               			<input name="email" value="<?= $settings->email; ?>"  class="form-control" type="email">		          
	             			<span class="red"></span>
	             		</div>
		           </div>  


		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('settings_phone'); ?> *
		             	</label>
	             		<div class="col-sm-9">
	               			<input name="phone" value="<?= $settings->phone; ?>"  class="form-control" type="text">		          
	             			<span class="red"></span>
	             		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('settings_logo'); ?> 
		             	</label>
	             		<div class="col-sm-9">
		           			<div class='text-center'><img class="img-responsive" src="<?= base_url().'assets/uploads/logos/'.$settings->logo; ?>" alt="Logo"/></div>
	               			Max Dimension : 600 x 300,Max Size : 200KB, Format : png
	               			<input name="logo" class="form-control" type="file">		          
	             			<span class="red"> </span>
	             		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('settings_favicon'); ?> 
		             	</label>
	             		<div class="col-sm-9">
	             			<div class='text-center'><img class="img-responsive" src="<?= base_url().'assets/uploads/logos/favicons/'. $settings->favicon?>" alt="Favicon"/></div>
	               			Max Dimension : 32 x 32,Max Size : 50KB, Format : ico
	               			<input name="favicon"  class="form-control" type="file">		          
	             			<span class="red"></span>
	             		</div>
		           </div> 

 					<div class="form-group">
		             	<label class="col-sm-3 control-label" for="fine"><?= lang('settings_fine'); ?> 
		             	</label>
	             		<div class="col-sm-9">
	             			<input type="text" class="form-control" name="fine" value="<?= $settings->fine;?>">	          
	             			<span class="red"></span>
	             		</div>
		          	</div> 
					
					<div class="form-group">
		             	<label class="col-sm-3 control-label" for="issue_conf"><?= lang('settings_fine_conf'); ?> 
		             	</label>
	             		<div class="col-sm-9">
	             			<select name="issue_conf" id="issue_conf" class="form-control">
	             				<option value="1" <?= ($settings->issue_conf == 1) ? 'selected' : '' ?>><?= lang('settings_fine_syswide'); ?></option>
	             				<option value="2" <?= ($settings->issue_conf == 2) ? 'selected' : '' ?>><?= lang('settings_fine_memwise'); ?></option>
	             			</select>
	             		</div>
		          	</div> 
                    <div class="issue_config" style="display:none;">
			          	<div class="form-group">
			             	<label class="col-sm-3 control-label" for="issue_limit_books"><?= lang('settings_fine_limit_book'); ?> 
			             	</label>
		             		<div class="col-sm-9">
             					<input type="text" class="form-control" name="issue_limit_books" id="issue_limit_books" value="<?= $settings->issue_limit_books;?>">
             					<span class="red"></span>
		             		</div>
			          	</div> 
			          	<div class="form-group">
			             	<label class="col-sm-3 control-label" for="issue_limit_days"><?= lang('settings_fine_limit_days'); ?> 
			             	</label>
		             		<div class="col-sm-9">
             					<input type="text" class="form-control" name="issue_limit_days" id="issue_limit_days" value="<?= $settings->issue_limit_days;?>">
             					<span class="red"></span>
		             		</div>
			          	</div> 

			          	

					</div>
					
					<div class="form-group">
		             	<label class="col-sm-3 control-label" for="issue_conf"><?= lang('notify_delayed_no_days_limit_toggle'); ?> 
		             	</label>
	             		<div class="col-sm-9">
	             			<select name="notify_delayed_no_days_limit_toggle" id="notify_delayed_no_days_limit_toggle" class="form-control">
	             				<option value="1" <?= ($settings->notify_delayed_no_days_limit_toggle) ? 'selected' : '' ?>><?= lang('settings_yes'); ?></option>
	             				<option value="0" <?= (!$settings->notify_delayed_no_days_limit_toggle) ? 'selected' : '' ?>><?= lang('settings_no'); ?></option>
	             			</select>
	             		</div>
		          	</div> 
					
					<div class="form-group">
		             	<label class="col-sm-3 control-label" for="issue_conf"><?= lang('issue_limit_days_extendable'); ?> 
		             	</label>
	             		<div class="col-sm-9">
	             			<select name="issue_limit_days_extendable" id="issue_limit_days_extendable" class="form-control">
	             				<option value="1" <?= ($settings->issue_limit_days_extendable) ? 'selected' : '' ?>><?= lang('settings_yes'); ?></option>
	             				<option value="0" <?= (!$settings->issue_limit_days_extendable) ? 'selected' : '' ?>><?= lang('settings_no'); ?></option>
	             			</select>
	             		</div>
		          	</div> 

		           

		           	<div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('smtp_user'); ?> 
		             	</label>
	             		<div class="col-sm-9">
	               			<input name="smtp_user" value="<?= $settings->smtp_user; ?>"  class="form-control" type="text">		          
	             			<span class="red"></span>
	             		</div>
		           </div> 
		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('smtp_host'); ?> 
		             	</label>
	             		<div class="col-sm-9">
	               			<input name="smtp_host" value="<?= $settings->smtp_host; ?>"  class="form-control" type="text">		          
	             			<span class="red"></span>
	             		</div>
		           </div> 
		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('smtp_port'); ?> 
		             	</label>
	             		<div class="col-sm-9">
	               			<input name="smtp_port" value="<?= $settings->smtp_port; ?>"  class="form-control" type="text">		          
	             			<span class="red"></span>
	             		</div>
		           </div> 
		           
		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('smtp_pass'); ?> 
		             	</label>
	             		<div class="col-sm-9">
	               			<input name="smtp_pass" placeholder="********" class="form-control" type="text">		          
	             			<span class="red"></span>
	             		</div>
		           </div> 


		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('email_request'); ?> 
		             	</label>
	             		<div class="col-sm-9">
		             		<select name="email_request" class="form-control">
	             				<option value="0" <?= ($settings->email_request == 0) ? 'selected' : '' ?>><?= lang('settings_no'); ?></option>
	             				<option value="1" <?= ($settings->email_request == 1) ? 'selected' : '' ?>><?= lang('settings_yes'); ?></option>
	             			</select>
	             		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('sms_request'); ?> 
		             	</label>
	             		<div class="col-sm-9">
		             		<select name="sms_request" class="form-control">
	             				<option value="0" <?= ($settings->sms_request == 0) ? 'selected' : '' ?>><?= lang('settings_no'); ?></option>
	             				<option value="1" <?= ($settings->sms_request == 1) ? 'selected' : '' ?>><?= lang('settings_yes'); ?></option>
	             			</select>
	             		</div>
		           </div> 
		           
		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('books_custom_fields'); ?> 
		             	</label>
	             		<div class="col-sm-9">
	               			 <select id="books_custom_fields" name="books_custom_fields[]"  class="form-control" multiple="" width="100%" tabindex="-1" aria-hidden="true" style="width: 100%">
                            <?php
								$campi =  explode(',', $settings->books_custom_fields);
								foreach($campi as $line){
								    echo '<option data-select2-tag="true" selected value="'.$line.'">'.$line.'</option>';
								} 
                            ?>
                                </select>
	             		</div>
		           </div> 

		         

		            <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('settings_currency'); ?> 
		             	</label>
	             		<div class="col-sm-9">
	               			<input name="currency" value="<?= $settings->currency; ?>"  class="form-control" type="text">		          
	             			<span class="red"></span>
	             		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for=""><?= lang('settings_tnc'); ?>	             	</label>
	             		<div class="col-sm-9">
	               			<textarea name="condition" class="form-control" rows="6" id="condition"><?= $settings->terms_conditions; ?></textarea>	
	             			<span class="red"></span>
	             		</div>
		           </div> 
		          
		         		               
		           </div> <!-- /.box-body --> 

		           	<div class="box-footer">
		            	<div class="form-group">
		             		<div class="col-sm-12 text-center">
		               			<input name="submit" type="submit" class="btn btn-warning btn-lg" value="<?= lang('settings_save'); ?>"/>  
		              			<input type="button" class="btn btn-default btn-lg" value="<?= lang('settings_cancel'); ?>" onclick='goBack("admin_config",1)'/>  
		             		</div>
		           		</div>
		         	</div><!-- /.box-footer -->         
		        </div><!-- /.box-info -->       
		    </form>  
		    <script>
		    	    $("#condition").wysihtml5();

		    </script>   
<script type="text/javascript">
		$('#issue_conf').change(function () {
            var t = $(this).val();
            if (t !== '1') {
                $('.issue_config').slideUp();
                
                $('#issue_limit_books').removeAttr('required');
                $('#issue_limit_days').removeAttr('required');
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'issue_limit_books');
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'issue_limit_days');
            } else {
                $('.issue_config').slideDown();
                $('#issue_limit_books').attr('required', 'required');
                $('#issue_limit_days').attr('required', 'required');
                $('form[data-toggle="validator"]').bootstrapValidator('addField', 'issue_limit_books');
                $('form[data-toggle="validator"]').bootstrapValidator('addField', 'issue_limit_days');
            }
            
        });
        $(document).ready(function(){
            var t = $("#issue_conf").val();
            if (t !== '1') {
                $('.issue_config').slideUp();
                
                $('#issue_limit_books').removeAttr('required');
                $('#issue_limit_days').removeAttr('required');
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'issue_limit_books');
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'issue_limit_days');
            } else {
                $('.issue_config').slideDown();
                $('#issue_limit_books').attr('required', 'required');
                $('#issue_limit_days').attr('required', 'required');
                $('form[data-toggle="validator"]').bootstrapValidator('addField', 'issue_limit_books');
                $('form[data-toggle="validator"]').bootstrapValidator('addField', 'issue_limit_days');
            }
        	$("#books_custom_fields").select2({tags: true});

		});

</script>