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
						<h2>Seaded</h2>
					</div>
					<div class="content">
						<form enctype="multipart/form-data" action="" method="post">
							<div class="form-group">
								<label for="current_pass">Kehtiv parool - (<small class="text-danger">Kohustuslik muudatuste tegemiseks!</small>)</label>
								<input type="password" class="form-control" id="current_pass" name="current_pass" placeholder="Sisesta oma praegune parool" />
							</div>
							<h4 class="page-header">Parooli vahetamine:</h4>
							<div class="form-group">
								<label for="password">Uus parool</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="Sisesta uus parool" />
							</div>
							<div class="form-group">
								<label for="new_pass">Korda uut parooli</label>
								<input type="password" class="form-control" id="new_pass" name="new_pass" placeholder="Korda uut parooli" />
							</div>
							<h4 class="page-header">Emaili vahetamine:</h4>
							<div class="form-group">
								<label for="email">Uus email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Sisesta uus email" value="<?php echo $this->userdata->email; ?>"/>
							</div>
							<h4 class="page-header">Avatari vahetamine:</h4>
							<div class="form-group">
								<?php 
									$getAvatar = getAvatar($this->userdata->id);
									$avatar = ($getAvatar && file_exists('assets/avatars/'.$getAvatar)) ?  '/assets/avatars/' . $getAvatar : '/assets/avatars/no-avatar.jpg'; 
								?>
								<label for="avatar"><div class="avatar"><img class="sb-avatar" style="border-radius: 0 !important;" src="<?php echo $avatar; ?>" alt="Avatar"></div></label>
								<input type="file" id="avatar" name="avatar" />
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