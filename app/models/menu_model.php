<?php
class menu_model {
	function __construct($db) {
		try {
			$this->db = $db;
		} catch (PDOException $e) {
			exit('데이터베이스 연결에 오류가 발생했습니다.');
		}
	}
 
	public function getMenu($teamIdx){
		$sql = "SELECT idx, menu_name, menu_tag FROM menu where team_idx=:team_idx";
		$query = $this->db->prepare($sql);
		$query->execute(array(':team_idx' => $teamIdx));
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getChooseMenuIdx(){
		$sql = "SELECT menus FROM choose WHERE user_idx = :user_idx and date(final_date) = date(now())";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_idx' => $_SESSION['loginIdx']));
		if($menus = $query->fetch()){
			return explode(',', $menus->menus);
		}

		return false;
	}

	public function getChooseMenu(){
		$chooseMenu = $this->getChooseMenuIdx();
		if($chooseMenu !== false){
			array_pop($chooseMenu);
			$chooseMenus = implode(", ", $chooseMenu);

			$sql = "SELECT idx, menu_name, menu_tag FROM menu WHERE idx IN (".$chooseMenus.")";
			$query = $this->db->prepare($sql);
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}

		return false;
	}

	public function getAllChooseMenuIdx(){
		$sql = "SELECT menus FROM choose WHERE team_idx = :team_idx and date(final_date) = date(now())";
		$query = $this->db->prepare($sql);
		$query->execute(array(':team_idx' => $_SESSION['teamIdx']));
		return explode(',', $query->fetchAll()->menus);
	}

	public function getAllChooseMenu(){
		$chooseMenu = $this->getChooseMenuIdx();
		array_pop($chooseMenu);
		$chooseMenus = implode(", ", $chooseMenu);

		$sql = "SELECT idx, menu_name, menu_tag FROM menu WHERE idx IN (".$chooseMenus.")";
		$query = $this->db->prepare($sql);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}


	public function addMenu($name, $tag, $team){
		$name = preg_replace("/\s+/", "", strip_tags($name));
		$tag = preg_replace("/\s+/", "", strip_tags($tag));

		$sql = "INSERT INTO menu (menu_name, menu_tag, team_idx) VALUES (:menu_name, :menu_tag, :team_idx)";
		$query = $this->db->prepare($sql);
		$query->execute(array(':menu_name' => $name, ':menu_tag' => $tag, ':team_idx' => $team));
	}

	public function chooseMenu($menus, $team){
		$menus = $menus.',';
		//오늘날짜에 선택한 것들이 있는지
		$sql = "SELECT count(*) FROM choose WHERE user_idx = :user_idx and date(final_date) = date(now())";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_idx' => $_SESSION['loginIdx']));
		if($query->fetchColumn() > 0){
			//이미 오늘의 메뉴가 등록되어있는 경우
			$sql = "UPDATE choose SET menus = CONCAT(menus, :menus), final_date = :final_date where user_idx = :user_idx and date(final_date) = date(now()) and team_idx = :team_idx";
			$query = $this->db->prepare($sql);
			$query->execute(array(':menus' => $menus, ':final_date' => date("Y-m-d H:i:s", time()),  ':user_idx' => $_SESSION['loginIdx'], ':team_idx' => $team));
		}else{
			//오늘 처음 메뉴 등록
			$sql = "INSERT INTO choose (user_idx, menus, final_date, team_idx) VALUES (:user_idx, :menus, :final_date, :team_idx)";
			$query = $this->db->prepare($sql);
			$query->execute(array(':user_idx' => $_SESSION['loginIdx'], ':menus' => $menus, ':final_date' => date("Y-m-d H:i:s", time()),  ':team_idx' => $team));
		}
	}

	public function cancelMenu($menus, $team){
		$menus = $menus.',';
		$sql = "UPDATE choose SET menus = REPLACE(menus, :menus, ''), final_date = :final_date where user_idx = :user_idx and date(final_date) = date(now()) and team_idx = :team_idx";
		$query = $this->db->prepare($sql);
		$query->execute(array(':menus' => $menus, ':final_date' => date("Y-m-d H:i:s", time()),  ':user_idx' => $_SESSION['loginIdx'], ':team_idx' => $team));
	}
}
?>