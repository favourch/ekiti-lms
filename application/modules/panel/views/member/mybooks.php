<style type="text/css">

.bcimg{
  width: 40px;
}
</style>
<script>
 
function img_hl(x) {
    if (x.substring(0, 7) == 'uploads') {
        return "<img style='width:20px; height:30px;' src=" + baseUrl + x +">";
        
    }else{
      return "<img style='width:20px; height:30px;' src=" + baseUrl + 'assets/uploads/book_covers/' + x +">";

    }
}

function isPdf(x) {
  var div = document.createElement('div');
  div.innerHTML = x // Make it a complete tag
  var link = div.firstChild.getAttribute("href");
  var title = div.firstChild.getAttribute("title");

  if (title == null || title == '') {
    return "Not Available";
  }else{
    return "<a href='"+link+"'>Read</a>";
    
  }
}
function bkFormat(x) {
    if (x != null) {
        var d = '', pqc = x.split("___");
        d = '<strong>' + pqc[0] + '</strong><br>';
        d += '<strong>Publisher: </strong>'+pqc[1] + '<br>';
        d += '<strong>Authors: </strong>' + pqc[2] + '<br>';

        return d;
    } else {
        return '';
    }
}

    $(document).ready(function () {
        var oTable = $('#PRData').dataTable({
            "aaSorting": [[3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": 10,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('panel/issued/getBooks') ?>',
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
                "data": "image",
                "mRender": img_hl,
                "bSortable": false,
            }, {
                "data": "book_title",
                "mRender": bkFormat,

            },{
                "data": "category_name",
            }, {
                "data": "price",
            },
            {
                "data": "borrow_status",
            }, 
            {
                "data": "due_date",
            },  
            { "data": "read", 
                "mRender": isPdf,

             }
             ],
           
        });
              
    });
     
</script>
 <!-- Main content -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            
            <!-- /.box-header -->
            <div class="box-body">
              
              <table id="PRData" class="table table-bordered table-striped">
                <thead>
                <tr>
               
                  <th><?= lang('image_label'); ?></th>
                  <th><?= lang('book_label'); ?></th>
                  <th><?= lang('category_label'); ?></th>
                  <th><?= lang('price_label'); ?></th>
                  <th><?= lang('status_label'); ?></th>
                  <th><?= lang('due_date_label'); ?></th>
                  <th><?= lang('read_label'); ?></th>



                  
                </tr>
                </thead>
                <tbody>
                        <tr>
                            <td colspan="2" class="dataTables_empty">Loading</td>
                        </tr>
                </tbody>
                <tfoot>
                <tr>
                 <th><?= lang('image_label'); ?></th>
                  <th><?= lang('book_label'); ?></th>
                  <th><?= lang('category_label'); ?></th>
                  <th><?= lang('price_label'); ?></th>
                  <th><?= lang('status_label'); ?></th>
                  <th><?= lang('due_date_label'); ?></th>
                  <th><?= lang('read_label'); ?></th>


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
