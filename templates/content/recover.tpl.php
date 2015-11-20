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
					<h2><i class="fa fa-user"></i> Parooli taastamine</h2>
				</div>
				<div class="content">
					<form action="" method="post">
						<div class="form-group">
							<label for="username">Email</label><a class="pull-right" href="/login/">Logi sisse</a>
							<input autocomplete="off" type="email" value="<?php echo Input::get('email'); ?>"  class="form-control" id="email" name="email" placeholder="Sisesta email" />
						</div>
						<button type="submit" class="btn btn-success btn-block"><i class="fa fa-sign-in"></i> Taasta</button>
						<input name="vx_session" type="hidden" value="<?php echo Token::generate(); ?>" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
