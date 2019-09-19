
$(document).ready(function () {

    // clear localStorage and reload
    $('#reset').click(function (e) {
        if (localStorage.getItem('slitems')) {
            localStorage.removeItem('slitems');
        }
        if (localStorage.getItem('smitems')) {
            localStorage.removeItem('smitems');
        }
        

        //location.reload();
        window.location.href = baseUrl+"panel/borrow";
    });

if (localStorage.getItem('smitems')) {
    loadmember();
}
if (localStorage.getItem('slitems')) {
        loadItems();
    }
});
function loadmember() {

    if (localStorage.getItem('smitems')) {
        total = 0;
        count = 1;
        an = 1;
        product_tax = 0;
        invoice_tax = 0;
        product_discount = 0;
        order_discount = 0;
        total_discount = 0;

        $("#smTable").empty();
        smitems = JSON.parse(localStorage.getItem('smitems'));
            var item = smitems;
            var item_id = item.id;
            var row_no = item.id;

            smitems = item;

            var member_id = item.row.member_id, 
                name = item.row.pname, 
                type = item.row.borrowertype, 
                classs = item.row.name, 
                member_unique_id = item.row.member_unique_id,
                section = item.row.section,
                image = item.row.image

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
            if (issue_conf == 2) {

                var today = new Date();
                var newdate = new Date();
                newdate.setDate(today.getDate() + parseInt(item.row.issue_limit_day));
                $("#due_date").val($.datepicker.formatDate('yy-mm-dd', newdate));
            }
    }
}

function add_member_item(item) {
    smitems = {};
    if (item == null)
        return;
    var item_id = item.id;
    smitems = item;
    smitems.order = new Date().getTime();
    localStorage.setItem('smitems', JSON.stringify(smitems));
    loadmember();
    return true;
}


if (typeof (Storage) === "undefined") {
    $(window).bind('beforeunload', function (e) {
        if (count > 1) {
            var message = "You will loss data!";
            return message;
        }
    });
}
$(document).on('click', '#add_sale', function () {
    var x = document.forms["myForm"]["due_date"].value;
    if (x == null || x == "") {
        alert("Please Select Due Date");
        return false;
    }else if(localStorage.getItem("slitems") === null || localStorage.getItem("slitems") === "") {
        alert("Please Select Book(s)");
        return false;
    }else if( localStorage.getItem("smitems") === null || localStorage.getItem("smitems") === "") {
        alert("Please Select a Member");
        return false;
    }else{
        $('#items').val(localStorage.getItem('slitems'));
        $('#member').val(localStorage.getItem('smitems'));

        if (localStorage.getItem('slitems')) {
            localStorage.removeItem('slitems');
        }
        if (localStorage.getItem('smitems')) {
            localStorage.removeItem('smitems');
        }
        $('#pos-sale-form').submit();
       
    }
            
});
/* ----------------------
     * Delete Row Method
     * ---------------------- */
    $(document).on('click', '.smdel', function () {
        var row = $(this).closest('div');
        var item_id = row.attr('data-item-id');
        delete smitems[item_id];
        row.remove();
        if(smitems.hasOwnProperty(item_id)) { } else {
            localStorage.setItem('smitems', JSON.stringify(smitems));
            loadmember();
            return;
        }
    });
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

function loadItems() {
    if (localStorage.getItem('slitems')) {
        total = 0;
        count = 1;
        an = 1;
        product_tax = 0;
        invoice_tax = 0;
        product_discount = 0;
        order_discount = 0;
        total_discount = 0;

        $("#slTable tbody").empty();
        slitems = JSON.parse(localStorage.getItem('slitems'));
        $.each(slitems, function () {
            var item = this;
            var item_id = item.id;
            var row_no = item.id;
            slitems[item_id] = item;
            var product_id = item.row.id, 
                item_type = item.row.book_title, 
                item_price = item.row.price, 
                item_code = item.row.isbn,
                item_copies = item.row.available,
                item_qty = item.row.qty;
            var tr_html = '';
            var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');
            tr_html += '<td class="text-center">'+product_id+'</td>';
            tr_html += '<td class="text-center">'+item_type+'</td>';
            tr_html += '<td class="text-center">'+item_price+'</td>';
            tr_html += '<td class="text-center">'+item_code+'</td>';
            tr_html += '<td class="text-center">'+item_copies+'</td>';
            tr_html += '<td class="text-center">'+item_qty+'</td>';
            tr_html += '<td class="text-center"><i class="fa fa-times tip pointer sldel" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
            newTr.html(tr_html);
            newTr.prependTo("#slTable");
        });
    }
}

slitems = {};
function add_invoice_item(item) {
    var items = window.localStorage.getItem('smitems')
    if (!(items === null || items.length === 0 || item == null))
    {
        var item_id = item.id;
        if (slitems[item_id]) {
            slitems[item_id].row.qty = parseFloat(slitems[item_id].row.qty) + 1;
            slitems[item_id].available_now = parseFloat(slitems[item_id].available_now) - 1;
        } else {
            slitems[item_id] = item;
        }
        // slitems[item_id] = item;
        slitems[item_id].order = new Date().getTime();
        // slitems[item_id].available_now = parseInt(slitems[item_id].row.available) - 1;
        localStorage.setItem('slitems', JSON.stringify(slitems));
        loadItems();
        return true;
    }else{
        alert('Please select Member First.');
    }
    
}

if (typeof (Storage) === "undefined") {
    $(window).bind('beforeunload', function (e) {
        if (count > 1) {
            var message = "You will loss data!";
            return message;
        }
    });
}

    /* ----------------------
     * Delete Row Method
     * ---------------------- */
    $(document).on('click', '.sldel', function () {
        var row = $(this).closest('tr');
        var item_id = row.attr('data-item-id');
        delete slitems[item_id];
        row.remove();
        if(slitems.hasOwnProperty(item_id)) { } else {
            localStorage.setItem('slitems', JSON.stringify(slitems));
            loadItems();
            return;
        }
    });
$(function() {
 
    $("#add_item").autocomplete({
        source: baseUrl+"panel/borrow/suggestions",
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
                alert("not found 2");
                $(this).removeClass('ui-autocomplete-loading');
                $(this).val('');
            }
        },
        select: function(event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    if (ui.item.row.available > 0) {
                        if (localStorage.getItem('slitems')) {
                            var add = true;
                            slitems = JSON.parse(localStorage.getItem('slitems'));
                            item_id = ui.item.id;
                            if (slitems[item_id]) {
                                if (slitems[item_id].available_now != 0) {
                                    var row = add_invoice_item(ui.item);
                                    if (row)
                                        $(this).val('');
                                }else{
                                    alert(ui.item.label + "is not available in stock");
                                }
                            }else{
                                var row = add_invoice_item(ui.item);
                                if (row)
                                    $(this).val(''); 
                            }
                        }else{
                                var row = add_invoice_item(ui.item);
                                if (row)
                                    $(this).val(''); 
                            }
                    }else{
                        alert(ui.item.label + " is not available in Stock, you have 0 in stock");
                    }
                } else {
                    //audio_error.play();
                    alert("Error Occured. ");
                }

        },
 
        // html: true, // optional (jquery.ui.autocomplete.html.js required)
 
      // optional (if other layers overlap autocomplete list)
        open: function(event, ui) {
            $(".ui-autocomplete").css("z-index", 1000);
        }
    });
 
});