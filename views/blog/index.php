
<?php foreach ($posts as $post) : ?>
	<div class="jumbotron">
		<div class="header clearfix">
			<div class="pull-left"
				<h5><?= $post->title; ?></h5>
			</div>
			<div class="pull-right margin-right">

				<a href="/blog/comments/<?= get_slug($post) ?>">
					<span class="glyphicon glyphicon-comment">&nbsp;<span>
					<div class="comment-count"><?= $post->comment_count; ?></div>
				</a>

				<a href="/blog/like/<?= get_slug($post) ?>">
					<span class="glyphicon glyphicon-thumbs-up">&nbsp;<span>
				</a>
			</div>
		</div>
		<p><?= $post->body; ?></p>
	</div>
<?php endforeach; ?>