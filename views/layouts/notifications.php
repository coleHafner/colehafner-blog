<?php if (!empty($errors)) : ?>
	<div class="error">
		<?php
		foreach ($errors as $error) :
			echo $error . "</br>";
		endforeach;
		?>
	</div>
<?php
endif;

if (!empty($messages)) : ?>
	<div class="message">
		<?php
		foreach ($messages as $message) :
			echo $message . "</br>";
		endforeach;
		?>
	</div>
<?php
endif;

