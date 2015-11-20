<div class="container-fluid" id="pcont">
	<div class="cl-mcont">
		<div class="row dash-cols">
			<div class="col-sm-12 col-md-12">
				<div class="block no-padding">
					<div class="content no-padding">
						<table id="live_table" class="table no-border red">
							<thead class="no-border">
								<tr class="bg-osx">
									<th style="width: 1%"></th>
									<th style="width: 25%">Teade</th>
									<th class="fix-tcenter" style="width: 15%">Tähtaeg <i id="sort_deadline" class="fa fa-sort sorting"></i></th>
									<th class="fix-tcenter" style="width: 10%">Autor <i id="sort_author" class="fa fa-sort sorting"></i></th>
									<th class="fix-tcenter" style="width: 5%">
										<select class='deskSort' id="sortDESKTOP">
											<option value='all'>-</option>
											<?php foreach($this->sortNewsList as $sort): ?>
												<option value="<?php echo $sort['value']; ?>" arial-type="<?php echo $sort['sort_by']; ?>" <?php if(Cookie::get('sort_by') === $sort['sort_by'] && Cookie::get('sort_value') == $sort['value']): echo 'selected'; endif;?>><?php echo $sort['name']; ?></option>
											<?php endforeach; ?>
										</select>
									</th>
									<th class="fix-tcenter" style="width: 10%">Lisatud <i id="sort_deadline" class="fa fa-sort sorting"></i></th>
									<th class="text-center" style="width: 1%"><i class="fa fa-pencil"></i></th>
								</tr>
							</thead>
						</table>
						<div class="clear"></div>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>