<?php if(!$this->dashboard): ?>
<div class="container">
	<div class="row">
		<div class="col-md-<?php echo $this->columns; ?> col-md-offset-<?php echo $this->offset; ?>">
			<div class="alert alert-<?php echo $this->error_type; ?> alert-block fade in">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<h4 class="alert-heading"><?php echo $this->alert_heading; ?></h4>
				<?php echo $this->alert_content; ?>
			</div>
		</div>
	</div>
</div>
<?php else: ?>
<div class="alert alert-<?php echo $this->error_type; ?> alert-block fade in">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<h4 class="alert-heading"><?php echo $this->alert_heading; ?></h4>
	<?php echo $this->alert_content; ?>
</div>
<?php endif; ?>