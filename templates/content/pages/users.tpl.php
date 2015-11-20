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
					<div class="header no-border">
						<h2>Kasutajad</h2>
					</div>
					<div class="content no-padding">
						<div class="table-responsive">
							<table class="table table-bordered dataTable">
								<thead>
									<tr>
										<th>#</th>
										<th>Kasutajanimi</th>
										<th>Eesnimi</th>
										<th>Perekonnanimi</th>
										<th>Liitumisaeg</th>
										<th>Grupp</th>
										<th>#</th>
									</tr>
								</thead>
								<tbody>
									<?php
										global $user;
										$x = 0;
										foreach($this->getUsers as $users) {
											$x++;
											echo "
												<tr>
													<td>{$x}</td>
													<td>{$users->username}</td>
													<td>{$users->firstname}</td>
													<td>{$users->lastname}</td>
													<td>".EuropeFormat($users->joined)."</td>
													<td>{$user->getGroupNameByID($users->group)}</td>
													<td><a href=\"/dashboard/change/user/{$users->id}/\">Muuda</a></td>
												</tr>
											";
										}
									?>
								</tbody>
							</table>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>