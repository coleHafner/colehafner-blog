<table class="table">
	<tr>
		<th style="width:30px;">Id</th>
		<th style="width:140px;">Title</th>
		<th>Body</th>
		<th style="width:130px;">Updated</th>
		<th style="width:130px;">Created</th>
		<th style="width:40px;">Active</th>
		<th style="width:140px;">&nbsp;</th>
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
			<td><?php echo substr($post->body, 0, 110); echo strlen($post->body) >= 110 ? '...' : ''; ?></td>
			<td><?= date('m/d/y H:i', $post->updated); ?></td>
			<td><?= date('m/d/y H:i', $post->created); ?></td>
			<td><?= $post->archived ? 'No' : 'Yes'; ?></td>
			<td>
				<a class="btn btn-default" href="/posts/<?= $post->id ?>">Edit</a>
				<a class="btn btn-default"
				   href="#"
				   onclick="if(confirm('Are you sure?')) { window.location.href='/posts/delete/<?= $post->id ?>'; return false;}">
					Delete
				</a>
			</td>
		</tr>
	<?php endforeach; ?>
</table>