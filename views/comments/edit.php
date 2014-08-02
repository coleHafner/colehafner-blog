<form method="post" action="/comments/save" role="form">
	<div class="row">
		<div class="col-lg-8">
			<div class="pad-bottom form-group">
				<label for="comment-author">Author</label>
				<input id="comment-author" type="text" name="author"
					class="form-control"
					value="<?= $record ? $record->author : ''; ?>" />
			</div>

			<div class="pad-bottom form-group">
				<label for="comment-body">Content</label>
				<textarea id="comment-body"
					class="form-control"
					name="body"><?= $record ? $record->body : ''; ?></textarea>
			</div>

			<div class="pad-bottom form-group">
				<label for="comment-post">Post</label>

				<select name="post_id" class="form-control">
					<?php foreach ($posts as $post) : ?>
						<option value="<?= $post->id ?>"
							<?= $post->id == $record->post_id ? 'selected' : ''; ?>>
							<?= $post->title; ?>
						</option>
					<?php endforeach; ?>
				</select>

			</div>

			<input type="hidden" name="id" value="<?= $record ? $record->id : ''; ?>" />
		</div>
	</div>

	<input type="submit" value="Save" class="btn btn-default" /> <a href="/comments" class="btn btn-default">Cancel</a>
</form>
