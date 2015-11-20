<div id="cl-wrapper" class="fixed-menu <?php echo $this->status; ?>">
	<div class="cl-sidebar">
		<div class="cl-toggle"><i class="fa fa-bars"></i></div>
		<div class="cl-navblock">
			<div class="menu-space">
				<div class="content">
					<div class="side-user">
						<?php 
							$getAvatar = getAvatar($this->userdata->id);
							$avatar = ($getAvatar && file_exists('assets/avatars/'.$getAvatar)) ?  '/assets/avatars/' . $getAvatar : '/assets/avatars/no-avatar.jpg'; 
						?>
						<div class="avatar"><img class="img-circle sb-avatar" src="<?php echo $avatar ?>" alt="Avatar" /></div>
						<div class="info">
							<a href="#"><?php echo $this->userdata->firstname.' '.$this->userdata->lastname; ?></a>
							<span><?php echo $this->groupName; ?></span>
						</div>
					</div>
					<ul class="cl-vnavigation">
						<?php 
							include_once $this->template('templates/content/navigation/dashboard_navigation.tpl.php');
						?>
					</ul>
				</div>
			</div>
			<div class="text-right collapse-button" style="padding:7px 13px;">
				<button id="sidebar-collapse" class="btn btn-default" style=""><i style="color:#fff;" class="<?php echo $this->icon; ?>"></i></button>
			</div>
		</div>
	</div>
	<?php include_once $this->template($this->content); ?>
</div>
