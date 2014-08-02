<script type="text/javascript">
	$(function() {
		$('#post-body').cleditor({
			controls:
				"bold italic underline strikethrough | alignleft center alignright justify | undo redo | "
		});
	});
</script>

<form method="post" action="/posts/save" role="form">
	<div class="row">
		<div class="col-lg-8">
			<div class="pad-bottom form-group">
				<label for="post-title">Title</label>
				<input id="post-title" type="text" name="title"
					class="form-control"
					value="<?= $record ? $record->title : ''; ?>" />
			</div>

			<div class="pad-bottom form-group">
				<label for="post-body">Content</label>

				<textarea id="post-body"
					class="form-control"
					name="body"><?= $record ? $record->body : ''; ?></textarea>
			</div>

			<input type="hidden" name="id" value="<?= $record ? $record->id : ''; ?>" />
		</div>
	</div>

	<input type="submit" value="Save" class="btn btn-default" /> <a href="/posts" class="btn btn-default">Cancel</a>
</form>
