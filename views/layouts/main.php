<!DOCTYPE html>

<html>
	<head>
		<title><?= !empty($title) ? $title . ' - ' : ''; ?>colehafner.com</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
		<link href="/vendor/cleditor/jquery.cleditor.css" rel="stylesheet">
		<link href="/css/base.css" rel="stylesheet" />

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="/vendor/cleditor/jquery.cleditor.js"></script>

		<script type="text/javascript">

			function ask(goTo) {
				if(confirm('Are you sure?')) {
					window.location.href = goTo;
				}

				return false;
			}

			$(function() {

				var resizeNav = function() {
					$('#mobile-nav a').height(($(window).height() - 50)/2);
					$('#desktop-nav').height($(window).height());
				};

				$('#nav-trigger').on('click', function(e) {
					resizeNav();
					$('#mobile-nav').toggle();
				});

				$(window).on('resize', function(e) {
					resizeNav();
				});

				resizeNav();
			});


		</script>

	</head>

	<body>
		<div class="container-fluid">

			<div class="row hidden-md hidden-lg" id="mobile-nav-bar">
				<div class="col-md-4 col-sm-4 col-xs-4 clearfix">
					<div class="float-right">
						<img src="/images/logo-mobile.png" />
					</div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-4 mobile-title">
					<?php if ($title !== null) : ?>
						<h3><?= @$title ?></h3>
					<?php endif; ?>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-4 clearfix">
					<div class="trigger btn btn-default btn-small" id="nav-trigger">
						<span class="glyphicon glyphicon-align-justify"></span>
					</div>
				</div>
			</div>

			<div class="row hidden-md hidden-lg" id="mobile-nav">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<a href="/">Home</a></li>
						</div>

						<div class="col-md-6 col-sm-6 col-xs-6">
							<a href="/about">About</a></li>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<a href="/portfolio">My Work</a></li>
						</div>

						<div class="col-md-6 col-sm-6 col-xs-6">
							<a href="/blog">Blog</a></li>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-3 col-md-3 hidden-sm hidden-xs" id="desktop-nav">
					<ul>
						<li>
							<a href="/" class="logo">
								<img src="/images/logo.png" />
							</a>
						</li>
						<li><a href="/">Home</a></li>
						<li><a href="/about">About</a></li>
						<li><a href="/portfolio">My Work</a></li>
						<li><a href="/blog">Blog</a></li>

						<?php if ($sh->isLoggedIn()) : ?>
							<li><a href="/posts">Posts</a></li>
							<li><a href="/comments">Comments</a></li>
						<?php endif; ?>

					</ul>

					<!--
					<?php if ($sh->isLoggedIn()) : ?>
						<a class="login" href="/do-logout">Logout</a>
					<?php else : ?>
						<a class="login" href="/login">Login</a>
					<?php endif; ?>
					-->

				</div>
				<div class="col-lg-9 col-md-9 col-sm-12">

					<?php if ($title !== null) : ?>
						<h1 class="hidden-sm hidden-xs"><?= @$title ?></h1>
					<?php
					endif;

					$viewer = View::instance();
					echo $viewer->raw($viewer->render('layouts/notifications.php'));
					echo $viewer->raw($viewer->render($content_view));
					?>
				</div>
			</div>
	</body>
</html>