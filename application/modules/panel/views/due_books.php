<style type="text/css">
  table.dataTable thead .sorting, 
table.dataTable thead .sorting_asc, 
table.dataTable thead .sorting_desc {
    background : none;
}
</style>
<script>
function showCSTemplates(sel){   
  var email = <?php echo json_encode($due_book); ?>;
  var sms = <?php echo json_encode($due_book_sms); ?>;

locations =[ "", /*this remains blank for first selection in drop-down list*/ 
/*option 1*/                 
email,
/*option 2*/                
sms,
];
srcLocation = locations[sel.selectedIndex];    
   if (srcLocation != undefined && srcLocation != "") {      
      document.getElementById('CSTemplates').innerHTML= srcLocation;   
 } 
}
</script>
<script>
$(document).ready(function () {
    $('#submit').click(function() {
      checked = $("input[type=checkbox]:checked").length;
      if(!checked) {
        alert("You must check at least one checkbox.");
        return false;
      }
    });
});

    $(document).ready(function () {
        var oTable = $('#PRData').dataTable({
            "aaSorting": [[3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": 10,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('panel/delayed/due_books_json/') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            }, 
            // "columnDefs": [
            //   { "width": '20%', "targets": 0 }
            // ],
            // "fixedColumns": true,

            "aoColumns": [{
              "bSortable": false,
              "mRender": checkbox,
              "data": "checkbox",
            }, {
                "data": "title",
                "bSortable": false,
            }, {
              "data": "name",
              "bSortable": false,

            }, {
                "data": "date_borrow",
            },{
                "data": "due_date",
            }
            ],
           
        });
              
    });
     
</script>
    <?= form_open('panel/delayed/notify_delayed'); ?>

 <!-- Main content -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#send">
              <?= lang('remind_due'); ?>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="send" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?= lang('remind_due'); ?></h4>
                  </div>
                  <div class="modal-body">
                  <div class="form-group">
                    <label><?= lang('reminder_type'); ?>: </label>
                    <select onchange="showCSTemplates(this);" class="form-control" name="type" required="required">
                      <option selected="selected" value="" id="Templates">Please select...</option>
                      <option value="email"><?= lang('email_label');?></option>
                      <option value="sms"><?= lang('sms_label');?></option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label><?= lang('subject_reminder'); ?>: </label>
                    <input type="text" name="subject" class="form-control">
                  </div>

                  <div class="form-group" required="required">
                    <label><?= lang('reminder_message'); ?>: </label>
                    <textarea name="message" id="CSTemplates" class="form-control" rows="20"><?= lang('select_type'); ?></textarea>
                  </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('settings_cancel'); ?></button>
                    <button class="btn btn-flat btn-default" id="submit" type="submit"><?= lang('send_label'); ?><i class="fa fa-envelope" aria-hidden="true"></i></button>
                   
                  </div>
                </div>
              </div>
            </div>
            
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <table id="PRData" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <!-- <th>#</th> -->
                  <th style="min-width:30px; width: 30px; text-align: center;">
                      <div class="text-center">
                        <input class="checkbox checkth" type="checkbox" name="check"/>
                      </div>
                  </th>
                  <th><?= lang('book_label'); ?></th>
                  <th><?= lang('borrower_name_label'); ?></th>
                  <th><?= lang('date_borrow_label'); ?></th>
                  <th><?= lang('due_date_label'); ?></th>
                </tr>
                </thead>
                <tbody>
                        <tr>
                            <td colspan="2" class="dataTables_empty">Loading</td>
                        </tr>
                </tbody>
                <tfoot>
                <tr>
                  <th>#</th>
                  <th><?= lang('book_label'); ?></th>
                  <th><?= lang('borrower_name_label'); ?></th>
                  <th><?= lang('date_borrow_label'); ?></th>
                  <th><?= lang('due_date_label'); ?></th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    <?= form_close(); ?>



