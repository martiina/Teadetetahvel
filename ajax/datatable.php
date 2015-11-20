<?php

header('Content-type: application/json');

require_once '../core/init.php';
$news = new News();
$user = new User();

function search($array, $key, $value)
{
    $results = array();

    if (is_array($array))
    {
        if (isset($array[$key]) && $array[$key] == $value)
            $results[] = $array;

        foreach ($array as $subarray)
            $results = array_merge($results, search($subarray, $key, $value));
    }

    return $results;
}

if($user->isLoggedIn()) {
		
		$aColumns = array( 'id', 'content', 'date', 'author', 'userid', 'groupid', 'deadline', 'completed' );
		
		$sIndexColumn = "id";
		
		$sTable = "news";
			
		/*
		 * Ordering
		 */
		$sOrder = "";
		if (Input::get('iSortCol_0'))
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( Input::get('iSortingCols') ) ; $i++ )
			{
				if ( Input::get( 'bSortable_'.intval(Input::get('iSortCol_'.$i)) ) == "true" )
				{
					$sOrder .= $aColumns[ intval( Input::get('iSortCol_'.$i) ) ]."
						".Input::get('sSortDir_'.$i) .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		$sWhere = "";
		if ( Input::get('sSearch') != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%". Input::get('sSearch')."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( Input::get('bSearchable_'.$i) == "true" && Input::get('sSearch_'.$i) != '' )
			{
				if ( $sWhere == "" )
				{
					$sWhere = "WHERE ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." archive = '0' LIKE '%".Input::get('sSearch_'.$i)."%' ";
			}
		}
		
		/*
		 * SQL queries
		 * Get data to display
		 */
		if (Input::get('iSortCol_0')) {
			$sQuery = "
				SELECT id, content, date, author, userid, groupid, deadline, completed, (deadline - UNIX_TIMESTAMP()) as date_diff
				FROM $sTable 
				$sWhere
				$sOrder
			";	
		} else {
			$sQuery = "
				SELECT id, content, date, author, userid, groupid, deadline, completed, (deadline - UNIX_TIMESTAMP()) as date_diff
				FROM $sTable 
				WHERE archive = '0'
				ORDER BY (case when date_diff < 0 then 1 else 0 end), date DESC
			";	
		}
		
		$rResult = Database::getInstance()->query($sQuery);
		
		$rResultFilterTotal = Database::getInstance()->query($sQuery);
		$aResultFilterTotal = $rResultFilterTotal->results();
		$iFilteredTotal = $rResultFilterTotal->count();
		
		/* Total data set length */
		$sQuery = "
			SELECT 
			FROM $sTable WHERE archive = '0'
		";
		$rResultTotal = Database::getInstance()->query($sQuery);
		$aResultTotal = $rResultTotal->results();
		$iTotal = $rResultTotal->count();
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval(Input::get('sEcho')),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach ( $rResult->results() as $aRow )
		{
			
			/* explode */
			$exp_user = explode('|',$aRow->userid);
			$exp_group = explode('|',$aRow->groupid);
						
			/* - = kõik teated */
			if(!Cookie::exists('sort_by') || Cookie::get('sort_value') === 'all') {
				if(checkPermissions('administrator')) {
					$output['aaData'][] = $aRow;
				} else {
					if(( $aRow->groupid == 0 && $aRow->userid == 0 ) || in_array($user->data()->group,$exp_group) || in_array($user->data()->id,$exp_user) ) {
						$output['aaData'][] = $aRow;
					}
			
				}
			/* Personaalsed */ 	
			} elseif(Cookie::get('sort_by') === 'user' && Cookie::get('sort_value') == $user->data()->id) { 
				if( in_array($user->data()->id,$exp_user) ) {	
					$output['aaData'][] = $aRow;
				}
			/* User sorting  */	
			} elseif((checkPermissions('administrator') || $aRow->userid == Cookie::get('sort_value')) && Cookie::get('sort_by') === 'user' && Cookie::get('sort_value')) {
				if( in_array(Cookie::get('sort_value'),$exp_user) ) {	
					$output['aaData'][] = $aRow;
				}
			/* Grupi sorting */
			} elseif((checkPermissions('administrator') || $aRow->groupid == Cookie::get('sort_value')) && Cookie::get('sort_by') === 'group' && Cookie::get('sort_value')) { 
				if( in_array(Cookie::get('sort_value'),$exp_group) ) {	
					$output['aaData'][] = $aRow;
				}
			/* Kõigile */	
			} elseif(Cookie::get('sort_by') === 'everyone') { 
				if( $aRow->userid == 0 && $aRow->groupid == 0 ) { 
					$output['aaData'][] = $aRow;
				}
			} 
		}

		//Formaatimine!
		if(!empty($output)) {
		
			for($i = 0; $i < count($output['aaData']); $i++) {
				
				// DeadlineColor
				$output['aaData'][$i]->deadlineColor = newsPercentage($output['aaData'][$i]->deadline) ? newsPercentage($output['aaData'][$i]->deadline) : 'time-gray'; 
				
				// Humanize Deadline
				$output['aaData'][$i]->deadline = HumanizeTimestamp($output['aaData'][$i]->deadline);
				
				// Grupp
				$output['aaData'][$i]->labelColor = getNewsGroupColor($output['aaData'][$i]->userid, $output['aaData'][$i]->groupid);
				$output['aaData'][$i]->groupLabel = getNewsGroup($user->data()->id, $output['aaData'][$i]->userid, $output['aaData'][$i]->groupid);
				
				//Lisatud
				$output['aaData'][$i]->date = EuropeFormat($output['aaData'][$i]->date);
				
				// CompletedColor
				if($output['aaData'][$i]->completed == 1): $output['aaData'][$i]->completedColor = 'c-completed'; else: $output['aaData'][$i]->completedColor = 'c-normal'; endif;
				
			}
		}
		
		//echo prettyPrint(json_encode( $output ));
		echo json_encode( $output );

} else {
	Redirect::to('/desktop/login/');
}
?>