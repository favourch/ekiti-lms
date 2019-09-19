<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src='<?= base_url();?>assets/dist/js/book_return.js'></script>
<style type="text/css">
    .profile 
    {
    min-height: 355px;
    display: inline-block;
    width: 100%;
    }
</style>

<script>

</script>
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
    <button type="button" class="btn btn-danger" id="reset"><?= lang('reset_label'); ?></button></div>
</div>
</div>
</div></div></div>
<?php echo form_close(); ?>

<style type="text/css">
    .datepicker table tr td.disabled, .datepicker table tr td.disabled:hover{ 
        color: darkgray !important;
    
    }
</style>
<script type="text/javascript">
    $('#add_member').keypress(
    function(event){
     if (event.which == '13') {
        event.preventDefault();
      }
});
</script>
