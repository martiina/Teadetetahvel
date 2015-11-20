<?php
class News {
	
	private $_db;
	
	public function __construct() {
		$this->_db = Database::getInstance();
	}
	
	public function getNewsCount($user_id, $group_id) {
		if($user_id) {
			$news_query = $this->_db->query("SELECT * FROM news WHERE archive = ? ORDER BY deadline ASC, date DESC", array(0));
			if($news_query->count()) {
				$news_count = 0;
				foreach($news_query->results() as $news) {
					$news_id = explode('|', $news->userid);
					foreach($news_id as $uid) {
						if($uid === $user_id) {
							$news_count++;
						}
					}
				}
				return $news_count;
			}
		} elseif($group_id) {
			$news_query = $this->_db->query("SELECT * FROM news WHERE archive = ? ORDER BY deadline ASC, date DESC", array(0));
			if($news_query->count()) {
				$news_count = 0;
				foreach($news_query->results() as $news) {
					$news_id = explode('|', $news->groupid);
					foreach($news_id as $uid) {
						if($uid === $group_id) {
							$news_count++;
						}
					}
				}
				return $news_count;
			}
		} else {
			$global_query = $this->_db->query("SELECT * FROM news WHERE userid = ? AND groupid = ? AND archive = ? ORDER BY deadline ASC, date DESC", array($user_id, $group_id, 0));
			if($global_query->count()) {
				return $global_query->count();
			}
		}
		return false;
	}
	
	public function displayNews($user_id,$group_id,$author_id) {
		if($user_id) {
			/* User news */
			$toArr = array();
			$i = 0;
			$global_query = $this->_db->query("SELECT * FROM news WHERE archive = ? ORDER BY deadline ASC, date DESC", array(0));
			if($global_query->count()) {
				$data = $global_query->results();
				foreach($data as $user_news) {
					$uid = explode('|', $user_news->userid);
					foreach($uid as $bit) {
						if($bit === $user_id) {
							$toArr[$i]['id'] = $user_news->id;
							$toArr[$i]['title'] = $user_news->title;
							$toArr[$i]['content'] = $user_news->content;
							$toArr[$i]['author'] = $user_news->author;
							$toArr[$i]['date'] = $user_news->date;
							$toArr[$i]['authorid'] = $user_news->authorid;
							$toArr[$i]['edited_by'] = $user_news->edited_by;
							$toArr[$i]['completed'] = $user_news->completed;
							$toArr[$i]['deadline'] = $user_news->deadline;
							$i++;
						}
					}
				}
				return $toArr;
			}
		} elseif($group_id) {
			/* Group news */
			$toArr = array();
			$i = 0;
			$global_query = $this->_db->query("SELECT * FROM news WHERE archive = ? ORDER BY deadline ASC, date DESC", array(0));
			if($global_query->count()) {
				$data = $global_query->results();
				foreach($data as $user_news) {
					$uid = explode('|', $user_news->groupid);
					foreach($uid as $bit) {
						if($bit === $group_id) {
							$toArr[$i]['id'] = $user_news->id;
							$toArr[$i]['title'] = $user_news->title;
							$toArr[$i]['content'] = $user_news->content;
							$toArr[$i]['author'] = $user_news->author;
							$toArr[$i]['date'] = $user_news->date;
							$toArr[$i]['authorid'] = $user_news->authorid;
							$toArr[$i]['edited_by'] = $user_news->edited_by;
							$toArr[$i]['completed'] = $user_news->completed;
							$toArr[$i]['deadline'] = $user_news->deadline;
							$i++;
						}
					}
				}
				return $toArr;
			}
		} elseif($author_id) {
			/* Author news */
			$global_query = $this->_db->get('news',array('authorid','=',$author_id));
			if($global_query->count()) {
				$data = $global_query->results();
				return $data;
			}
		} else {
			/* ALl news */
			$global_query = $this->_db->query("SELECT * FROM news WHERE userid = ? AND groupid = ? AND archive = ? ORDER BY deadline ASC, date DESC", array($user_id, $group_id, 0));
			if($global_query->count()) {
				$data = $global_query->results();
				return $data;
			}
		}
		return false;
	}
	
