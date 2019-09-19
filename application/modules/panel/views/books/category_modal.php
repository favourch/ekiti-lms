<script type="text/javascript">
    $('body').on('hidden.bs.modal', '.modal', function () {
      $(this).removeData('bs.modal');
    });
</script>
<div class="modal-dialog" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-content">
        <div class="modal-header no-print">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title"><?= lang('edit_category_title')?></h4>
        </div>
        <div class="modal-body">
            <?= form_open('panel/books/edit_category'); ?>
            <div class="form-group">
                        <label class="control-label" for="category"><?= lang('categories_name_label');?></label>
                <?php echo form_input('category', (isset($_POST['category']) ? $_POST['category'] : $return_data->category_name),'class="form-control" id="category" required="required"');?>
                <?php echo form_hidden('id', ($return_data->id));?>
            </div>  
            <div class="form-group">
                <?php echo form_submit('submit','Submit', 'class="form-control" id="submit"'); ?>
                </div>
            <?= form_close();?>
        </div>
    </div>
</div>