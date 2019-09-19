
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Database Versions</h3>
	</div>
	<div class="box-body">
		<?php /* Backup button */ ?>
		<p>
			<a href="<?= base_url(); ?>panel/settings/backup_db" class="btn btn-primary">Backup Current Database</a>
		</p>

		<?php /* List out stored versions */ ?>
		<table class="table table-striped table-hover table-bordered">
			<tbody>
				<tr>
					<th>Version</th>
					<th>File Path</th>
					<th>Action</th>
				</tr>
				<?php if($backup_sql_files) { ?>
				<?php foreach ($backup_sql_files as $file): ?>
				<tr>
					<td>
						<?php
							$datetime = explode('_', str_replace('.sql', '', $file));
							echo '<b>'.$datetime[0].'</b> '.str_replace('-', ':', $datetime[1]);
						?>
					</td>
					<td><?php echo FCPATH.'sql/backup/'.$file; ?></td>
					<td>
						<a href="<?= base_url();?>panel/settings/restore_db/<?php echo $file; ?>" class="btn btn-primary">Restore</a>
						<a href="<?= base_url();?>panel/settings/remove_db/<?php echo $file; ?>" class="btn btn-danger">Delete</a>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php }else{ ?>
					<tr><td colspan=3 class="text-center">No Backup till Now</td></tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>