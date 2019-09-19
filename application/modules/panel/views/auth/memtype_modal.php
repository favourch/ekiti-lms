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
            <h4 class="modal-title"><?= lang('edit_memtype_title')?></h4>
        </div>
        <div class="modal-body">
              <?= form_open('panel/auth/editMemType'); ?>
        <div class="form-group">
            <label class="control-label" for="borrowertype"><?= lang('memtype_name_label')?></label>
            <?php echo form_input('borrowertype', (isset($_POST['borrowertype']) ? $_POST['borrowertype'] : $return_data->borrowertype),'class="form-control" id="borrowertype" required="required"');?>
            <?php echo form_hidden('type_id', ($return_data->type_id));?>
        </div>  
        <?php if($issue_conf == 2): ?>
            <div class="form-group">
              <label class="control-label" for="issue_limit_books"><?= lang('settings_fine_limit_book')?></label>
              <?php echo form_input('issue_limit_books', $return_data->issue_limit_books, 'class="form-control" id="issue_limit_books"');?>
            </div>  
            <div class="form-group">
              <label class="control-label" for="issue_limit_days"><?= lang('settings_fine_limit_days')?></label>
              <?php echo form_input('issue_limit_days', $return_data->issue_limit_day, 'class="form-control" id="issue_limit_days"');?>
            </div>  
        <?php endif; ?>
        <div class="form-group">
            <?php echo form_submit('submit','Submit', 'class="form-control" id="submit"'); ?>
            </div>
        <?= form_close();?>
        </div>
    </div>
</div>