<?php
	if(!empty($this->errors)) {
		echo inline_errors($this->errors, 6, 3);
	}
	echo getflash(false, 6, 3);
?>
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="block index-block">
				<div class="header">
					<h2><i class="fa fa-user"></i> Parooli muutmine</h2>
				</div>
				<div class="content">
					<form action="" method="post">
						<div class="form-group">
							<label for="password">Uus parool</label>
							<input autocomplete="off" type="password" class="form-control" id="password" name="password" placeholder="Sisesta parool" />
						</div>
						<div class="form-group">
							<label for="password2">Korda parooli</label>
							<input autocomplete="off" type="password" class="form-control" id="password2" name="password2" placeholder="Korda parooli" />
						</div>
						<button type="submit" class="btn btn-success btn-block"><i class="fa fa-sign-in"></i> Taasta</button>
						<input name="vx_session" type="hidden" value="<?php echo Token::generate(); ?>" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
