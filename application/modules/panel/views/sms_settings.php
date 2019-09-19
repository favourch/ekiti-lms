 
   <!-- Main content -->
    <section class="content">

    <div class="box box-info">
		    	<div class="box-header">
		         <h3 class="box-title"><i class="fa fa-pencil"></i> <?= lang('settings_title');?></h3>
		        </div><!-- /.box-header -->
		       		<!-- form start -->
		    <form class="form-horizontal" action="<?= base_url();?>panel/settings/sms" method="POST">
		    <?php echo validation_errors(); ?>

		        <div class="box-body">
		           	<div class="form-group">
		              	<label class="col-sm-3 control-label" for="name">SMS Gateway *     	</label>
	                	<div class="col-sm-9 col-md-6 col-lg-6">
							<div class="radio">
							 	 <label><input <?= ($sms_config->sms_gateway == 'twilio') ? 'checked' : '' ?> type="radio" value="twilio" name="sms_gateway" class="sms_gateway" > Twilio (https://www.twilio.com/)</label>
							</div>							
							<div class="radio">
							 	 <label><input <?= ($sms_config->sms_gateway == 'clickatell') ? 'checked' : '' ?> type="radio" value="clickatell" name="sms_gateway" class="sms_gateway" > Clickatell (https://www.clickatell.com)</label>
							</div>
							<div class="radio">
							 	 <label><input <?= ($sms_config->sms_gateway == 'nexmo') ? 'checked' : ''?> type="radio" value="nexmo" name="sms_gateway" class="sms_gateway" > Nexmo (https://www.nexmo.com)</label>
							</div>
	             		</div>
		            </div>

		            <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"> Auth ID / Username*	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			<input value="<?= $sms_config->auth_id ?>" required id="auth_id" name="auth_id" class="form-control" size="20"  >
	             		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"> Auth Token / Password *	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			 <input value="<?= $sms_config->auth_token ?>" required id="auth_token" name="auth_token" class="form-control" size="20" >
                		</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"> Phone Number/ Mask	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			<input value="<?= $sms_config->phone_number ?>" id="phone_number" name="phone_number" class="form-control" size="20" >
             			</div>
		           </div> 

		           <div class="form-group">
		             	<label class="col-sm-3 control-label" for="name"> API ID (Clickatell only)	</label>
	             		<div class="col-sm-9 col-md-6 col-lg-6">
	               			<input value="<?= $sms_config->api_id ?>" id="api_id" name="api_id" class="form-control" size="20" >
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

