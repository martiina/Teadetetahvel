<div class="container-fluid" id="pcont">
	<div class="cl-mcont">
		<div class="content">
			<?php
				echo getflash(true);
			?>
			<div class="tab-container">
				<ul class="nav nav-tabs">
					<?php if(checkPermissions('administrator')): ?>
						<?php if(Input::get('tab') === 'all'): ?> <li class="active"> <?php else: ?> <li> <?php endif; ?>	
							<a href="/dashboard/notifications/all">
								<i class="fa fa-globe"></i> 
								Kõik teated
							</a>
						</li>
					<?php endif; ?>
					<?php if( $this->archiveCount && checkPermissions('administrator') ): ?>
						<?php if(Input::get('tab') === 'archive'): ?> <li class="active"> <?php else: ?> <li> <?php endif; ?>	
							<a href="/dashboard/notifications/archive">
								<i class="fa fa-folder"></i>
								Arhiiv
							</a>
						</li>
					<?php endif; ?>
						<?php if(Input::get('tab') === 'user' || !Input::get('tab') || !checkPermissions('administrator')): ?> <li class="active"> <?php else: ?> <li> <?php endif; ?>	
							<a href="/dashboard/notifications/user">
								<i class="fa fa-user"></i> 
								<?php echo $this->userdata->firstname.' '.$this->userdata->lastname; ?>
							</a>
						</li>
						
					<?php if(checkPermissions('administrator')): ?>
						<?php if(Input::get('tab') === 'done'): ?> <li class="active"> <?php else: ?> <li> <?php endif; ?>	
							<a href="/dashboard/notifications/done">
								<i class="fa fa-check"></i> 
								Kinnitamata teated <strong style="color:red;">(<?php echo $this->doneNewsCount; ?>)</strong>
							</a>
						</li>
					<?php endif; ?>
				</ul>
				<div class="tab-content">
					<div class="ajax" style="display:none;"></div>
					<?php if(Input::get('tab') === 'all'): ?>
						<?php if(checkPermissions('administrator')): ?>
							<div id="admin">
								<?php if($this->getNewsData): ?>
									<div class="table-responsive">
										<table class="table table-bordered dataTable">
											<thead>
												<tr>
													<th>#</th><th>Ülesanne</th><th>Autor</th><th>Lisatud KP</th><th>Grupp</th><th>Tähtaeg</th><th>Muuda</th>
												</tr>
											</thead>
										<tbody>
											<?php foreach($this->getNewsData as $newsData): ?>
											<?php $status = (newsPercentage($newsData->deadline)) ? newsPercentage($newsData->deadline) : 'time-gray'; ?>
												<tr class="nwtr-<?php echo $newsData->id; ?>">
													<td class="notification notification-<?php echo $status; ?>" width="1%"></td>
													<td width="25%"><?php echo $newsData->content; ?></td>
													<td width="10%"><?php echo $newsData->author; ?></td>
													<td width="10%"><?php echo EuropeFormat($newsData->date); ?></td>
													<td width="5%"><?php echo getNewsGroup($this->userdata->id, $newsData->userid, $newsData->groupid); ?></td>
													<td width="15%"><?php echo HumanizeTimestamp($newsData->deadline); ?></td>
													<td width="10%">
													<a href="#" class="archive-me" id="<?php echo $newsData->id; ?>">Arhiveeri</a> |
													<a href="/dashboard/edit/<?php echo $newsData->id; ?>/">Muuda andmeid</a>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
										</table>
									</div>
								<?php else: ?>
									<div class="notification notification-info">
										<h4>Ühtegi teadet ei leitud</h4>
									</div>
								<?php endif; ?>
								<div class="clear"></div>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<?php if(Input::get('tab') === 'archive'): ?>
						<?php if( $this->archiveCount && checkPermissions('administrator') ): ?>
							<div id="archive">
								<?php if($this->archiveData): ?>
									<div class="table-responsive">
										<table class="table table-bordered dataTable">
										<thead>
											<tr>
												<th>#</th><th>Ülesanne</th><th>Autor</th><th>Lisatud KP</th><th>Tähtaeg</th><th>#</th>
											</tr>
										</thead>
										<tbody>
										<?php foreach($this->archiveData as $archiveData): ?>
										<?php $status = (newsPercentage($archiveData->deadline)) ? newsPercentage($archiveData->deadline) : 'time-gray'; ?>
											<tr class="nwtr-<?php echo $archiveData->id; ?>">
												<td class="notification notification-<?php echo $status; ?>" width="1%"></td>
												<td width="25%"><?php echo $archiveData->content; ?></td>
												<td width="10%"><?php echo str_replace('<br />', '', $archiveData->author); ?></td>
												<td width="10%"><?php echo EuropeFormat($archiveData->date); ?></td>
												<td width="15%"><?php echo HumanizeTimestamp($archiveData->deadline); ?></td>
												<td width="10%">
													<a href="#" class="restore-me" id="<?php echo $archiveData->id; ?>">Taasta</a> | <a class="delete-me" href="#" id="<?php echo $archiveData->id; ?>">Arhiveeri lõplikult</a>
												</td>
											</tr>
										<?php endforeach; ?>
										</tbody>
										</table>
									</div>
								<?php else: ?>
								<div class="notification notification-info">
									<h4>Ühtegi teadet ei leitud</h4>
								</div>
								<?php endif; ?>
								<div class="clear"></div>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<?php if(Input::get('tab') === 'user' || !Input::get('tab') || !checkPermissions('administrator')): ?>
						<div id="user" class="tab-pane cont active">
							<?php if($this->displayNewsByAuthor): ?>
								<div class="alert alert-info alert-dismissable">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button>
									<i class="fa fa-info-circle sign"></i>
									<strong>Info!</strong>
									Teadet saad otse muuta, kui vajutada kriipsudega allajoonitud tekstile!
									Siin on Sinu antud ülesanded!
								</div>
								<div class="table-responsive">
									<table class="table table-bordered dataTable">
										<thead>
											<tr>
												<th>#</th><th>Ülesanne</th><th>Autor</th><th>Lisatud KP</th><th>Tähtaeg</th><th>#</th>
											</tr>
										</thead>
									<tbody>
									<?php foreach($this->displayNewsByAuthor as $toAuthor): ?>
									<?php $status = (newsPercentage($toAuthor->deadline)) ? newsPercentage($toAuthor->deadline) : 'time-gray'; ?>
										<tr class="nwtr-<?php echo $toAuthor->id; ?>">
											<td width="1%" class="notification notification-<?php echo $status; ?>"></td>
											<td id="muudaAdmin" width="25%"><a href="#" data-name="content" data-type="textarea" data-pk="<?php echo $toAuthor->id; ?>"><?php echo str_replace('<br />', '', $toAuthor->content); ?></a></td>
											<td width="10%"><?php echo $toAuthor->author; ?></td>
											<td width="10%"><?php echo EuropeFormat($toAuthor->date); ?></td>
											<td width="15%" id="muudaDate"><a href="" data-viewformat="MMM D, YYYY, HH:mm" data-format="DD-MM-YYYY HH:mm" data-template="D-MMM-YYYY HH:mm" data-name="deadline" data-type="combodate" data-title='Formaat: Päev/Kuu/Aasta - Tund/Minut' data-value="<?php echo date('d-m-Y H:i',$toAuthor->deadline); ?>" data-pk="<?php echo $toAuthor->id; ?>"><?php echo HumanizeTimestamp($toAuthor->deadline); ?></a></td>
											<td width="10%">
												<a href="#" class="delete-me" id="<?php echo $toAuthor->id; ?>">Kustuta</a> |
												<a href="/dashboard/edit/<?php echo $toAuthor->id; ?>/">Muuda andmeid</a>
											</td>
										</tr>
									<?php endforeach; ?>
									</tbody>
									</table>
								</div>
							<?php else: ?>
							<div class="notification notification-info">
								<h4>Sa pole ühtegi ülesannet lisanud.</h4>
							</div>
							<?php endif; ?>
							<div class="clear"></div>
						</div>
					<?php endif; ?>
					<?php if(Input::get('tab') === 'done' && checkPermissions('administrator') ): ?>
						<div id="archive">
							<?php if($this->doneNews): ?>
								<div class="table-responsive">
									<table class="table table-bordered dataTable">
									<thead>
										<tr>
											<th>Ülesanne</th><th>Autor</th><th>Lisatud KP</th><th>Tähtaeg</th><th>#</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($this->doneNews as $done): ?>
										<tr class="nwtr-<?php echo $done->id; ?>">
											<td width="25%"><?php echo $done->content; ?></td>
											<td width="10%"><?php echo str_replace('<br />', '', $done->author); ?></td>
											<td width="10%"><?php echo EuropeFormat($done->date); ?></td>
											<td width="15%"><?php echo HumanizeTimestamp($done->deadline); ?></td>
											<td width="15%">
												<a href="#" class="check-done" id="<?php echo $done->id; ?>">Märgi sooritatuks</a> | <a class="check-undone" href="#" id="<?php echo $done->id; ?>">Saada tagasi</a>
											</td>
										</tr>
									<?php endforeach; ?>
									</tbody>
									</table>
								</div>
							<?php else: ?>
							<div class="notification notification-info">
								<h4>Ühtegi teadet ei leitud</h4>
							</div>
							<?php endif; ?>
							<div class="clear"></div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>	
	</div>
</div>