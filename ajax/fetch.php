<?php
	require_once '../core/init.php';
	
	if(!Input::get('fnwid')) {
		die('Error (404), Page not found.');
	} else {
		$fnwid = Input::get('fnwid');
	}
	
	$news = new News();
	
	$db = Database::getInstance();
	
	$query = $db->get('news', array('id', '=', $fnwid));
	
	if(!$query->count()) {
		die('Error (404), Page not found.');
	}
	
	$tpl->results = $query->first();
	$tpl->listgroup = $user->listItems('groups');
	$tpl->listusers = $user->listItems('users');
?>
<?php if(checkPermissions('administrator') || $user->data()->id === getNewsAuthor($fnwid)): ?>
	<link href='/assets/css/bootstrap-datetimepicker.min.css' rel='stylesheet' type='text/css'>
	<script>
		/*DateTime Picker*/
			$(".datetime-2").datetimepicker({
				icons: {
					time: "fa fa-clock-o",
					date: "fa fa-calendar",
					up: "fa fa-arrow-up",
					down: "fa fa-arrow-down"
				},
				useSeconds: false,
				sideBySide: true,
				language: 'et',
				use24hours: true
			});
	</script>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label pull-center" for="grupp">Grupp</label><small class="text-info pull-right"></br>Hoia all CTRL, et valida mitu gruppi.</small>
						<?php if($tpl->listgroup): ?>
							<select name="grupp[]" class="form-control" multiple="" style="height: 150px;">
								<?php foreach($tpl->listgroup as $group): ?>
									<?php
										$explode_group = explode('|', $tpl->results->groupid);
										if(in_array($group->id,$explode_group)):												
									?>
										<option value="<?php echo $group->id; ?>" selected><?php echo $group->name; ?></option>
									<?php else: ?>
										<option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
									<?php endif; ?>
								<?php endforeach; ?>
							</select>
						<?php else: ?>
							<h4 class="page-header text-danger">Grupid puuduvad! <small>Palun lisa ennem grupid, kui soovid lisada teateid!</small></h4>
						<?php endif; ?>
				</div>
			</div>	
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label" for="ppl">Personaalselt</label><small class="text-info pull-right"></br>Hoia all CTRL, et valida mitu inimest.</small>
						<?php if($tpl->listusers): ?>
							<select name="ppl[]" class="form-control" multiple="" style="height: 250px;">
								<?php foreach($tpl->listusers as $user): ?>
									<?php
										$explode_person = explode('|', $tpl->results->userid);
										if(in_array($user->id,$explode_person)):
									?>
										<option value="<?php echo $user->id; ?>" selected><?php echo $user->firstname.' '.$user->lastname; ?></option>
									<?php else: ?>
										<option value="<?php echo $user->id; ?>"><?php echo $user->firstname.' '.$user->lastname; ?></option>
									<?php endif; ?>	
								<?php endforeach; ?>
							</select>
						<?php else: ?>
							<h4 class="page-header text-danger">Kasutajad puuduvad! <small>Palun lisa ennem kasutajaid, kui soovid lisada teateid!</small></h4>
						<?php endif; ?>
				</div>
			</div>	
		</div>
	</div>
	<div class="form-group">
		<label class="control-label" for="time">Tähtaeg</label><small class="text-info pull-right">Kui soovid ilma tähtajata, jäta väli tühjaks!</small>
		<div class="input-group date datetime-2">
			<span class="input-group-addon btn btn-primary">
				<span class="fa fa-calendar" style="color:white;"></span>
			</span>
			<input class="form-control" type="text" name="time" id="time" value="<?php if($tpl->results->deadline): echo date('d.m.Y G:i', $tpl->results->deadline); endif;?>" size="16" />
		</div>
	</div>
	<div class="form-group">
		<label class="control-label" for="teade">Teade</label>
		<textarea class="form-control" name="teade" id="teade" placeholder="Sisesta teade siia"><?php echo str_replace('<br />', '', $tpl->results->content); ?></textarea>
	</div>
	<div class="form-group">
		<label class="control-label" for="complete">Sooritatud</label>
		<select class="form-control" name="complete" id="complete">
			<option value="0" <?php if($tpl->results->completed == 0) : echo "selected"; endif; ?>>Ei</option>
			<option value="1" <?php if($tpl->results->completed == 1) : echo "selected"; endif; ?>>Jah</option>
			<?php if(checkPermissions('administrator')): ?>
				<option value="2" <?php if($tpl->results->completed == 2) : echo "selected"; endif; ?>>Jah + Kinnitan</option>
			<?php endif; ?>	
		</select>
	</div>
<?php else: ?>
	<div class="form-group">
		<label class="control-label" for="complete">Sooritatud</label>
		<select class="form-control" name="complete" id="complete">
			<option value="0" <?php if($tpl->results->completed == 0) : echo "selected"; endif; ?>>Ei</option>
			<option value="1" <?php if($tpl->results->completed == 1 || (!checkPermissions('administrator') && $tpl->results->completed == 2)) : echo "selected"; endif; ?>>Jah</option>
		</select>
	</div>
<?php endif; ?>
<input type="text" class="hidden" value="" name="spam" />
<input name="vx_session" type="hidden" value="<?php echo Token::generate(); ?>" />
<input name="news_id" type="hidden" value="<?php echo $fnwid; ?>" />