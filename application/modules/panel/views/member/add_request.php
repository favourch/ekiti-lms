<script>
// assumes you're using jQuery
$(document).ready(function() {
$('.confirm-div').hide();
<?php if($this->session->flashdata('error')){ ?>
	$('.confirm-div').html('<?php echo $this->session->flashdata('error'); ?>').show();
<?php } ?>
});

</script>
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
	        <div class="box-header with-border">
	          <h3 class="box-title"><?= lang('add_request_book_title'); ?></h3>
	    	<div class="box-body">
	          <?php echo validation_errors('<span class="error">', '</span>');?>
	          <div class="alert alert-danger confirm-div"></div>
	    		<div class="col-md-6">
	    			<?php $attrib = array('data-toggle' => 'validator', 'role' => 'form'); ?>

		    		<?php echo form_open(); ?>
		    		
		          	<div class="form-group">
		              	<label class="control-label" for="book_title"><?= lang('request_book_title'); ?></label>
						<?php echo form_input('book_title', (isset($_POST['book_title']) ? $_POST['book_title'] : ""),'class="form-control" id="book_title" required="required"');?>
		          	</div>
		          	<div class="form-group">
		              	<label class="control-label" for="book_pub"><?= lang('request_author_name'); ?></label>
						<?php echo form_input('author_name', (isset($_POST['author_name']) ? $_POST['author_name'] : ""),'class="form-control" id="author_name" required="required"');?>
		         	</div>

		           	<div class="form-group">
		              	<label class="control-label" for="copyright_year"><?= lang('request_year'); ?></label>

						<?php echo form_input('copyright_year', (isset($_POST['copyright_year']) ? $_POST['copyright_year'] : ""),'class="form-control" id="copyright_year" required="required"');?>
		          	</div>
				</div>
				<div class="col-md-6">
		          	<div class="form-group">
			          	<label class="control-label" for="remarks"><?= lang('request_remarks'); ?></label>
						<?php echo form_textarea('remarks', (isset($_POST['remarks']) ? $_POST['remarks'] : ""),'class="form-control" id="remarks"');?>
			      	</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<?php echo form_submit('submit', lang('submit_label'), 'class="form-control" id="submit"'); ?>
				  	</div>
			 		<?php echo form_close() ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</section>
<script type="text/javascript">
$(document).ready(function() {
	$(".select").select2();
	$('#copyright_year').datepicker({
      	autoclose: true,
      	viewMode: "years", 
    	minViewMode: "years",
      	format: 'yyyy'
    });
});
</script>
