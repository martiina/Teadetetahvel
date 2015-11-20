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
						<h2>Võru Spordikeskuse Teadetetabel!</h2>
					</div>
					<div class="content">
						<div class="tab-container">
							<ul class="nav nav-tabs">
								<li class="active">
									<a data-toggle="tab" href="#user">
										<i class="fa fa-user"></i> 
										<?php echo $this->userdata->firstname.' '.$this->userdata->lastname; ?>
									</a>
								</li>
								<li>
									<a data-toggle="tab" href="#group">
										<i class="fa fa-group"></i> 
										<?php echo $this->getGroup; ?>
									</a>
								</li>
								<li>
									<a data-toggle="tab" href="#all">
										<i class="fa fa-globe"></i> 
										Kõigile
									</a>
								</li>
							</ul>
						</div>
						<div class="tab-content">
							<div id="user" class="tab-pane cont active">
								<?php
									if($this->getUserNewsCount) {
										echo "Sul on {$this->getUserNewsCount} uudist!<br />";
										foreach($this->displayNewsUser as $news) {
											$edited = (empty($news['edited_by'])) ? '' : '<small style="text-align:right;"><em><i class="fa fa-pencil"></i> Muutis: '.$news['edited_by'].'</em></small>';
											$completed = ($news['completed'] == 0) ? '<span id="jtask" class="not-done"><i class="fa fa-times" id="' . $news['id'] . '">' : '<span id="jtask" class="done"><i id="' . $news['id'] . '" class="fa fa-check">';
											$getAvatar = getAvatar($news['authorid']);
											$avatar = ($getAvatar && file_exists('assets/avatars/'.$getAvatar)) ?  '../assets/avatars/' . $getAvatar : '../assets/avatars/no-avatar.jpg';
											$deadline = ($news['deadline'] != 0) ? HumanizeTimestamp($news['deadline']) : 'Tähtaega pole';
											$tr = ($edited) ? '<tr><td class="fix-tleft" colspan="2" height="20%" style="border-left:1px solid #DDD;border-top:1px solid #DDD;">' . $edited .  ' </td></tr>' : '';
								?>			
											<div class="container-fluid notification notification-container">
												<table class="no-border">
													<tr class="notification notification-gray">
														<td width="20%">Postitatud: <?php echo date('d.m.Y - H:i:s', strtotime($news['date'])); ?></td>
														<td class="fix-tleft nwt-<?php echo $news['id']; ?>"><?php echo $news['title']; ?></td>
														<td width="33" class="bg-gray"><?php echo $completed; ?></span></td>
													</tr>
													<tr class="notification notification-gray">
														<td>Tähtaeg</td>
														<td colspan="2"><div class="text-info text-left"><?php echo $deadline; ?></div></td>
													</tr>
													<tr>
														<td class="fix-nbb" rowspan="2">
															<small class="label label-<?php if(getUserGroupId($news['authorid']) == 1): echo 'success'; else: echo 'danger'; endif; ?>"><?php echo getUserGroup($news['authorid']); ?></small>
															<div class="avatar" style="margin-top:10px;"><img src="<?php echo $avatar; ?>" class="fr-avatar"></div>
															<small><?php echo $news['author']; ?></small>
														</td>
														<td class="fix-nbb fix-valign-t" colspan="2">
															<div class="fix-tjustify"><?php echo $news['content']; ?></div>
														</td>
													</tr>
													<?php echo $tr; ?>
												</table>	
											</div>	
								<?php 			
										}
									} else {
										echo "Uudiseid pole";
									}
								?>
							</div>
							<div id="group" class="tab-pane cont">
								<?php
									if($this->getGroupNewsCount) {
										echo "Sul on {$this->getGroupNewsCount} uudist grupis!<br />";
										foreach($this->displayNewsGroup as $news) {
										$edited = (empty($news['edited_by'])) ? '' : '<small style="text-align:right;"><em><i class="fa fa-pencil"></i> Muutis: '.$news['edited_by'].'</em></small>';
										$completed = ($news['completed'] == 0) ? '<span id="jtask" class="not-done"><i class="fa fa-times" id="' . $news['id'] . '">' : '<span id="jtask" class="done"><i id="' . $news['id'] . '" class="fa fa-check">';
										$getAvatar = getAvatar($news['authorid']);
										$avatar = ($getAvatar && file_exists('assets/avatars/'.$getAvatar)) ?  '../assets/avatars/' . $getAvatar : '../assets/avatars/no-avatar.jpg';
										$deadline = ($news['deadline'] != 0) ? HumanizeTimestamp($news['deadline']) : 'Tähtaega pole';
										$tr = ($edited) ? '<tr><td class="fix-tleft" colspan="2" height="20%" style="border-left:1px solid #DDD;border-top:1px solid #DDD;">' . $edited .  ' </td></tr>' : '';
								?>
											<div class="container-fluid notification notification-container">
												<table class="no-border">
													<tr class="notification notification-gray">
														<td width="20%">Postitatud: <?php echo date('d.m.Y - H:i:s', strtotime($news['date'])); ?></td>
														<td class="fix-tleft nwt-<?php echo $news['id']; ?>"><?php echo $news['title']; ?></td>
														<td width="33" class="bg-gray"><?php echo $completed; ?></span></td>
													</tr>
													<tr class="notification notification-gray">
														<td>Tähtaeg</td>
														<td colspan="2"><div class="text-info text-left"><?php echo $deadline; ?></div></td>
													</tr>
													<tr>
														<td class="fix-nbb" rowspan="2">
															<small class="label label-<?php if(getUserGroupId($news['authorid']) == 1): echo 'success'; else: echo 'danger'; endif; ?>"><?php echo getUserGroup($news['authorid']); ?></small>
															<div class="avatar" style="margin-top:10px;"><img src="<?php echo $avatar; ?>" class="fr-avatar"></div>
															<small><?php echo $news['author']; ?></small>
														</td>
														<td class="fix-nbb fix-valign-t" colspan="2">
															<div class="fix-tjustify"><?php echo $news['content']; ?></div>
														</td>
													</tr>
													<?php echo $tr; ?>
												</table>	
											</div>	
									<?php		
										}
									} else {
										echo "Uudiseid pole";
									}
								?>
							</div>
							<div id="all" class="tab-pane cont">
								<?php
									if($this->getAllNewsCount) {
										echo "Sul on {$this->getAllNewsCount} uudist kõigile!<br />";								
										foreach($this->displayNewsAll as $news) {
										$edited = (empty($news->edited_by)) ? '' : '<small style="text-align:right;"><em><i class="fa fa-pencil"></i> Muutis: '.$news->edited_by.'</em></small>';
										$completed = ($news->completed == 0) ? '<span id="jtask" class="not-done"><i class="fa fa-times" id="' . $news->id . '">' : '<span id="jtask" class="done"><i id="' . $news->id . '" class="fa fa-check">';
										$getAvatar = getAvatar($news->authorid);
										$avatar = ($getAvatar && file_exists('assets/avatars/'.$getAvatar)) ?  '../assets/avatars/' . $getAvatar : '../assets/avatars/no-avatar.jpg';
										$deadline = ($news->deadline != 0) ? HumanizeTimestamp($news->deadline) : 'Tähtaega pole';
										$tr = ($edited) ? '<tr><td class="fix-tleft" colspan="2" height="20%" style="border-left:1px solid #DDD;border-top:1px solid #DDD;">' . $edited .  ' </td></tr>' : '';
								?>
											<div class="container-fluid notification notification-container">
												<table class="no-border">
													<tr class="notification notification-gray">
														<td width="20%">Postitatud: <?php echo date('d.m.Y - H:i:s', strtotime($news->date)); ?></td>
														<td class="fix-tleft nwt-<?php echo $news->id; ?>"><?php echo $news->title; ?></td>
														<td width="33" class="bg-gray"><?php echo $completed; ?></span></td>
													</tr>
													<tr class="notification notification-gray">
														<td>Tähtaeg</td>
														<td colspan="2"><div class="text-info text-left"><?php echo $deadline; ?></div></td>
													</tr>
													<tr>
														<td class="fix-nbb" rowspan="2">
															<small class="label label-<?php if(getUserGroupId($news->authorid) == 1): echo 'success'; else: echo 'danger'; endif; ?>"><?php echo getUserGroup($news->authorid); ?></small>
															<div class="avatar" style="margin-top:10px;"><img src="<?php echo $avatar; ?>" class="fr-avatar"></div>
															<small><?php echo $news->author; ?></small>
														</td>
														<td class="fix-nbb fix-valign-t" colspan="2">
															<div class="fix-tjustify"><?php echo $news->content; ?></div>
														</td>
													</tr>
													<?php echo $tr; ?>
												</table>	
											</div>
								<?php
										}
									} else {
										echo "Uudiseid pole";
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>