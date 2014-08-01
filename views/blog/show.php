<?php if ($session->isLoggedIn()) : ?>
	<div class="btn-group corner-btn">

		<a href="/posts/<?= $post->id ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-pencil"></span>
		</a>

		<a href="#"
		   onclick="ask('/posts/delete/<?= $post->id ?>')"
		   class="btn btn-default">
			<span class="glyphicon glyphicon-trash"></span>
		</a>
	</div>
<?php endif; ?>

<div class="row">
	<div class="col-lg-8">
		<?= $post->body; ?>
	</div>
</div>