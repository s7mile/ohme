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

	public function getTodayMenu($teamIdx){
		$sql = "SELECT m.menu_name, m.menu_img FROM menu m LEFT JOIN visit v ON m.idx=v.menu_idx where v.team_idx=:team_idx and date(v.date) = date(now()) order by v.idx desc";
		$query = $this->db->prepare($sql);
		$query->execute(array(':team_idx' => $teamIdx));
		if($todayMenu = $query->fetch())
			return $todayMenu;

		return false;
	}

	public function getChooseMenuIdx($team_idx){
		$menu = array();

		$sql = "SELECT menus FROM choose WHERE user_idx = :user_idx and date(final_date) = date(now()) and team_idx=:team_idx";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_idx' => $_SESSION['loginIdx'], ':team_idx' => $team_idx));
		$chooseMenu = $query->fetchAll(PDO::FETCH_ASSOC);

		foreach ($chooseMenu as $val) {
			$menu[] = $val['menus'];
		}
		return $menu;
	}

	public function getChooseMenu($team_idx){
		$chooseMenu = $this->getChooseMenuIdx($team_idx);
		if(isset($chooseMenu)){
			$sql = "SELECT idx, menu_name, menu_tag FROM menu WHERE idx IN (".$chooseMenus.")";
			$query = $this->db->prepare($sql);
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}

		return false;
	}

	public function getAllChooseMenuData($team_idx){
		$menu['menus'] = array();
		$menu['user'] = array();
		$sql = "SELECT c.menus, c.user_idx, u.user_id, u.user_name, u.user_profile_name FROM choose c LEFT JOIN user u ON c.user_idx=u.idx WHERE team_idx = :team_idx and date(final_date) = date(now())";
		$query = $this->db->prepare($sql);
		$query->execute(array(':team_idx' => $team_idx));
		$menus = $query->fetchAll(PDO::FETCH_ASSOC);
		if(!empty($menus)){
			foreach ($menus as $val) {
				//유저목록
				if( !isset($menu['user'][$val['menus']]) )
					$menu['user'][$val['menus']] = array();

				//메뉴
				if(!in_array($val['menus'], $menu['menus']))
					$menu['menus'][] = $val['menus'];

				//메뉴선택한유저
				$menu['user'][$val['menus']][] = array('id'=>$val['user_id'], 'name'=>$val['user_name'], 'img'=>$val['user_profile_name']);
			}
			return $menu;
		}
		return false;
	}

	public function getAllChooseMenu($team_idx){
		$chooseMenu = $this->getAllChooseMenuData($team_idx);
		if($chooseMenu != false){
			$chooseMenus = implode(", ", $chooseMenu['menus']);
			$sql = "SELECT idx, menu_name, menu_tag, menu_img FROM menu WHERE idx IN (".$chooseMenus.")";
			$query = $this->db->prepare($sql);
			$query->execute();
			$result[0] = $query->fetchAll(PDO::FETCH_ASSOC);
			$result[1] = $chooseMenu['user'];

			return $result;
		}

		return false;
	}

	public function addMenu($name, $tag, $team){
		$name = preg_replace("/\s+/", "", strip_tags($name));
		$tag = preg_replace("/\s+/", "", strip_tags($tag));

		$sql = "INSERT INTO menu (menu_name, menu_tag, team_idx) VALUES (:menu_name, :menu_tag, :team_idx)";
		$query = $this->db->prepare($sql);
		$query->execute(array(':menu_name' => $name, ':menu_tag' => $tag, ':team_idx' => $team));
	}

	public function chooseMenu($menus, $team){
		//오늘 처음 메뉴 등록
		$sql = "INSERT INTO choose (user_idx, menus, final_date, team_idx) VALUES (:user_idx, :menus, :final_date, :team_idx)";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_idx' => $_SESSION['loginIdx'], ':menus' => $menus, ':final_date' => date("Y-m-d H:i:s", time()),  ':team_idx' => $team));
	}

	public function cancelMenu($menus, $team){
		$sql = "DELETE FROM choose where user_idx = :user_idx and date(final_date) = date(now()) and menus=:menus and team_idx = :team_idx";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_idx' => $_SESSION['loginIdx'], ':menus' => $menus, ':team_idx' => $team));
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