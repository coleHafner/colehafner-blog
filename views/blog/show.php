<?php if ($session->isLoggedIn()) : ?>
	<div class="corner-btn clearfix">
		<a href="#"
		   onclick="ask('/posts/delete/<?= $post->id ?>')"
		   class="btn btn-default pull-right margin-left">
			Delete
		</a>
		<a href="/posts/<?= $post->id ?>" class="btn btn-default pull-right">Edit</a>
	</div>
<?php endif; ?>

<div class="row">
	<div class="col-lg-8">
		<?= $post->body; ?>
	</div>
</div>