	/*#############################
	- Sortimine
	##############################*/
	public function sortNewsList() {
		
		global $user;
		$query = $this->_db->query("SELECT * FROM news WHERE archive = ?", array(0));
		
		if($query->count()) {
			$results = $query->results();
			
			$list = array();
			$user_list = array();
			$group_list = array();
			
			$all_count = 0;
			
			foreach($results as $result) {
			
				// users
				$users_r = explode('|', $result->userid);				
				foreach($users_r as $user_r) {
					if(!in_array($user_r,$user_list)) {
						array_push($user_list,$user_r);
					}
				}
	
				// groups
				$groups = explode('|', $result->groupid);
				foreach($groups as $group) {
					if(!in_array($group,$group_list)) {
						array_push($group_list,$group);
					}
				}
			};
			
			$all_count = count(array_keys($user_list,0));
			$all_count += count(array_keys($group_list,0));
			
			if($all_count == 2) {
				$list[] = array(
					'sort_by' => 'everyone',
					'value' => 0,
					'name'	=> 'Kõigile'
				);
			}
			
			foreach($user_list as $ele) {
				if((checkPermissions('administrator') || $ele == $user->data()->id) && $ele != 0 && $all_count == 2) {
				
					$query = $this->_db->get('users', array('id', '=', $ele));
				
					$list[] = array(
						'sort_by' => 'user',
						'value' => $ele,
						'name' => $query->first()->firstname.' '.$query->first()->lastname
					);
				}
			}
			
			foreach($group_list as $ele) {
				if((checkPermissions('administrator') || $ele == $user->data()->group) && $ele != 0 && $all_count == 2) {
				
					$query = $this->_db->get('groups', array('id', '=', $ele));
				
					$list[] = array(
						'sort_by' => 'group',
						'value' => $ele,
						'name' => $query->first()->name
					);
				}
			}
						
			return $list;
		}
		return false;
	}
	
	/*#############################
	- Uudiste kuvamised
	##############################*/
	public function displayNewsAll($user_id,$group_id) {	
		$query = $this->_db->query("SELECT * FROM news WHERE userid = ? AND groupid = ? AND archive = ? ORDER BY deadline ASC, date DESC", array($user_id, $group_id, 0));
		if($query->count()) {
			$this->_countAll = $query->count();
			$data = $query->results();
			return $data;
		}
		return false;
	}	

	public function displayNewsByAuthor($author) {
		$query = $this->_db->query("SELECT * FROM news WHERE authorid = ? AND archive = ? ORDER BY deadline ASC, date DESC", array($author, 0));
		if($query->count())	{
			$data = $query->results();
			return $data;
		}
		return false;
	}
	
	public function add($fields = array()) {
		if(!$this->_db->insert('news', $fields)) {
			throw new Exception("VIGA! Uudise lisamisel!");
		}
	}
	
	public function getNewsData() {
		$query = $this->_db->query("SELECT * FROM news WHERE archive = ? ORDER BY deadline ASC, date DESC", array(0));
		if($query->count())	{
			$data = $query->results();
			return $data;
		}
		return false;
	}
	
