
$(document).ready(function () {

    // clear localStorage and reload
    $('#reset').click(function (e) {
        if (localStorage.getItem('issued')) {
            localStorage.removeItem('issued');
        }
        if (localStorage.getItem('issued_members')) {
            localStorage.removeItem('issued_members');
        }
        

        //location.reload();
        window.location.href = baseUrl+"panel/borrow/bookreturn";
    });

if (localStorage.getItem('issued_members')) {
    loadmember();
}
});
function loadmember() {

    if (localStorage.getItem('issued_members')) {
        total = 0;
        count = 1;
        an = 1;
        product_tax = 0;
        invoice_tax = 0;
        product_discount = 0;
        order_discount = 0;
        total_discount = 0;

        $("#smTable").empty();
        issued_members = JSON.parse(localStorage.getItem('issued_members'));
            var item = issued_members;
            var item_id = item.id;
            var row_no = item.id;

            issued_members = item;

            var member_id = item.row.member_id, 
                name = item.row.pname, 
                type = item.row.borrowertype, 
                classs = item.row.name, 
                member_unique_id = item.row.member_unique_id,
                section = item.row.section,
                image = item.row.image

            $.getJSON(baseUrl+"panel/borrow/suggestions_members?term="+member_unique_id, function(result){
                localStorage.setItem('issued', JSON.stringify(result));
                loadItems();
            });

            var imageTr = $('<div class="col-xs-12 col-sm-4 text-center"><figure id="image"></figure></div>');
            var imageurl = '<img src="'+baseUrl+'assets/uploads/members/'+image+'" alt="" class="img-circle img-responsive">'
            var tr_html = '';
            var newTr = $('<div class="col-xs-12 col-sm-8" id="info"></div>');
            
            // tr_html += '<div class="text-center pull-right"><img src="<?= base_url(); ?>assets/uploads/members/'+image+'" /></div>';
            // tr_html += '<dt class="">Member ID</dt>';
            // tr_html += '<dd class="">'+member_id+'</dd>';
            tr_html += '<h2>'+ name +'</h2>';
            tr_html += '<p><strong>Member: </strong> ' + type + '</p>';
            tr_html += '<p><strong>Class/Position: </strong> ' + classs + ' ' + section + '</p>';
            if (section != '') {
            tr_html += '<p><strong>Section: </strong> ' + section + '</p>';
            }
            tr_html += '<p><strong>Card ID </strong> '+member_unique_id+'</p>'
            // tr_html += '<div style="width: 70px; position: absolute;top: 0px;right: 0px;" class="text-center btn btn-danger"><i class="fa fa-times tip pointer smdel" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></div>';
            imageTr.html(imageurl);
            imageTr.prependTo("#smTable");

            newTr.html(tr_html);
            newTr.prependTo("#smTable");

       
    }
}

function add_member_item(item) {
    issued_members = {};

    
    if (item == null)
        return;

    var item_id = item.id;
    
    issued_members = item;
    
    issued_members.order = new Date().getTime();
    localStorage.setItem('issued_members', JSON.stringify(issued_members));

    loadmember();
    return true;
}


$(function() {
 
    $("#add_member").autocomplete({
        source: baseUrl+"panel/auth/suggestions",
        minLength: 1,
        autoFocus: false,
        delay: 200,
        response: function (event, ui) {
            if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                //audio_error.play();

                alert("not found");
                $(this).removeClass('ui-autocomplete-loading');
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            }
            else if (ui.content.length == 1 && ui.content[0].id != 0) {
                ui.item = ui.content[0];
                $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                $(this).autocomplete('close');
                $(this).removeClass('ui-autocomplete-loading');
            }
            else if (ui.content.length == 1 && ui.content[0].id == 0) {
                //audio_error.play();
                // alert(ui.content[0].row.isbn);
                alert("not found 2");
                
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            }
        },
        select: function(event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    var row = add_member_item(ui.item);
                    localStorage.setItem('member_id', ui.item.row.member_unique_id);
                    if (row)
                        $(this).val('');
                } else {
                    //audio_error.play();
                    alert("mummy");
                }

        },
 
        // html: true, // optional (jquery.ui.autocomplete.html.js required)
 
      // optional (if other layers overlap autocomplete list)
        open: function(event, ui) {
            $(".ui-autocomplete").css("z-index", 1000);
        }
    });
 
});

$(document).ready(function () {

if (localStorage.getItem('issued')) {
    loadItems();
}
});
function loadItems() {

    if (localStorage.getItem('issued')) {
        total = 0;
        count = 1;
        an = 1;
        product_tax = 0;
        invoice_tax = 0;
        product_discount = 0;
        order_discount = 0;
        total_discount = 0;

        $("#slTable tbody").empty();
        issued = JSON.parse(localStorage.getItem('issued'));
        $.each(issued, function () {
            var item = this;
            var item_id = item.id;
            var row_no = item.id;

            issued[item_id] = item;

            var product_id = item.row.id, 
                item_type = item.row.title, 
                item_price = item.row.price, 
                item_code = item.row.isbn,
                item_tid = item.row.borrowdetails_tid,
                item_copies = 1
                
            var tr_html = '';
            var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');
            tr_html += '<td class="text-center">'+product_id+'</td>';
            tr_html += '<td class="text-center">'+item_type+'</td>';
            tr_html += '<td class="text-center">'+item_price+'</td>';
            tr_html += '<td class="text-center">'+item_code+'</td>';
            tr_html += '<td class="text-center"><a href="'+baseUrl+'panel/borrow/returnbook/'+item_tid+'" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary"><i class="fa fa-bars"></i></td>';
            newTr.html(tr_html);
            newTr.prependTo("#slTable");
        });
    }
}

// issued = {};

if (typeof (Storage) === "undefined") {
    $(window).bind('beforeunload', function (e) {
        if (count > 1) {
            var message = "You will loss data!";
            return message;
        }
    });
}
