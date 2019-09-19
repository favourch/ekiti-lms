<style type="text/css">

.bcimg{
  width: 40px;
}
</style>
<style type="text/css">
   
.modal-lg{
    width: 90% !important; 
}
/* =============== MODAL VISUALIZZA =============== */

.bio-row p {
    border: 1px solid rgb(238, 238, 238);
    margin-right: -1px;
}

.bio-row p span {
    padding: 10px 15px;
    display: inline-block;
}

.bio-row p span.bold {
    padding: 10px 15px;

    background-color: rgb(245, 245, 245);
    width: 185px;
    color: rgb(71, 71, 71);
}

.bio-row p span.bold small {
    display: none;
}

.bio-row p span.bold i {
    color: black;
    margin: -10px 10px -10px -15px;
    background-color: rgb(252, 252, 252);
    line-height: 41px;
    width: 40px;
    text-align: center;
}



</style>
<script>
 $(function()
    {
        $('#isbnsearchsubmit').on('click',function(e){
            //e.preventDefault(); to stop default behaviour
            //e.stopPropagation(); to stop bubbling

            var isbn = $('#isbnnumber').val();
            window.location.href = 'books/getBookDetails/'+isbn;

            // similar behavior as clicking on a link

        });
    });
base_url = <?php echo json_encode(base_url()); ?>;

