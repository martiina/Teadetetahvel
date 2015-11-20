<?php
	// Kõik teated tabi menüüd, et navigatsioonil jääks ikka active class püsima, kui vahetada tabe.
	$notes = array('/dashboard/notifications/all/', '/dashboard/notifications/archive/', '/dashboard/notifications/user/');
?>
<li <?php echo activeMenu('/desktop/'); ?>><a href="/desktop"><i class="fa fa-home"></i> <span>Desktop</span></a></li>
<li class="parent"><a href="#"><i class="glyphicon glyphicon-list-alt"></i> <span>Teated</span></a>
	<ul class="sub-menu">
		<li <?php foreach($notes as $note) { echo activeMenu($note); } ?>><a href="/dashboard/notifications/all"><i class="glyphicon glyphicon-list-alt"></i> Kõik teated</a></li>
		<li <?php echo activeMenu('/dashboard/add/'); ?>><a href="/dashboard/add"><i class="fa fa-pencil"></i> Lisa teade</a></li>
	</ul>
</li>
<?php if(checkPermissions('administrator')): ?>
<li class="parent"><a href="#"><i class="fa fa-users"></i> <span>Kasutajad</span></a>
	<ul class="sub-menu">
		<li <?php echo activeMenu('/dashboard/users/'); ?>><a href="/dashboard/users"><i class="fa fa-group"></i> Kõik kasutajad</a></li>
		<li <?php echo activeMenu('/dashboard/adduser/'); ?>><a href="/dashboard/adduser"><i class="fa fa-plus"></i> Lisa kasutaja</a></li>
	</ul>
</li>
<?php endif; ?>
<li <?php echo activeMenu('/dashboard/settings/'); ?>><a href="/dashboard/settings"><i class="fa fa-cog"></i> <span>Seaded</span></a></li>