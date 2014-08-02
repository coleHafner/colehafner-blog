
<a href="/posts/add" class="btn btn-default corner-btn">
	<span class="glyphicon glyphicon-plus"></span>
</a>

<table class="table table-striped">
	<tr>
		<th style="max-width:30px;">Id</th>
		<th style="max-width:140px;">Title</th>
		<th>Body</th>
		<th style="max-width:100px;">Created</th>
		<th style="max-width:40px;">Active</th>
		<th style="width:170px;">&nbsp;</th>
	</tr>

	<?php if (empty($records)) : ?>
		<tr>
			<td colspan="7">
				<p class="notification">There are 0 records. <a href="/posts/add/">Add One</a></p>
			</td>
		</tr>
	<?php endif; ?>

	<?php foreach ($records as $post) : ?>
		<tr>
			<td><?= $post->id; ?></td>
			<td><?= $post->title; ?></td>
			<td>
				<?php
				$viewer = View::instance();
				$f3->set('text', $post->body);
				echo $viewer->esc($viewer->render('layouts/responsive-text.php'));
				?>
			</td>
			<td><?= date('m/d/y', $post->created); ?></td>
			<td><?= $post->archived ? 'No' : 'Yes'; ?></td>
			<td>
				<div class="btn-group btn-group-small">
					<a class="btn btn-default" href="/posts/<?= $post->id ?>">
						<span class="glyphicon glyphicon-pencil">&nbsp;</span>
					</a>

					<a class="btn btn-default"
					   href="#"
					   onclick="ask('/posts/delete/<?= $post->id ?>');">
						<span class="glyphicon glyphicon-trash">&nbsp;</span>
					</a>

					<a class="btn btn-default"
					   href="/blog/<?= get_slug($post) ?>">
						<span class="glyphicon glyphicon-eye-open">&nbsp;</span>
					</a>

					<a class="btn btn-default"
					   href="/comments/post/<?= $post->id ?>">
						<span class="glyphicon glyphicon-comment">&nbsp;</span>
					</a>
				</div>

			</td>
		</tr>
	<?php endforeach; ?>
</table>