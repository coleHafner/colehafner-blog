<html>
	<head>
		<title><?= !empty($title) ? $title . ' - ' : ''; ?>colehafner.com</title>
		<link href="/css/base.css" rel="stylesheet" type="text/css" />
	</head>

	<body>

		<nav>
			<ul>
				<li>
					<a href="/" class="logo">
						<img src="/images/logo.png" />
					</a>
				</li>
				<li><a href="/">Home</a></li>
				<li><a href="/about">About</a></li>
				<li><a href="/blog">Blog</a></li>
			</ul>

			<a class="login" href="/login">Login</a>
		</nav>

		<section class="content">

			<h1><?= @$title ?></h1>

			<div class="wrapper">
				<?php
				$viewer = View::instance();
				echo $viewer->raw($viewer->render('layouts/notifications.php'));
				echo $viewer->raw($viewer->render($content_view));
				?>
			</div>
		</section>
	</body>
</html>