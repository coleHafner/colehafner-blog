<div class="pad-top">

	<?php if (!empty($errors)) : ?>
		<p class="bg-danger notification">
			<?= implode('<br/>', $errors); ?>
		</p>
	<?php
	endif;

	if (!empty($messages)) : ?>
		<p class="bg-success notification">
			<?= implode('<br/>', $messages); ?>
		</p>
	<?php endif; ?>
</div>