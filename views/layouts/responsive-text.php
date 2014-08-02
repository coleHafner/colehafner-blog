<span class="hidden-sm hidden-xs">
	<?php
	$new_text = substr($text, 0, 110);
	$new_text = strlen($new_text) >= 110 ? $new_text . '...' : $new_text;
	echo htmlentities($new_text, ENT_QUOTES);
	//var_dump($low);die;
	?>
</span>

<span class="visible-sm">
	<?php
	$new_text = substr($text, 0, 50);
	$new_text = strlen($new_text) >= 50 ? $new_text . '...' : $new_text;
	echo htmlentities($new_text);
	?>
</span>

<span class="visible-xs">
	<?php
	$new_text = substr($text, 0, 10);
	$new_text = strlen($new_text) >= 10 ? $new_text . '...' : $new_text;
	echo htmlentities($new_text);
	?>
</span>