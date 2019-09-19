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
    $(document).ready(function () {
        var oTable = $('#PRData').dataTable({
            "aaSorting": [[3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": 10,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('panel/request/getRequestedBooks') ?>',
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
              {mRender: status},
              null,
             ],
        });
    });
</script>

 <!-- Main content -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?= lang('request_title'); ?></h3>
              <a href="<?= base_url();?>panel/request/add_requested_books" class="btn btn-primary"><?= lang('request_book_add'); ?></a href="<?= base_url();?>panel/request/add_requested_books">
            </div>
            <div class="box-body">
                <div class="row">
                  <div class="col-xs-12">
                    <div class="table-responsive">
                      <table id="PRData" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>#</th>
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
