
<form method="post" action="/do-login" class="form-group login-form">

	<h3 class="margin-top-none">Login</h3>

	<div class="pad-bottom">
		<input class="form-control" type="text" name="username" placeholder="Username" value="<?= @$_GET['username']; ?>"/>
	</div>

	<div class="pad-bottom">
		<input class="form-control" type="password" name="password" placeholder="Password" />
	</div>

	<button type="submit" class="btn btn-default">
		Login
	</button>

	<a href="/" class="btn btn-default">
		Cancel
	</a>
</form>