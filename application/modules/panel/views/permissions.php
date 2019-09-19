<style>
    .table td:first-child {
        font-weight: bold;
    }

    label {
        margin-right: 10px;
    }
</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-folder-open"></i><?= lang('group_permissions'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang("set_permissions"); ?></p>

                <?php echo form_open("system_settings/permissions/"); ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">

                                <thead>
                                <tr>
                                    <th colspan="6"
                                        class="text-center"></th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="text-center"><?= lang("module_name"); ?>
                                    </th>
                                    <th colspan="5" class="text-center"><?= lang("permissions"); ?></th>
                                </tr>
                                <tr>
                                    <th class="text-center"><?= lang("view"); ?></th>
                                    <th class="text-center"><?= lang("add"); ?></th>
                                    <th class="text-center"><?= lang("edit"); ?></th>
                                    <th class="text-center"><?= lang("delete"); ?></th>
                                    <th class="text-center"><?= lang("misc"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= lang("books"); ?></td>
                                        <td class="text-center">
                                            <input type="checkbox" value="1" class="checkbox" name="products-index">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" value="1" class="checkbox" name="products-add" >
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" value="1" class="checkbox" name="products-edit">
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" value="1" class="checkbox" name="products-delete">
                                        </td>
                                        
                                        <td class="text-center">
                                            <input type="checkbox" value="1" class="checkbox" name="products-delete">
                                        </td>
                                        
                                      
                                    </tr>
                                
                                

                                </tbody>
                            </table>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><?=lang('update')?></button>
                        </div>
                        <?php echo form_close();
                   ?>


            </div>
        </div>
    </div>
</div>