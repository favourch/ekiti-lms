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
            
            <h4 class="modal-title" id="myModalLabel"><?= lang('borrowed_by_title'); ?>: <?= $data->name; ?></h4>
        </div>
        <div class="modal-body">
                <?= form_open('panel/borrow/returnbook'); ?>
                <?= form_hidden('submitok', 'yes'); ?>
                <?= form_hidden('borrow_id', $data->id); ?>
                <?= form_hidden('book_id', $data->book_id); ?>
                <?= form_hidden('price', $data->price); ?>
                <?= form_hidden('borrow_details_id', $borrow_details_id); ?>
                <table class="table table-user-information">
                    <tbody>
                        <tr>
                            <td><?= lang('book_label'); ?>:</td>
                            <td><?= $data->title; ?></td>
                        </tr>
                        <tr>
                            <td><?= lang('date_borrow_label'); ?>:</td>
                            <td><?= $data->date_borrow; ?></td>
                        </tr>
                     
                        <?php if($settings->issue_conf == 2): ?>
                            <?php if(!($data->issue_limit_day == 0 || $data->issue_limit_day == -1)):?>
                                <?= form_hidden('fine', ($expired) ? $fine : ""); ?>
                                <tr class="<?= ($expired) ? 'danger': 'success'?>">
                                    <td><?= lang('due_date_label'); ?></td>
                                    <td><?= $data->due_date; ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if(!($data->issue_limit_day == 0 || $data->issue_limit_day == -1)):?>
                                <?php if(($expired)): ?>
                                <tr class="danger">
                                    <td><?= lang('days_up_label'); ?></td>
                                    <td><?= abs($interval); ?></td>
                                </tr>
                                <tr class="danger">
                                    <td><?= lang('fine_label'); ?></td>
                                    <td><?= $fine; ?></td>
                                </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if($settings->issue_conf == 1): ?>
                            <?php if(!($settings->issue_limit_days == 0 || $settings->issue_limit_days == -1)):?>
                                <?= form_hidden('fine', ($expired) ? $fine : ""); ?>
                                <tr class="<?= ($expired) ? 'danger': 'success'?>">
                                    <td><?= lang('due_date_label'); ?></td>
                                    <td><?= $data->due_date; ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if(!($settings->issue_limit_days == 0 || $settings->issue_limit_days == -1)):?>
                                <?php if(($expired)): ?>
                                <tr class="danger">
                                    <td><?= lang('days_up_label'); ?></td>
                                    <td><?= abs($interval); ?></td>
                                </tr>
                                <tr class="danger">
                                    <td><?= lang('fine_label'); ?></td>
                                    <td><?= $fine; ?></td>
                                </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <tr>
                            <div class="form-group">
                                <span><?= lang('is_lost_label'); ?> </span>
                                <label class="radio-inline"><input id="yes" type="radio" name="islost" value="yes" onclick="ShowHideDiv()"><?= lang('yes_title'); ?></label>
                                <label class="radio-inline"><input id="no" type="radio" name="islost" value="no" onclick="ShowHideDiv()" checked="checked"><?= lang('no_title'); ?></label>
                            </div>
                            <div id="islost_div" style="display: none">
                                <label class="form-control" style="background-color: #dd4b39;color: white;"><?= lang('is_lost_label_yes'); ?>: <?= $data->price; ?></label>
                            </div>      
                        </tr>
                    </tbody>
                </table>
            <div class="clearfix"></div>
            <input type="submit" class="btn btn-primary btn-block no-print" type="submit" value="Return Book !!!">
            <?= form_close(); ?>
        </div>
    </div>
</div>