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
            <h4 class="modal-title"><?= lang('edit_occu_title')?></h4>
        </div>
        <div class="modal-body">
              <?= form_open('panel/auth/editOccu'); ?>
        <div class="form-group">
                    <label class="control-label" for="borrowertype"><?= lang('occu_name_label')?></label>
                    <?php echo form_input('occupation', (isset($_POST['occupation']) ? $_POST['occupation'] : $return_data->name),'class="form-control" id="occupation" required="required"');?>
                    <div class="form-group">
                    
                    <label class="control-label" for="borrowertype"><?= lang('memtype_name_label')?></label>

                        <select name="member_type" class="form-control">
                          <?php foreach($member_types as $type): ?>
                            <option value="<?= $type->type_id; ?>" <?= ($type->type_id == $return_data->type_id) ? 'selected' : '';?>>
                              <?= $type->borrowertype; ?>
                            </option>
                          <?php endforeach; ?>  
                        </select>
                       
                    </div> 
                    <?php echo form_hidden('class_id', ($return_data->class_id));?>
        </div>  
        <div class="form-group">
            <?php echo form_submit('submit','Submit', 'class="form-control" id="submit"'); ?>
            </div>
        <?= form_close();?>
        </div>
    </div>
</div>