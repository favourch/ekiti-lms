<style type="text/css">
  table.dataTable thead .sorting, 
table.dataTable thead .sorting_asc, 
table.dataTable thead .sorting_desc {
    background : none;
}
</style>

<script>
function actions(x) {
  <?php  
    if ( $status=='pending' ){
  ?> 
  return x;
  <?php }else{ ?>
    return "--"
  <?php } ?>
}
   
    $(document).ready(function () {
        var oTable = $('#PRData').dataTable({
            "aaSorting": [[3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": 10,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= (isset($status)) ? site_url('panel/borrow/getBorrowedBooks/').'/'.$status : site_url('panel/borrow/getBorrowedBooks/')?>',
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
                "data": "title",
                "bSortable": false,
            },{
                "data": "name",
                "bSortable": false,

            }, {
                "data": "date_borrow",
            },{
                "data": "date_return",
            },{
                "data": "due_date",
            },{
                "data": "status",
            },{
                "data": "actions",
                "mRender": actions,
                "bSortable": false,
                

            },
            ],
           
        });
              
    });
     
</script>
 <!-- Main content -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <table id="PRData" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <!-- <th>#</th> -->

                  <th><?= lang('book_label'); ?></th>
                  <th><?= lang('borrower_name_label'); ?></th>
                  <th><?= lang('date_borrow_label'); ?></th>
                  <th><?= lang('date_return_label'); ?></th>
                  <th><?= lang('due_date_label'); ?></th>
                  <th><?= lang('status_label'); ?></th>
                  <th><?= lang('actions_label'); ?></th>

                 
                  
                  
                </tr>
                </thead>
                <tbody>
                        <tr>
                            <td colspan="2" class="dataTables_empty">Loading</td>
                        </tr>
                </tbody>
                <tfoot>
                <tr>
                  <!-- <th>#</th> -->
                  <th><?= lang('book_label'); ?></th>
                  <th><?= lang('borrower_name_label'); ?></th>
                  <th><?= lang('date_borrow_label'); ?></th>
                  <th><?= lang('date_return_label'); ?></th>
                  <th><?= lang('due_date_label'); ?></th>
                  <th><?= lang('status_label'); ?></th>
                  <th><?= lang('actions_label'); ?></th>
                  
                  
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
