<script>
  function status(x) {
    if (x == 0) {
      return '<span class="label" style="background-color: black;"><?= lang('rejected'); ?></span>';
    }else if (x == 1){
      return '<span class="label label-warning"><?= lang('pending'); ?></span>';
    }else if (x == 2){
      return '<span class="label label-info"><?= lang('approved'); ?></span>';
    }else if (x == 3){
      return '<span class="label label-success"><?= lang('ready'); ?></span>';
    }
  }

  function status_toggle(x) {
     pqc = x.split("____");
     var rid = pqc[0];
     var status_id = pqc[1];

     var string = '';
      if (status_id == 1) {
          string = string + '<a class="btn btn-primary btn-sm" href="<?= base_url(); ?>panel/requested_books/status_toggle/approve/'+rid+'"><i class=\"fa fa-check\"></i> <?= lang('approve'); ?></a>';
          string = string + '<a class="btn btn-danger btn-sm" href="<?= base_url(); ?>panel/requested_books/status_toggle/reject/'+rid+'"><i class=\"fa fa-times\"></i> <?= lang('reject'); ?></a>';
      }
      if (status_id == 2) {
         string = string + '<a class="btn btn-info btn-sm" href="<?= base_url(); ?>panel/requested_books/status_toggle/complete/'+rid+'"><i class=\"fa fa-check\"></i> <?= lang('ready'); ?></a>';
      }
      if (status_id == 3 || status_id == 0) {
        string += '--';
      }
      
      return string;
  }
    $(document).ready(function () {
        var oTable = $('#PRData').dataTable({
            "aaSorting": [[3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": 10,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('panel/requested_books/getRequestedBooks') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            }, 
            "aoColumns": [
              null,
              null,
              null,
              null,
              null,
              null,
              null,
              {mRender: status},
              {mRender: status_toggle},
             ],
        });
    });

  
</script>
<style type="text/css">
  .input-xs {
    height: 22px;
    padding: 2px 5px;
    font-size: 12px;
    line-height: 1.5; /* If Placeholder of the input is moved up, rem/modify this. */
    border-radius: 3px;
  }
</style>
 <!-- Main content -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="col-md-4">
                <h3 class="box-title"><?= lang('request_title'); ?></h3>
              </div>
              <div class="col-md-6">
                <?= form_open('panel/requested_books/delete_records');?>
                  <small><?= sprintf(lang('purge_label'), '<input type="number" min="0" name="days" required>') ?> <button class="btn input-xs btn-info"><?= lang('submit'); ?></button></small>
                </form>
              </div>
            </div>
            <div class="box-body">
            <div class="row">
            <div class="col-xs-12">
            <div class="table-responsive">
              
              <table id="PRData" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th><?= lang('request_member_name'); ?></th>
                  <th><?= lang('request_book_title'); ?></th>
                  <th><?= lang('request_author_name'); ?></th>
                  <th><?= lang('request_year'); ?></th>
                  <th><?= lang('request_remarks'); ?></th>
                  <th><?= lang('request_date'); ?></th>
                  <th><?= lang('request_status'); ?></th>
                  <th><?= lang('request_actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                      <td colspan="2" class="dataTables_empty"><?= lang('loading'); ?></td>
                  </tr>
                </tbody>
                <tfoot>
                <tr>
                  <th>#</th>
                  <th><?= lang('request_member_name'); ?></th>
                  <th><?= lang('request_book_title'); ?></th>
                  <th><?= lang('request_author_name'); ?></th>
                  <th><?= lang('request_year'); ?></th>
                  <th><?= lang('request_remarks'); ?></th>
                  <th><?= lang('request_date'); ?></th>
                  <th><?= lang('request_status'); ?></th>
                  <th><?= lang('request_actions'); ?></th>
                </tr>
                </tfoot>
              </table>
            </div>
            </div>
            </div>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
