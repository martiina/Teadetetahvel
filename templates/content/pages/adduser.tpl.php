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
						<h2><i class="fa fa-plus"></i> Lisa kasutaja</h2>
					</div>
					<div class="content">
						<form action="" method="post" autocomplete="off">
							<div class="form-group">
								<label class="control-label" for="username">Kasutajanimi</label>
								<input type="text" value="<?php echo Input::get('username'); ?>"  class="form-control" id="username" name="username" placeholder="Sisesta kasutajanimi" />
							</div>
							<div class="form-group">
								<label for="password">Parool</label>
								<input type="password" name="password" id="password" class="form-control" placeholder="Sisesta oma parool"  />
							</div>
							<div class="form-group">
								<label for="password2">Korda parooli</label>
								<input type="password" name="password2" id="password2" class="form-control" placeholder="Korda oma parooli"  />
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" name="email" value="<?php echo Input::get('email'); ?>" id="email" class="form-control" placeholder="Sisesta oma email"  />
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-sm-6">
										<label for="firstname">Eesnimi</label>
										<input type="text" name="firstname" value="<?php echo Input::get('firstname'); ?>" id="firstname" class="form-control" placeholder="Sisesta oma eesnimi"  />
									</div>
									<div class="col-sm-6">
										<label for="lastname">Perekonnanimi</label>
										<input type="text" name="lastname" value="<?php echo Input::get('lastname'); ?>" id="lastname" class="form-control" placeholder="Sisesta oma perekonnanimi"  />
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="grupp">Grupp</label>
								<select name="grupp" class="form-control" id="grupp">
									<!--<option value="0" disabled="" selected="selected">Vali grupp</option>-->
									<?php foreach($this->listgroup as $grupp): ?>
										<option value="<?php echo $grupp->id; ?>"><?php echo $grupp->name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Lisa kasutaja</button>
							<input name="vx_session" type="hidden" value="<?php echo Token::generate(); ?>" />
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
