<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<title><?php echo $this->title;  ?></title>
		<!-- These are static CSS files. -->
		<link href='/assets/css/images.css' rel='stylesheet' type='text/css' />
		<link href="/assets/css/style.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/custom.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/dashboard.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/desktop.css" rel="stylesheet" type="text/css" />
		<link href="/assets/css/iCheck/skins/all.css" rel="stylesheet" type="text/css" />
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
		<!-- End of static CSS files. -->
		<script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.min.js"></script>
	</head>
<body>
	<div class="loader"></div>
	<div class="loader-2" style="display:none;"></div>
	<div id="cl-wrapper" class="fixed-menu sb-collapsed">
		<div class="cl-sidebar">
			<div class="cl-toggle"><i class="fa fa-bars"></i></div>
			<div class="cl-navblock">
				<div class="menu-space">
					<div class="content">
						<ul class="cl-vnavigation">
							<?php if($this->logged) : ?>
								<li><a href="#" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus" style="color:lightseagreen;"></i> <span>Lisa teade</span></a></li>
								<?php if(checkPermissions('administrator')): ?>
								<li class="parent"><a href="#"><i class="fa fa-magic" style="color:orange;"></i> <span>Administreerimine</span></a>
									<ul class="sub-menu">
										<li class="dropdown-header">Teated</li>
										<li<?php echo activeMenu('/dashboard/notifications/user'); ?>><a href="/dashboard/notifications/user"><i class="glyphicon glyphicon-list-alt"></i> Kõik teated</a></li>
										<li class="dropdown-header">Kasutajad</li>
										<li<?php echo activeMenu('/dashboard/users'); ?>><a href="/dashboard/users"><i class="fa fa-group"></i> Kõik kasutajad</a></li>
										<li<?php echo activeMenu('/dashboard/adduser'); ?>><a href="/dashboard/adduser"><i class="fa fa-plus"></i> Lisa kasutaja</a></li>
									</ul>
								</li>
								<?php endif; ?>
								<li <?php echo activeMenu('/dashboard/settings'); ?>><a href="/dashboard/settings"><i class="fa fa-cog" style="color:aquamarine;"></i> <span>Seaded</span></a></li>
								<li <?php echo activeMenu('/desktop/logout'); ?>><a href="/desktop/logout"><i class="fa fa-sign-out" style="color:crimson;"></i> <span>Logi välja</span></a></li>
							<?php else : ?>
								<li <?php echo activeMenu('/desktop/'); ?>><a href="/desktop/"><i class="fa fa-home"></i> <span>Töölaud</span></a></li>
								<li <?php echo activeMenu('/desktop/login'); ?>><a href="/desktop/login/"><i class="fa fa-sign-in"></i> <span>Logi sisse</span></a></li>
							<?php endif; ?>	
						</ul>
					</div>
				</div>
				<!--<div class="text-right collapse-button" style="padding:7px 9px;">
					<button id="sidebar-collapse" class="btn btn-default" style=""><i style="color:#fff;" class="fa fa-angle-left"></i></button>
				</div>-->
			</div>
		</div>
		<?php include_once $this->content; ?>
	</div>
	<div class="modal fade" id="changeModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="/ajax/change_news.php" method="post">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Teate muutmine</h4>
					</div>
					<div class="modal-body">Laen andmeid...</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Sulge</button>
						<button type="submit" value="submit" name="submit" class="btn btn-success">Salvesta</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="addModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="/dashboard/add/" method="post">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Lisa uus teade</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label" for="grupp">Grupp</label><small class="text-info pull-right">Hoia all CTRL, et valida mitu gruppi.</small>
								<?php if($this->listgroup): ?>
									<select name="grupp[]" class="form-control" multiple="" style="height: 150px;">
										<?php foreach($this->listgroup as $group): ?>
											<option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
										<?php endforeach; ?>
									</select>
								<?php else: ?>
									<h4 class="page-header text-danger">Grupid puuduvad! <small>Palun lisa ennem grupid, kui soovid grupile lisada teateid!</small></h4>
								<?php endif; ?>
						</div>
						<div class="form-group">
							<label class="control-label" for="ppl">Personaalselt</label><small class="text-info pull-right">Hoia all CTRL, et valida mitu inimest.</small>
								<?php if($this->listusers): ?>
									<select name="ppl[]" class="form-control" multiple="" style="height: 150px;">
										<?php foreach($this->listusers as $user): ?>
											<option value="<?php echo $user->id; ?>"><?php echo $user->firstname.' '.$user->lastname; ?></option>
										<?php endforeach; ?>
									</select>
								<?php else: ?>
									<h4 class="page-header text-danger">Kasutajad puuduvad! <small>Palun lisa ennem kasutajaid, kui soovid lisada teateid!</small></h4>
								<?php endif; ?>
						</div>
						<div class="form-group">
							<label class="control-label" for="time">Tähtaeg</label><small class="text-info pull-right">Kui soovid ilma tähtajata, jäta väli tühjaks!</small>
							<div class="input-group date datetime">
								<span class="input-group-addon btn btn-primary">
									<span class="fa fa-calendar" style="color:white;"></span>
								</span>
								<input class="form-control" type="text" name="time" id="time" value="<?php echo Input::get('time'); ?>" size="16" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label" for="teade">Teade</label>
							<textarea class="form-control" name="teade" id="teade" placeholder="Sisesta teade siia"><?php echo Input::get('teade'); ?></textarea>
						</div>
						<input type="text" class="hidden" value="" name="spam" />
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Sulge</button>
						<button type="submit" value="submit" name="submit" class="btn btn-success">Lisa</button>
						<input name="vx_session" type="hidden" value="<?php echo $this->token; ?>" />
					</div>
				</form>
			</div>
		</div>
	</div>
	<script>
	$(document).ready(function() {	
		$('.edit_news').click(function() { 
			var src = $(this).attr('data-src');
			var nid = $(this).attr('id');
			$.ajax({
				beforeSend: function() {
					$('.loader-2').show();
				},
				method: 'POST',
				data: {'fnwid' : nid},
				url: '/ajax/fetch.php',
				success: function(data) {
					$('.loader-2').hide();
					$('#changeModal .modal-body').load(src);
					$('#changeModal').modal('show');
				}
			});
			
		});
	});
	</script>