	/*
		* Sisseloginud kasutajatele talle mõeldud uudiste kuvamine!
	*/
	public function getDesktopNews() {
		global $user;
		$toArr = array();
		$i = 0;
		$query = $this->_db->query("SELECT * FROM news WHERE archive = ? ORDER BY deadline DESC, date ASC", array(0));
		if($query->count()) {
			$data = $query->results();
			/* - = kõik uudised */
			if(!Cookie::exists('sort_by') || Cookie::get('sort_by') === 'all') {
				foreach($data as $dp) {
					$gid = explode('|', $dp->groupid);
					$uid = explode('|', $dp->userid);
					if(in_array($user->data()->id, $uid)) {
						foreach($uid as $bit) {
							if($bit === $user->data()->id) {
								$toArr[$i]['title'] = $dp->title;
								$toArr[$i]['content'] = $dp->content;
								$toArr[$i]['date'] = $dp->date;
								$toArr[$i]['author'] = $dp->author;
								$toArr[$i]['userid'] = $dp->userid;
								$toArr[$i]['groupid'] = $dp->groupid;
								$toArr[$i]['deadline'] = $dp->deadline;
								$toArr[$i]['id'] = $dp->id;
								$toArr[$i]['completed'] = $dp->completed;
								$i++;
							}
						}
					}
					if(in_array($user->data()->group, $gid)) {
						foreach($gid as $bit) {
							if($bit === $user->data()->group) {
								$toArr[$i]['title'] = $dp->title;
								$toArr[$i]['content'] = $dp->content;
								$toArr[$i]['date'] = $dp->date;
								$toArr[$i]['author'] = $dp->author;
								$toArr[$i]['userid'] = $dp->userid;
								$toArr[$i]['groupid'] = $dp->groupid;
								$toArr[$i]['deadline'] = $dp->deadline;
								$toArr[$i]['id'] = $dp->id;
								$toArr[$i]['completed'] = $dp->completed;
								$i++;
							}
						}
					}
				}
				$all = $this->_db->query("SELECT * FROM news WHERE userid = ? AND groupid = ? AND archive = ? ORDER BY deadline DESC, date ASC", array(0, 0, 0));
				if($all->count()) {
					$all_data = $all->results();
					foreach($all_data as $all_dp) {
						$toArr[$i]['title'] = $all_dp->title;
						$toArr[$i]['content'] = $all_dp->content;
						$toArr[$i]['date'] = $all_dp->date;
						$toArr[$i]['author'] = $all_dp->author;
						$toArr[$i]['userid'] = $all_dp->userid;
						$toArr[$i]['groupid'] = $all_dp->groupid;
						$toArr[$i]['deadline'] = $all_dp->deadline;
						$toArr[$i]['id'] = $all_dp->id;
						$toArr[$i]['completed'] = $all_dp->completed;
						$i++;
					}
				}
			/* Personaalne */
			} elseif(Cookie::get('sort_by') === 'user' && Cookie::get('sort_value') === $user->data()->id) { 
				$personal = $this->_db->query("SELECT * FROM news WHERE archive = ? ORDER BY deadline DESC, date ASC", array(0));
				if($personal->count()) {
					$personal_data = $personal->results();
					foreach($personal_data as $person) {
						$exp = explode('|', $person->userid);
						if(in_array($user->data()->id, $exp)) {
							$toArr[$i]['title'] = $person->title;
							$toArr[$i]['content'] = $person->content;
							$toArr[$i]['date'] = $person->date;
							$toArr[$i]['author'] = $person->author;
							$toArr[$i]['userid'] = $person->userid;
							$toArr[$i]['groupid'] = $person->groupid;
							$toArr[$i]['deadline'] = $person->deadline;
							$toArr[$i]['id'] = $person->id;
							$toArr[$i]['completed'] = $person->completed;
							$i++;
						}
					}
				}
			} elseif(Cookie::get('sort_by') === 'user' && Cookie::get('sort_value')) {
				$users = $this->_db->query("SELECT * FROM news WHERE archive = ? ORDER BY deadline DESC, date ASC", array(0));
				if($users->count()) {
					$user_data = $users->results();
					foreach($user_data as $user) { 
						$exp = explode('|', $user->groupid);
						if(in_array(Cookie::get('sort_value'), $exp)) {
							$toArr[$i]['title'] = $user->title;
							$toArr[$i]['content'] = $user->content;
							$toArr[$i]['date'] = $user->date;
							$toArr[$i]['author'] = $user->author;
							$toArr[$i]['userid'] = $user->userid;
							$toArr[$i]['groupid'] = $user->groupid;
							$toArr[$i]['deadline'] = $user->deadline;
							$toArr[$i]['id'] = $usre->id;
							$toArr[$i]['completed'] = $user->completed;
							$i++;
						}
					}
				}
			/* Grupi sort */	
			} elseif(Cookie::get('sort_by') === 'group' && Cookie::get('sort_value')) {
				$groups = $this->_db->query("SELECT * FROM news WHERE archive = ? ORDER BY deadline DESC, date ASC", array(0));
				if($groups->count()) {
					$group_data = $groups->results();
					foreach($group_data as $group) { 
						$exp = explode('|', $group->groupid);
						if(in_array(Cookie::get('sort_value'), $exp)) {
							$toArr[$i]['title'] = $group->title;
							$toArr[$i]['content'] = $group->content;
							$toArr[$i]['date'] = $group->date;
							$toArr[$i]['author'] = $group->author;
							$toArr[$i]['userid'] = $group->userid;
							$toArr[$i]['groupid'] = $group->groupid;
							$toArr[$i]['deadline'] = $group->deadline;
							$toArr[$i]['id'] = $group->id;
							$toArr[$i]['completed'] = $group->completed;
							$i++;
						}
					}
				}
			/* Kõigile */	
			} elseif(Cookie::get('sort_by') === 'everyone') { 
				$all = $this->_db->query("SELECT * FROM news WHERE userid = ? AND groupid = ? AND archive = ? ORDER BY deadline DESC, date ASC", array(0, 0, 0));
				if($all->count()) {
					$all_data = $all->results();
					foreach($all_data as $all_dp) {
						$toArr[$i]['title'] = $all_dp->title;
						$toArr[$i]['content'] = $all_dp->content;
						$toArr[$i]['date'] = $all_dp->date;
						$toArr[$i]['author'] = $all_dp->author;
						$toArr[$i]['userid'] = $all_dp->userid;
						$toArr[$i]['groupid'] = $all_dp->groupid;
						$toArr[$i]['deadline'] = $all_dp->deadline;
						$toArr[$i]['id'] = $all_dp->id;
						$toArr[$i]['completed'] = $all_dp->completed;
						$i++;
					}
				}
			}
			usort($toArr, function($a1, $a2) {
				$v1 = $a1['deadline'];
				$v2 = $a2['deadline'];
				return $v2 - $v1;
			});
			return $toArr;
		}
		return false;
	}
	
