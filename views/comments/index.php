<a href="/comments/add" class="btn btn-default corner-btn">
	<span class="glyphicon glyphicon-plus"></span>
</a>

<table class="table table-striped">
	<tr>
		<th style="max-width:30px;">Id</th>
		<th style="max-width:140px;">Author</th>
		<th>Body</th>
		<th style="max-width:100px;">Created</th>
		<th style="max-width:40px;">Active</th>
		<th style="width:130px;">&nbsp;</th>
	</tr>

	<?php if (empty($records)) : ?>
		<tr>
			<td colspan="7">
				<p class="notification">There are 0 records.
			</td>
		</tr>
	<?php endif; ?>

	<?php foreach ($records as $record) : ?>
		<tr>
			<td><?= $record->id; ?></td>
			<td><?= $record->author; ?></td>
			<td>
				<?php
				$f3->set('text', $record->body);
				$viewer = View::instance();
				echo $viewer->raw($viewer->render('layouts/responsive-text.php'));
				?>
			</td>
			<td><?= date('m/d/y', $record->created); ?></td>
			<td><?= $record->archived ? 'No' : 'Yes'; ?></td>
			<td>
				<div class="btn-group btn-group-small">
					<a class="btn btn-default" href="/comments/<?= $record->id ?>">
						<span class="glyphicon glyphicon-pencil">&nbsp;</span>
					</a>

					<a class="btn btn-default"
					   href="#"
					   onclick="ask('/comments/delete/<?= $record->id ?>');">
						<span class="glyphicon glyphicon-trash">&nbsp;</span>
					</a>

					<a class="btn btn-default"
					   href="/posts/<?= $record->post_id ?>">
						<span class="glyphicon glyphicon-chevron-up">&nbsp;</span>
					</a>
				</div>

			</td>
		</tr>
	<?php endforeach; ?>
</table>