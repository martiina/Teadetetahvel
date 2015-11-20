<?php
require_once '../core/init.php';
$news = new News();
$user = new User();

if(Input::get('logged_in') && $user->isLoggedIn()) {
	if(Input::get('logged_in') === 'false') {
		Redirect::to('/');
	} else {
		$groups = $user->listItems('groups');
		$desknw = $news->getDesktopNews();
			echo '
				<thead class="no-border">
					<tr class="bg-osx">
						<th></th>
						<th>Teade</th>
						<th class="fix-tcenter">Tähtaeg <i id="sort_deadline" class="fa fa-sort sorting"></i></th>
						<th class="fix-tcenter">Autor</th>
						<th class="fix-tcenter">
							<select class="deskSort" id="sortDESKTOP">
								<option value="all">-</option>
				';
					foreach($groups as $group) {
						if($group->id === $user->data()->group) {
							if(Cookie::get('sorting') === 'group') {
								echo '<option value="group" selected>' . $group->name . '</option>';
							} else {
								echo '<option value="group">' . $group->name . '</option>';
							}
						} 
					}
					if(Cookie::get('sorting') === 'everyone') {
						echo '<option value="everyone" selected>Kõigile</option>';
					} else {
						echo '<option value="everyone">Kõigile</option>';
					}
					if(Cookie::get('sorting') === 'personal') { 
						echo '<option value="personal" selected>Sinule</option>';
					} else {
						echo '<option value="personal">Sinule</option>';
					}
				echo '
							</select>
						</th>
						<th class="fix-tcenter">Lisatud <i id="sort_deadline" class="fa fa-sort sorting"></i></th>
						<th class="text-center"><i class="fa fa-pencil"></i></th>
					</tr>
				</thead>
				<tbody>
				';
		if($desknw) {
			foreach($desknw as $new) {
				$status = (newsPercentage($new['deadline'])) ? newsPercentage($new['deadline']) : 'time-gray'; 
				$completed = ($new['completed'] == 0) ? '<span id="jtask" class="not-done"><i class="fa fa-times" id="' . $new['id'] . '">' : '<span id="jtask" class="done"><i class="fa fa-check">';
				echo "<tr>";
					echo "
						<td width='1%' class='notification notification-" . $status . "'></td>
						<td width='25%'>" . $new['content'] . "</td>
						<td width='15%' class='fix-tcenter'>".HumanizeTimestamp($new['deadline'])."</td>
						<td width='10%' class='fix-tcenter'>" . $new['author'] . "</td>
						<td width='5%' class='fix-tcenter'><label class='label label-" . getNewsGroupColor($new['userid'],$new['groupid'])  . "'>" . getNewsGroup($user->data()->id,$new['userid'],$new['groupid']) . "</label></td>						
						<td width='10%' class='fix-tcenter'>" . '<span class="calendar"><i class="fa fa-calendar"></i> '.date('d.m.Y', strtotime($new['date'])) . '</span> <span class="time"><i class="fa fa-clock-o"></i> '.date('H:i:s', strtotime($new['date']))."</span></td>
						<td width='1%' class=\"text-center\"><button class='btn btn-success btn-xs edit_news' id='"  . $new['id'] . "' data-src='/ajax/fetch.php?fnwid=" . $new['id'] . "'><i class='fa fa-pencil'></i></button></td>
					";
				echo "</tr>	";
			}
		} else {
			echo '<tr><td colspan="7" class="fix-tcenter">Uudised puuduvad!</td></tr>';
		}
		echo '
			</tbody>
		';
	}
} else {
	Redirect::to('/desktop/login/');
}
?>
<script>
	// Sortimine -> cookie
	/*$('.deskSort').change(function() { 
		var sorting = $(this).val();
		$.ajax({
			type: 'POST',
			url: '/ajax/custom.php',
			data: {'update_sorting' : true, 'sort_by' : sorting},
		 success: function(){
				$.ajax({
					method: 'POST',
					data: {'logged_in': true},
					url: '/ajax/update.php',
					success: function(data) {
						$('#live_table').html(data);
					}
				});
			}
		});
	});*/
	
	// Edit Modal
	$('.edit_news').click(function() { 
			var src = $(this).attr('data-src');
			var nid = $(this).attr('id');
			$.ajax({
				beforeSend: function() {
					$('.loader-2').show();
				},
				method: 'POST',
				data: {'fnwid' : nid},
				url: '/ajax/fetch.php',
				success: function(data) {
					$('.loader-2').hide();
					$('#changeModal .modal-body').load(src);
					$('#changeModal').modal('show');
				}
			});
			
	});
</script>