function img_hl(x) {
    // return x == null ? '' : '<div class="text-center"><a href="'+site.base_url+'assets/uploads/' + x + '" data-toggle="lightbox"><img src="'+site.base_url+'assets/uploads/thumbs/' + x + '" alt="" style="width:30px; height:30px;" /></a></div>';
    if (x.substring(0, 7) == 'uploads') {
        return "<img style='width:20px; height:30px;' src=" + base_url + x +">";
        
    }else{
      return "<img style='width:20px; height:30px;' src=" + base_url + 'assets/uploads/book_covers/' + x +">";

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
function actions(x) {
  <?php  
    if ( $this->ion_auth->in_group(array('webmaster', 'admin')) ){
  ?> 
  return x;
  <?php }else{ ?>
    return ""
  <?php } ?>
}
function bkFormat(x) {
    if (x != null) {
        var d = '', pqc = x.split("___");
        d = '<strong>' + pqc[0] + '</strong><br>';
        d += '<strong><?= lang('publisher_label'); ?>: </strong>'+pqc[1] + '<br>';
        d += '<strong><?= lang('author_label'); ?>: </strong>' + pqc[2] + '<br>';
        return d;
    } else {
        return '';
    }
}
function pqFormat(x) {
        var d = '', pqc = x.split(",");

        // for (index = 0; index < pqc.length; ++index) {
        //     var pq = pqc[index];
        //     var v = pq.split(",");
        //     d += v[0] +'<br>';
        // }
        return x;
    
}

    $(document).ready(function () {
        var oTable = $('#PRData').dataTable({
            "aaSorting": [[3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "iDisplayLength": 10,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('panel/books/getBooks') ?>',
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
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData['id'];
                nRow.className = "book_link";
                //if(aData[7] > aData[9]){ nRow.className = "product_link warning"; } else { nRow.className = "product_link"; }
                return nRow;
            },
            "aoColumns": [{
                "bSearchable_": false,
                "data": "image",
                "mRender": img_hl,
                "bSortable": false,
            }, {
                "data": "book_title",
                "name": "book_title",
                "mRender": bkFormat,

            },{
                "data": "category_name",
                "name": "category_name",
            },{
                "data": "total_quantity",
                "name": "total_quantity",

            },{
                "data": "available",
                "name": "available",

            }, {
                "data": "price",
                "name": "books.price",
            },  
            { 
                "data": "read", 
                "name": "read", 
                "bSortable": false,
                "mRender": isPdf,

             },{ 
                "data": "actions", 
                "name": "actions", 
                "bSortable": false,
                "mRender": actions,

             },
             ],
           
        });
              
    });
     
</script>
 <!-- Content Header (Page header) -->
   
      <!-- Small boxes (Stat box) -->
 <!-- Main content -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <span style="font-size: 20px; margin-right: 10px;"><?= lang('book_listing_label'); ?></span>
              <a class="btn btn-primary btn-sm" href="<?= base_url(); ?>panel/books/add"><?= lang('add_book_title'); ?></a><!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#isbn_Modal">
  <?= lang('auto_catalog_title'); ?>
</button>

<!-- Modal -->
<div class="modal fade" id="isbn_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?= lang('isbn_search_title'); ?></h4>
      </div>
      <div class="modal-body">
        <label for="isbnnumber"><?= lang('isbn_search_label'); ?></label>
        <input type="text"  class="form-control" id="isbnnumber" minlength="10" maxlength="13"  onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="isbnnumber" id="isbnnumber">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close_label'); ?></button>
        <button type="button" class="btn btn-primary" id="isbnsearchsubmit"><?= lang('search_label'); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- ============= MODAL View CLient ============= -->
<div class="modal fade" id="view_book" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="title_client_view"></h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="col-md-12">
                                <img id="v_image" src=""  style="width: 200px; height: 280px; margin: 0 auto;">
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-9 bio-row">
                            <p><span class="bold"><i class="fa fa-user"></i> Book Title </span><span id="v_book_title"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-5 bio-row">
                            <p><span class="bold"><i class="fa fa-user"></i> Book Copies </span><span id="v_book_copies"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-user"></i> Available </span><span id="v_available"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-9 bio-row">
                            <p><span class="bold"><i class="fa fa-road"></i> Book Publisher</span><span id="v_book_publisher"></span></p>
                        </div>
                       
                        <div class="col-md-12 col-lg-9 bio-row">
                            <p><span class="bold"><i class="fa fa-envelope"></i> Digital File </span><span id="v_digital_file"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-9 bio-row">
                            <p><span class="bold"><i class="fa fa-envelope"></i> Authors </span><span id="v_authors"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-9 bio-row">
                            <p><span class="bold"><i class="fa fa-envelope"></i> Categories </span><span id="v_categories"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-envelope"></i> ISBN </span><span id="v_isbn"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-envelope"></i> ISBN 13 </span><span id="v_isbn13"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-envelope"></i> Price </span><span id="v_price"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-envelope"></i> Copyright Year </span><span id="v_copyright_year"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-envelope"></i> Date Recieve </span><span id="v_date_recieve"></span></p>
                        </div>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-envelope"></i> Date Added </span><span id="v_date_added"></span></p>
                        </div>
                       
                        <?php 
                          $custom_fields = $settings->books_custom_fields;
                          $custom_fields = explode(',', $custom_fields);
                          foreach($custom_fields as $line): 
                        ?>
                        <div class="col-md-12 col-lg-4 bio-row">
                            <p><span class="bold"><i class="fa fa-info-circle"></i> <?= $line; ?> </span><span class="show_custom" id="v<?= bin2hex($line); ?>"></span></p>
                        </div>
                        <?php endforeach; ?>
                            <div class="col-md-12">
                              <div class="form-group commenti">
                                <label>Description</label>
                                <textarea class="form-control" id="v_description" rows="6" disabled></textarea>
                            </div>
                          </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer" id="footerClient"></div>
        </div>
    </div>
</div>
<a data-toggle="tooltip" title="<?= lang('export_to_pdf'); ?>" class="btn btn-primary pull-right" href="<?= base_url();?>/panel/books/getBooks/pdf">
  <i class="fa fa-file-pdf-o fa-2x"></i>
</a>
<a data-toggle="tooltip" title="<?= lang('export_to_excel'); ?>" class="btn btn-primary pull-right" style="margin-right: 5px" href="<?= base_url();?>/panel/books/getBooks/xls">
  <i class="fa fa-file-excel-o fa-2x"></i>
</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <table id="PRData" style="width: 100%;" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                  <th><?= lang('image_label'); ?></th>
                  <th><?= lang('book_label'); ?></th>
                  <th><?= lang('category_label'); ?></th>
                  <th><?= lang('qty_label'); ?></th>
                  <th><?= lang('avail_label'); ?></th>
                  <th><?= lang('price_label'); ?></th>
                  <th><?= lang('read_label'); ?></th>
                  <th><?= lang('actions_label'); ?></th>
                </tr>
                </thead>
                <tbody>
                        <tr>
                            <td colspan="2" class="dataTables_empty"><?= lang('loading'); ?></td>
                        </tr>
                </tbody>
                <tfoot>
                <tr>
                  <!-- <th>#</th> -->
                  <th><?= lang('image_label'); ?></th>
                  <th><?= lang('book_label'); ?></th>
                  <th><?= lang('category_label'); ?></th>
                  <th><?= lang('qty_label'); ?></th>
                  <th><?= lang('avail_label'); ?></th>
                  <th><?= lang('price_label'); ?></th>
                  <th><?= lang('read_label'); ?></th>
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
</section>
<script type="text/javascript">
$('body').on('click', '#PRData td:not(:first-child, :last-child)', function() {
    var num = $(this).closest('tr').attr('id');
    find(num);
    $('#view_book').modal('show');

});

function find(num) {
        jQuery.ajax({
            type: "POST",
            url: base_url + "panel/books/view",
            data: "id=" + escape(num),
            cache: false,
            dataType: "json",
            success: function (data) {
                if (typeof data.book_title === 'undefined') {
                    $('#view_book').modal('hide');
                } else {
                    jQuery('#title_client_view').html('Book: '+data.book_title);
                    jQuery( ".flatb.add" ).data( "name", data.book_title);
                    jQuery( ".flatb.add" ).data( "id_name", data.id);
                    jQuery( ".flatb.lista" ).data( "name", data.book_title);

                    jQuery('#v_book_title').html(data.book_title);
                    jQuery('#v_book_copies').html(data.total_quantity);
                    jQuery('#v_available').html(data.available);
                    jQuery('#v_book_publisher').html(data.book_pub);

                    if (data.image !== null && data.image !== '') {
                      document.getElementById("v_image").src="<?= base_url(); ?>assets/uploads/book_covers/"+data.image;
                    }else{
                      document.getElementById("v_image").src="<?= base_url(); ?>assets/uploads/book_covers/no_image.png";
                    }


                    if (data.digital_file !== null && data.digital_file !== '') {
                      jQuery('#v_digital_file').html('<a href="<?= base_url();?>panel/books/read/'+data.id+'" target="_black">Read</a>');
                    }else{
                      jQuery('#v_digital_file').html('Not Available');
                    }

                    jQuery('#v_isbn').html(data.isbn);
                    jQuery('#v_isbn13').html(data.isbn_13);
                    jQuery('#v_price').html(data.price);
                    jQuery('#v_copyright_year').html(data.copyright_year);
                    jQuery('#v_date_recieve').html(data.date_receive);
                    jQuery('#v_date_added').html(data.date_added);
                    jQuery('#v_description').html(data.description);
                    jQuery('#v_authors').html(data.author_name);
                    jQuery('#v_categories').html(data.category_name);
                    

                    jQuery('.show_custom').html('');

                    var IS_JSON = true;
                    try
                    {
                        var json = $.parseJSON(data.custom_fields);
                    }
                    catch(err)
                    {
                        IS_JSON = false;
                    }                

                    if(IS_JSON) 
                    {

                        $.each(json, function(id_field, val_field) {
                            jQuery('#v'+id_field).html(val_field);
                        });
                    }
                   
                    var string = "<button data-dismiss=\"modal\" class=\"btn btn-default\" type=\"button\"><i class=\"fa fa-reply\"></i> Go Back</button>";

                    jQuery('#footerClient').html(string);
                }
            }
        });
    }
</script>