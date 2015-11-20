<?php if(!$this->dashboard): ?>
<div class="container">
	<div class="row">
		<div class="col-md-<?php echo $this->columns; ?> col-md-offset-<?php echo $this->offset; ?>">
			<div class="alert alert-danger alert-white fade in">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<div class="icon">
					<i class="fa fa-times-circle"></i>
				</div>
				<h4 class="alert-heading"><?php echo $this->error_title; ?></h4>
				<ul>
					<?php foreach($this->inline_error as $errors): ?>
						<li><?php echo $errors; ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
<div class="alert alert-danger alert-white fade in">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="icon">
		<i class="fa fa-times-circle"></i>
	</div>
	<h4 class="alert-heading"><?php echo $this->error_title; ?></h4>
	<ul>
		<?php foreach($this->inline_error as $errors): ?>
			<li><?php echo $errors; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>