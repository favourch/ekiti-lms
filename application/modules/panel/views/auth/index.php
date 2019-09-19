  <link rel="stylesheet" href="<?= base_url();?>assets/dist/css/print.css">

      <div class="row">

        <div class="col-xs-12">
        
          <div class="box">
            <div class="box-header">
            <h2 class="box-title"><?php echo lang('index_heading');?>
              <small><?php echo lang('index_subheading');?></small></h2>
            <p>
						<a href="<?= base_url(); ?>panel/auth/create_user/" type="button" class="btn btn-info"><?php echo lang('index_create_user_link') ?></a>




            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
					<th><?php echo lang('index_fname_th');?></th>
					<th><?php echo lang('index_lname_th');?></th>
					<th><?php echo lang('index_email_th');?></th>
					<th><?php echo lang('index_groups_th');?></th>
					<th><?php echo lang('index_status_th');?></th>
					<th><?php echo lang('index_action_th');?></th>
				</tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user):?>
				<tr>
		            <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
		            <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
		            <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
					<td>
						<?php foreach ($user->groups as $group):?>
							<?php echo anchor("panel/auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
		                <?php endforeach?>
					</td>
					<td>
          <?php if(($user->active)): ?>
            <?php if($this->ion_auth->user()->row()->id !== $user->id): ?>
            <a href="<?= base_url();?>panel/auth/deactivate/<?= $user->id ?>"><span class="label label-success"><i class="fa fa-check"></i> <?= lang('index_active_link')?></span></a>
            <?php else: ?>
              <span class="label label-success"><i class="fa fa-check"></i> <?= lang('index_active_link')?></span>
            <?php endif; ?>

          <?php else:?>
            <a href="<?= base_url();?>panel/auth/activate/<?= $user->id ?>"><span class="label label-danger"><i class="fa fa-check"></i> <?= lang('index_inactive_link')?></span></a>

          <?php endif; ?>


						<td>
						<a href="<?= base_url(); ?>panel/auth/edit_user/<?= $user->id; ?>" type="button" class="btn btn-info"><i class="fa fa-edit"></i></a>
            <?php if($this->ion_auth->user()->row()->id !== $user->id): ?>
              <a href="<?= base_url(); ?>panel/auth/delete_user/<?= $user->id; ?>" type="button" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
            <?php endif; ?>
						<a href="<?= base_url(); ?>panel/auth/view_card/<?= $user->id; ?>" data-toggle="modal" data-target="#myModal" type="button" class="btn btn-success"><i class="fa fa-credit-card"></i></a>
                      


							
						</td>
					</tr>
				<?php endforeach;?>
                </tbody>
                <tfoot>
               	<tr>
					<th><?php echo lang('index_fname_th');?></th>
					<th><?php echo lang('index_lname_th');?></th>
					<th><?php echo lang('index_email_th');?></th>
					<th><?php echo lang('index_groups_th');?></th>
					<th><?php echo lang('index_status_th');?></th>
					<th><?php echo lang('index_action_th');?></th>
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
    <!-- /.content -->
