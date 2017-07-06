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
		$sql = "SELECT idx, menu_name, menu_tag, menu_img FROM menu where team_idx=:team_idx";
		$query = $this->db->prepare($sql);
		$query->execute(array(':team_idx' => $teamIdx));
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getMenuIdx($menu_name){
		$sql = "SELECT idx FROM menu where menu_name=:menu_name";
		$query = $this->db->prepare($sql);
		$query->execute(array(':menu_name' => $menu_name));
		return $query->fetch()->idx;
	}

	public function getNearMenu($x, $y){
		$sql = "SELECT idx, menu_name, menu_tag, menu_img ( 6371 * acos( cos( radians(:y) ) * cos( radians( menu_x ) ) * cos( radians( menu_y ) - radians(:x) ) + sin( radians(:y) ) * sin( radians( menu_x ) ) ) ) AS distance FROM menu WHERE team_idx='0' HAVING distance < 5 ORDER BY distance";
		$query = $this->db->prepare($sql);
		$query->execute(array(':x' => $x, ':y' => $y));
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getTodayMenu($teamIdx){
		$sql = "SELECT m.menu_name, m.menu_img FROM menu m LEFT JOIN visit v ON m.idx=v.menu_idx where v.team_idx=:team_idx and date(v.date) = date(now()) order by v.idx desc";
		$query = $this->db->prepare($sql);
		$query->execute(array(':team_idx' => $teamIdx));
		if($todayMenu = $query->fetch())
			return $todayMenu;

		return false;
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

	public function getAllChooseMenuIdx($team_idx){
		$sql = "SELECT menus FROM choose WHERE team_idx = :team_idx and date(final_date) = date(now())";
		$query = $this->db->prepare($sql);
		$query->execute(array(':team_idx' => $team_idx));
		if($menus = $query->fetchAll(PDO::FETCH_ASSOC)){
			$menu = '';
			foreach($menus as $a){
				$menu .= $a['menus'];
			}

			return array_unique(explode(',', $menu));
		}

		return false;
	}

	public function getAllChooseMenu($team_idx){
		$chooseMenu = $this->getAllChooseMenuIdx($team_idx);
		if($chooseMenu !== false){
			array_pop($chooseMenu);
			$chooseMenus = implode(", ", $chooseMenu);

			$sql = "SELECT menu_name, menu_tag, menu_img FROM menu WHERE idx IN (".$chooseMenus.")";
			$query = $this->db->prepare($sql);
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}

		return false;
	}

	// public function getAllChooseMenuIdx(){
	// 	$sql = "SELECT menus FROM choose WHERE team_idx = :team_idx and date(final_date) = date(now())";
	// 	$query = $this->db->prepare($sql);
	// 	$query->execute(array(':team_idx' => $_SESSION['teamIdx']));
	// 	return explode(',', $query->fetchAll()->menus);
	// }

	// public function getAllChooseMenu(){
	// 	$chooseMenu = $this->getChooseMenuIdx();
	// 	array_pop($chooseMenu);
	// 	$chooseMenus = implode(", ", $chooseMenu);

	// 	$sql = "SELECT idx, menu_name, menu_tag FROM menu WHERE idx IN (".$chooseMenus.")";
	// 	$query = $this->db->prepare($sql);
	// 	$query->execute();
	// 	return $query->fetchAll(PDO::FETCH_ASSOC);
	// }

	public function addMenu($data){
		$data['menu'] = preg_replace("/\s+/", "", strip_tags($data['name']));
		$data['tag'] = preg_replace("/\s+/", "", strip_tags($data['tag']));

		$sql = "INSERT INTO menu (menu_name, menu_tag, team_idx, menu_x, menu_y, menu_address) VALUES (:menu_name, :menu_tag, :team_idx, :menu_x, :menu_y, :menu_address)";
		$query = $this->db->prepare($sql);
		$query->execute(array(':menu_name' => $data['name'], ':menu_tag' => $data['tag'], ':team_idx' => $data['team'], ':menu_x' => $data['x'], ':menu_y' => $data['y'], ':menu_address' => $data['address']));
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

	public function selectMenu($menu, $team_idx){
		$menu = preg_replace("/\s+/", "", strip_tags($menu));
		$date = date('Y-m-d h:i:s');

		$menu_idx = $this->getMenuIdx($menu);

		$sql = "INSERT INTO visit (menu_idx, date, team_idx) VALUES (:menu_idx, :date, :team_idx)";
		$query = $this->db->prepare($sql);
		$query->execute(array(':menu_idx' => $menu_idx, ':date' => $date, ':team_idx' => $team_idx));
	}
}
?>