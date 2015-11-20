<li>
	<a href="/desktop/"> Desktop</a>
</li>
<li class="dropdown cUser">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-user"></i> <?php echo $this->userdata->firstname . ' ' . $this->userdata->lastname; ?> <i class="fa fa-caret-down"></i>
	</a>
	<ul class="dropdown-menu">
		<li><a href="/logout/"><i class="fa fa-sign-out"></i> Logi välja</a></li>
	</ul>
</li>