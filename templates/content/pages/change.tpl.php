<div class="container-fluid" id="pcont">
	<div class="cl-mcont">
		<div class="row dash-cols">
			<div class="col-sm-12 col-md-12">
				<?php
					if(!empty($this->errors)) {
						echo inline_errors($this->errors, 12, 0, "", true);
					}
					echo getflash(true);
				?>
				<div class="block">
					<div class="header">
						<h2>Muuda kasutajat <em><?php echo $this->profile_data->username; ?></em></h2>
					</div>
					<div class="content">
						<form action="" method="post">
							<?php if($this->userdata->id == $this->profile_data->id): ?>
								<div class="alert alert-success">
									<p>See on Sinu profiil. Enda seadeid saad muuta ka otse seadetes!</p>
								</div>
							<?php endif; ?>
							<h4 class="page-header">Üldine:</h4>
							<div class="form-group">
								<label for="username">Kasutajanimi</label>
								<input type="text" class="form-control" id="username" name="username" disabled="disabled" placeholder="Sisesta uus kasutajanimi" value="<?php echo $this->profile_data->username; ?>"/>
							</div>
							<div class="form-group">
								<label for="firstname">Eesnimi</label>
								<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Sisesta uus eesnimi" value="<?php echo $this->profile_data->eesnimi; ?>"/>
							</div>
							<div class="form-group">
								<label for="lastname">Perekonnanimi</label>
								<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Sisesta uus perekonnanimi" value="<?php echo $this->profile_data->perenimi; ?>"/>
							</div>
							<div class="form-group">
								<label for="grupp">Grupp</label>
								<select name="grupp" class="form-control" id="grupp">
									<?php foreach($this->listgroups as $gro): ?>
										<?php $selected = ($this->profile_data->group == $gro->id) ? 'selected="selected"' : ''; ?>
										<option value="<?php echo $gro->id; ?>" <?php echo $selected; ?>><?php echo $gro->name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<h4 class="page-header">Parooli vahetamine: <small>Pole kohustuslik, kui ei taha muuta parooli.</small></h4>
							<div class="form-group">
								<label for="password">Uus parool</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Sisesta uus parool" />
							</div>
							<div class="form-group">
								<label for="password2">Korda uut parooli</label>
								<input type="password" class="form-control" id="password2" name="password2" placeholder="Korda uut parooli" />
							</div>
							<h4 class="page-header">Emaili vahetamine:</h4>
							<div class="form-group">
								<label for="email">Uus email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Sisesta uus email" value="<?php echo $this->profile_data->email; ?>"/>
							</div>
							<input name="vx_session" type="hidden" value="<?php echo Token::generate(); ?>" />
							<button type="submit" class="btn btn-success"><i class="fa fa-cog"></i> Muuda seadeid</button>
						</form>
						<div class="clear"></div>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>