<?php
$details = json_decode(json_encode($book_details), True);
?>

<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
	        <div class="box-header with-border">
	          <h3 class="box-title"><?= lang('edit_book_title'); ?></h3>
	    	<div class="box-body">
	          <?php echo validation_errors('<span class="error">', '</span>');?>

	    		<div class="col-md-6">
	    			<?php $attrib = array('data-toggle' => 'validator', 'role' => 'form'); ?>
	    			<?php if(!empty($details['id'])){ ?>
		    		<?php echo form_open_multipart('panel/books/edit'); ?>
	          		<input type="hidden" name="book_id" value="<?= $details['id']; ?>">
	          		<?php }else{ ?>
		    			<?php echo form_open_multipart('panel/books/add'); ?>
	          		<?php } ?>
		    		<div class="form-group">
		              	<label class="control-label" for="book_type"><?= lang('edit_book_type_title'); ?></label>
		                <?php
		                $opts = array('standard' => 'Standard', 'digital' => 'Digital');
		                echo form_dropdown('type', $opts, 
		                		(isset($_POST['type']) ? $_POST['type'] : ""),
		                		 'class="form-control" id="type" required="required"');
		                ?>
		            </div>
		          	<div class="form-group">
		              	<label class="control-label" for="isbn"><?= lang('edit_isbn_label'); ?></label>
		          		<?php echo form_input('isbn', (!empty($details['isbn']) ? $details['isbn'] : "ISBN"),'class="form-control" id="isbn" required="required"'); ?>
		          	</div>
		         
		          	<div class="form-group">
		              	<label class="control-label" for="book_title"><?= lang('edit_book_label'); ?></label>
						<?php echo form_input('book_title', (!empty($details['book_title']) ? $details['book_title'] : ""),'class="form-control" id="book_title" required="required"');?>
		          	</div>
		          	<div class="form-group">
		              	<label class="control-label" for="category_id"><?= lang('edit_category_label'); ?></label>
						
                        <select name="category_id[]" class="form-control select" id="category_id" required="required" style="width:100%" multiple="multiple">
						<?php 
						$arr = explode(',', $details['category_name']);

						foreach ($categories as $category) { ?>
							
						 	<option value='<?= $category->id; ?>' <?= (in_array($category->id, $arr) ? "selected" : ""); ?>><?= $category->category_name; ?></option>
                        <?php } ?>
						</select>
		          	</div>
		          	<div class="form-group">
		              	<label class="control-label" for="author_id"><?= lang('edit_author_label'); ?></label>
                        <select name="author_id[]" class="form-control select" id="author_id" required="required" style="width:100%" multiple="multiple">
						
                        <?php 
						$arr = explode(',', $details['author_name']);

						foreach ($authors as $author) { ?>
							
						 	<option value='<?= $author->id; ?>' <?= (in_array($author->id, $arr) ? "selected" : ""); ?>><?= $author->author_name; ?></option>
                        <?php } ?>
                        </select>
		       	  	</div>

                    <div class="digital" style="display:none;">
                        <div class="form-group digital">
                        	<label for="digital_file"><?= lang('edit_digital_file_label'); ?><small>PDF</small></label>         
                            <input id="digital_file" type="file" data-browse-label="Browse" name="digital_file" data-show-upload="false"
                                   data-show-preview="false" class="form-control file">
                        </div>
                    </div>
                     <div class="form-group">
                        <label for="book_image"><?= lang('edit_image_label'); ?></label>                        
                        <input id="book_image" type="file" name="book_image" data-show-upload="false" data-show-preview="false" accept="image/*" class="form-control file">
                                  


                    </div>

				</div>
				<div class="col-md-6">
		    		<div class="form-group">
		              	<label class="control-label" for="isbn_13"><?= lang('edit_isbn_13_label'); ?></label>

						<?php echo form_input('isbn_13', (!empty($details['isbn_13']) ? $details['isbn_13'] : ""),'class="form-control" id="isbn_13"');?>
		          	</div>
		          	<div class="form-group">
		              	<label class="control-label" for="book_copies"><?= lang('edit_qty_label'); ?></label>
						<input type="number" name='book_copies' id='book_copies' step="any" class="form-control" id="book_copies" required="required" min=0 value="<?php echo (!empty($details['book_copies']) ? $details['book_copies'] : "") ?>" />

		          	</div>
		           	<div class="form-group">
		              	<label class="control-label" for="book_pub"><?= lang('edit_publisher_label'); ?></label>

						<?php echo form_input('book_pub', (!empty($details['book_pub']) ? $details['book_pub'] : ""),'class="form-control" id="book_pub" required="required"');?>
		         	</div>
		         	<div class="form-group">
		              	<label class="control-label" for="price"><?= lang('edit_price_label'); ?></label>
						<input type="number" name='price' id='price' step="any" class="form-control" id="price" required="required" min=0 value="<?php echo (!empty($details['price']) ? $details['price'] : "") ?>" />
		          	</div>
		           	<div class="form-group">
		              	<label class="control-label" for="copyright_year"><?= lang('edit_cp_year_label'); ?></label>

						<?php echo form_input('copyright_year', (!empty($details['copyright_year']) ? $details['copyright_year'] : ""),'class="form-control" id="copyright_year" required="required"');?>
		          	</div>
		          	<div class="form-group">
		              	<label class="control-label" for="date_receive"><?= lang('edit_rd_label'); ?></label>

						<?php echo form_input('date_receive', (!empty($details['date_receive']) ? $details['date_receive'] : ""),'class="form-control" id="date_receive" required="required"');?>
		          	</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<input type="hidden" id="custom_fields" value='<?= rawurlencode($details['custom_fields']); ?>'>
						<?php 
		                    $custom_fields = $settings->books_custom_fields;
		                    $custom_fields = explode(',', $custom_fields);
		                    foreach($custom_fields as $line): 
		                ?>
			                <div class="col-lg-4 col-sm-12">
			                    <div class="form-group">
			                        <label>
			                            <?= $line; ?>
			                        </label>
			                        <input name="cust_<?= bin2hex($line); ?>" id="cust_<?= bin2hex($line); ?>" type="text" value="" class="custom validate form-control" />
			                    </div>
			                </div>
		                <?php endforeach; ?>
					</div>
				</div>
				<div class="col-md-12">
				
					<div class="form-group">
			          	<label class="control-label" for="description"><?= lang('edit_desc_label'); ?></label>
						<?php echo form_textarea('description', (!empty($details['description']) ? $details['description'] : ""),'class="form-control" id="description"');?>
			      	</div>
					<div class="form-group">
						<?php echo form_submit('submit',lang('submit_label'), 'class="form-control" id="submit"'); ?>
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
	$('#type').change(function () {
            var t = $(this).val();
            if (t !== 'digital') {
                $('.digital').slideUp();
                $('#digital_file').removeAttr('required');
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'digital_file');
            } else {
                $('.digital').slideDown();
                $('#digital_file').attr('required', 'required');
                $('form[data-toggle="validator"]').bootstrapValidator('addField', 'digital_file');
            }
            
        });

</script><script type="text/javascript">
$(document).ready(function() {
	$(".select").select2();
	$('#date_receive').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    });
    $('#copyright_year').datepicker({
      	autoclose: true,
      	viewMode: "months", 
    	minViewMode: "months",
      	format: 'mm-yyyy'
    });

});
var IS_JSON = true;

try {
    var json = $.parseJSON(decodeURIComponent(jQuery('#custom_fields').val()));
} catch(err) {
    IS_JSON = false;
}       

if(IS_JSON) {
    $.each(json, function(id_field, val_field) {
        jQuery('#cust_'+id_field).val(val_field);
    });
}

</script>
