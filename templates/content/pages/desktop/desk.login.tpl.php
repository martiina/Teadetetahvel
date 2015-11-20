<?php
	if(!empty($this->errors)) {
		echo inline_errors($this->errors, 6, 3);
	}
	echo getflash(6, 3);
?>
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 desktop">
			<div class="block">
				<div class="header">
					<h2>Logi sisse</h2>
				</div>
				<div class="content">
					<form action="" method="post">
						<div class="form-group">
							<label for="username">Kasutajanimi</label>
							<input autocomplete="off" type="text" value="<?php echo Input::get('username'); ?>"  class="form-control" id="username" name="username" placeholder="Sisesta kasutajanimi" />
						</div>
						<div class="form-group">
							<label for="password">Parool</label>
							<input type="password" name="password" id="password" class="form-control" placeholder="Sisesta parool"  />
						</div>
						<div class="form-group">
							<label for="remember" class="checkbox">
								<input type="checkbox" id="remember" name="remember"/> Pea mind meeles
							</label>
						</div>
						<button type="submit" class="btn btn-success"><i class="fa fa-sign-in"></i> Logi sisse</button>
						<input name="vx_session" type="hidden" value="<?php echo $this->token; ?>" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
