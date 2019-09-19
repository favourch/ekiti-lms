<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-envelope"></i><?= lang('email_heading'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                    <div class="col-md-12 col-sm-12">
                        <div>
                          <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#request" aria-controls="request" role="tab" data-toggle="tab"><?= lang('email_template_title'); ?></a></li>
                            <li role="presentation"><a href="#request_sms" aria-controls="request_sms" role="tab" data-toggle="tab"><?= lang('sms_template_title'); ?></a></li>
                          </ul>

                          <!-- Tab panes -->
                          <div class="tab-content">
                            <br>
                            <div role="tabpanel" class="tab-pane active" id="request">
                                <?= form_open('panel/requested_books/email_templates/request'); ?>
                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($request)), 'class="form-control" id="email_template"'); ?>
                                <input type="submit" name="email_submit" class="btn btn-primary" value="<?= lang('settings_save'); ?>"
                                       style="margin-top:15px;"/>
                                <?php echo form_close(); ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="request_sms">
                            <br>
                                 <?= form_open('panel/requested_books/email_templates/request_sms'); ?>
                                <?php echo form_textarea('mail_body', (isset($_POST['mail_body']) ? html_entity_decode($_POST['mail_body']) : html_entity_decode($request_sms)), 'class="form-control" id="sms_template"'); ?>
                                <input type="submit" name="sms_submit" class="btn btn-primary" value="<?= lang('settings_save'); ?>"
                                       style="margin-top:15px;"/>
                                <?php echo form_close(); ?>
                            </div>
                          </div>
                        </div>

                        
                    
                    </div>
                    <div class="col-md-12 col-sm-12">
                            <h3 style="font-weight: bold;"><?= $this->lang->line('short_tags'); ?></h3>
                            <pre>{logo} {site_name} {book_name} {contact_person} {status}</pre>
                    </div>


            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $("#email_template").wysihtml5({
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": false, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": false, //Button to insert an image. Default true,
            "color": false //Button to change color of font  
    });
</script>
