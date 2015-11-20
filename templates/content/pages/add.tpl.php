<div class="container-fluid" id="pcont">
	<div class="cl-mcont">
		<div class="row dash-cols">
			<div class="col-md-12 col-sm-12">
				<?php
					if(!empty($this->errors)) {
						echo inline_errors($this->errors, 12, 0, "", true);
					}
					echo getflash(true);
				?>
				<div class="block">
					<div class="header">
						<h2><i class="fa fa-pencil"></i> Lisa teade</h2>
					</div>
					<div class="content">
						<div class="alert alert-info alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<i class="fa fa-info-circle sign"></i> <strong>Info!</strong> Teate kõigile lisamiseks jätke <em>grupp</em> ja <em>personaalselt</em> väljad valimata.
						</div>
						<form action="" method="post">
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
										<select name="ppl[]" class="form-control" multiple="" style="height: 250px;">
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
							<button type="submit" class="btn btn-success"><i class="fa fa-pencil"></i> Lisa teade</button>
							<input name="vx_session" type="hidden" value="<?php echo Token::generate(); ?>" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
