<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src='http://localhost:4000/dev/ci/assets/dist/js/jquery.ui.autocomplete.html.js'></script>
<script src="<?= base_url();?>assets/dist/js/issue_book.js"></script>

<style type="text/css">
  
</style>

<!-- Main content -->
                <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'pos-sale-form', 'name' => 'myForm');
                    echo form_open("panel/borrow/add", $attrib);?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
            <div class="col-md-6">
<div class="well well-sm">
                    <div class="form-group" style="margin-bottom:0;">
                        <div class="input-group wide-tip">
                            <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                <i class="fa fa-2x fa-barcode addIcon"></i></a>
                            </div>
                            <?php echo form_input('add_member', '', 'class="form-control input-lg" id="add_member"'); ?>
                            <input type="hidden" name="member" value="" id="member">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <div class="control-group table-group">
                <label class="table-label"><?= lang('members_label'); ?>*</label>
                     <div class="well profile">
                        <div class="controls table-controls " id="smTable">
                               <style type="text/css">
                                   #smTable:after {
                                        content: "\f059";
                                        font-family: FontAwesome;
                                        font-style: normal;
                                        font-weight: normal;
                                        text-decoration: inherit;
                                        position: absolute;
                                        font-size: 300px;
                                        color: grey;
                                        top: 50%;
                                        left: 50%;
                                        margin: -181px 0 0 -136px;
                                        z-index: 1;
                                    }
                               </style>
                                    
                                                             
                        </div>
                     </div>
                </div>
            </div>
            <div class="col-md-6" id="sticker">
                <div class="well well-sm">
                    <div class="form-group" style="margin-bottom:0;">
                        <div class="input-group wide-tip">
                            <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                <i class="fa fa-2x fa-barcode addIcon"></i></a>
                            </div>
                            <?php echo form_input('add_item', '', 'class="form-control input-lg" id="add_item"'); ?>
                            <input type="hidden" name="items" value="" id="items">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <div class="control-group table-group">
                <label class="table-label"><?= lang('books_label'); ?>*</label>

                <div class="controls table-controls">
                    <table id="slTable"
                           class="table items table-striped table-bordered table-condensed table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            
                            <th><?= lang('book_label'); ?></th>
                            <th><?= lang('price_label'); ?></th>
                            <th><?= lang('isbn_label'); ?></th>
                            <th><?= lang('avail_label'); ?></th>
                            <th><?= lang('qty_label'); ?></th>
                            <th><?= lang('actions_label'); ?></th>
                            
                        </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <label class="control-label" for="due_date"><?= lang('due_date_label'); ?></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar "></i></span>
                                <?php 
                                $limit_days = $settings->issue_limit_days;
                                $date = strtotime("+".$limit_days." day");
                                ?>
                                <input type="text" name="due_date" value="<?= ($settings->issue_conf == 1) ? date('Y-m-d', $date) : '' ?>"  class="form-control" id="due_date" required="required" <?= ($settings->issue_limit_days_extendable) ? '' : 'readonly' ?>/>                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fprom-group pull-right">
                                <?php echo form_submit('add_sale', lang('submit_label'), 'id="add_sale" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset"><?= lang('reset_label'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>
<?php if($settings->issue_limit_days_extendable): ?>
    <style type="text/css">
        .datepicker table tr td.disabled, .datepicker table tr td.disabled:hover{ 
            color: darkgray !important;
        
        }
    </style>
    <script>
        var date = $('#due_date').datepicker({
            dateFormat: 'yy-mm-dd',
            showButtonPanel: true,
            minDate: new Date(<?= date('Y'); ?>, <?= date('m') ?>, <?= date('d'); ?>),
            maxDate: '+30Y',
            inline: true

        });
    </script>
<?php endif; ?>
