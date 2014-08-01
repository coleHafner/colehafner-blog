
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
		<th style="width:130px;">&nbsp;</th>
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
				<span class="hidden-sm hidden-xs">
					<?php echo substr($post->body, 0, 110); echo strlen($post->body) >= 110 ? '...' : ''; ?>
				</span>

				<span class="visible-sm">
					<?php echo substr($post->body, 0, 50); echo strlen($post->body) >= 50 ? '...' : ''; ?>
				</span>

				<span class="visible-xs">
					<?php echo substr($post->body, 0, 10); echo strlen($post->body) >= 10 ? '...' : ''; ?>
				</span>
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
					   href="/blog/<?= str_replace(' ', '-', $post->title) ?>/<?= $post->id ?>">
						<span class="glyphicon glyphicon-eye-open">&nbsp;</span>
					</a>
				</div>

			</td>
		</tr>
	<?php endforeach; ?>
</table>