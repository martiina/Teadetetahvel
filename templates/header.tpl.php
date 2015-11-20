<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<title><?php echo $this->title; ?></title>
		<!-- These are static CSS files. -->
		<link href="/assets/css/bootstrap-editable/bootstrap-editable.css" rel="stylesheet">
		<link href='/assets/css/dataTables.css' rel='stylesheet' type='text/css'>
		<link href='/assets/css/images.css' rel='stylesheet' type='text/css' />
		<link href="/assets/css/style.css" rel="stylesheet" type="text/css" />
		<link href='/assets/css/bootstrap-datetimepicker.min.css' rel='stylesheet' type='text/css'>
		<link href="/assets/css/custom.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/iCheck/skins/all.css" rel="stylesheet" type="text/css" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
		<!-- End of static CSS files. -->
		<?php foreach ($this->css as $css): ?>
			<link href="<?php echo $css; ?>" rel="stylesheet" type="text/css" />
		<?php endforeach; ?>
		<!-- These are static JS files. -->
		<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
		<!-- End of static JS files. -->
	</head>
	<body class="bgleaves">
		<div class="loader"></div>
		<header class="clearfix">
			<?php if($this->logged): ?>
			<nav class="navbar navbar-fixed-top navbar-default" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="fa fa-cog"></span>
						</button>
						<a class="navbar-brand" href="<?php echo Config::get('misc/base-url'); ?>"><?php echo $this->eprint(Config::get('misc/base-name')); ?></a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							<?php
							if($this->logged) {
								include_once $this->template('templates/content/navigation/nav_logged.tpl.php');
							}
							?>
						</ul>
					</div>
				</div>
			</nav>
			<?php endif; ?>
		</header>