	public function getDesktopNewsCount() {
		global $user;
		$counter = 0;
		// Grupi ja Kasutaja uudised
		$query = $this->_db->query("SELECT * FROM news WHERE archive = ? ORDER BY deadline ASC, date DESC", array(0));
		foreach($query->results() as $dp) {
			$gid = explode('|', $dp->groupid); $uid = explode('|', $dp->userid);
			foreach($uid as $bit) { 
				if($bit === $user->data()->id) { 
					$counter++;
				}
			}
			foreach($gid as $bit) { 
				if($bit === $user->data()->group) { 
					$counter++;
				}
			}
		}
		// Kõigile mõeldud uudised
		$allnw = $this->_db->query("SELECT * FROM news WHERE userid = ? AND groupid = ? AND archive = ? ORDER BY deadline ASC, date DESC", array(0, 0, 0));
		// -----------------------
		return $counter + $allnw->count();
	}
	
	/*## ARHIIV ##*/
	public function getArchiveCount() {
		$query = $this->_db->query("SELECT * FROM news WHERE archive = ?", array(1));
		if($query->count())	{
			$data = $query->results();
			return $data;
		}
		return false;
	}
	
	public function getArchiveData() {
		$query = $this->_db->query("SELECT * FROM news WHERE archive = ? ORDER BY deadline ASC, date DESC", array(1));
		if($query->count())	{
			$data = $query->results();
			return $data;
		}
		return false;
	}
	
	public function archiveStatus($status) {
		$query = $this->_db->query("UPDATE news SET archive = ? WHERE  id = ?", array(1, $status));
	}
	
	public function restoreArchive($status) {
		$query = $this->_db->query("UPDATE news SET archive = ? WHERE  id = ?", array(0, $status));
	}
	
	public function deleteArchive($status) {
		$query = $this->_db->query("UPDATE news SET archive = ? WHERE  id = ?", array(2, $status));
	}
	
	//Task Complete
	public function taskComplete($task_id, $type) {
		$query = $this->_db->query("UPDATE news SET completed = ? WHERE id = ?", array($type, $task_id));
	}
	
	
	//Inline_Editi jaoks
	public function updateNews($id, $column, $value, $editor) {
		$query = $this->_db->query("UPDATE news SET {$column} = ?, edited_by = ? WHERE id = ?", array($value, $editor, $id));
		if($query) {
			return true;
		}
		return false;
	}
	
	// Clean
	public function cleanNews() {
		$times = time();
		$query = $this->_db->query("UPDATE news SET archive = ? WHERE archive = ? AND completed = ? AND deadline < ?", array(1,0,2,$times));
		if($query) {
			return true;
		}
		return false;
	}
	
	public function getDone() {
		$query = $this->_db->get('news', array('completed', '=', 1));
		if($query->count())	{
			$data = $query->results();
			return $data;
		}
		return false;
	}
	
	public function getDoneCount() {
		$query = $this->_db->get('news', array('completed', '=', 1));
		return $query->count();
	}

}
?>