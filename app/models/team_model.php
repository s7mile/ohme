<?php
class team_model {
	function __construct($db) {
		try {
			$this->db = $db;
		} catch (PDOException $e) {
			exit('데이터베이스 연결에 오류가 발생했습니다.');
		}
	}
 
	public function getMyTeam(){
		$sql = "SELECT t.team_name, t.team_desc, t.team_url, u.user_idx, u.team_idx, u.join_date, u.status, (SELECT COUNT(*) FROM user_team where team_idx=u.team_idx) as c FROM team t LEFT JOIN user_team u ON t.idx=u.team_idx WHERE u.user_idx=:user_idx order by u.status asc, u.join_date asc";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_idx' => $_SESSION['loginIdx']));
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getTeamInfo($team_url){
		$sql = "SELECT * FROM team WHERE team_url=:team_url";
		$query = $this->db->prepare($sql);
		$query->execute(array(':team_url' => $team_url));
		return $query->fetch();
	}

	public function getTeamIdx($team_url){
		$sql = "SELECT idx FROM team WHERE team_url=:team_url";
		$query = $this->db->prepare($sql);
		$query->execute(array(':team_url' => $team_url));
		return $query->fetch()->idx;
	}

	public function getLatelyChooseDate($user_idx){
		$sql = "SELECT final_date FROM choose WHERE user_idx=:user_idx order by final_date desc limit 1";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_idx' => $user_idx));
		return $query->fetch()->final_date;
	}

	public function getMemberList($team_idx){
		$sql = "SELECT t.user_idx, t.team_idx, t.join_date, t.status, u.user_id, u.user_name, u.user_profile, (SELECT final_date FROM choose where team_idx=t.team_idx and user_idx=u.idx ORDER BY final_date DESC LIMIT 1) as final_date FROM user_team t LEFT JOIN user u ON t.user_idx=u.idx WHERE t.team_idx=:team_idx order by t.status desc, t.join_date asc";
		$query = $this->db->prepare($sql);
		$query->execute(array(':team_idx' => $team_idx));
		$memberList = $query->fetchAll();
		return $memberList;
	}

	public function inviteTeam($user_idx, $team_url, $status=0){
		$team_url = preg_replace("/\s+/", "", strip_tags($team_url));
		$team_idx = $this->getTeamIdx($team_url);

		$sql = "INSERT INTO user_team (user_idx, team_idx, join_date, status) VALUES (:user_idx, :team_idx, now(), :status)";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_idx' => $user_idx, ':team_idx' => $team_idx, 'status' => $status));
	}

	public function inviteAgree($user_idx, $team_url){
		$team_url = preg_replace("/\s+/", "", strip_tags($team_url));
		$team_idx = $this->getTeamIdx($team_url);

		$sql = "UPDATE user_team set status='1' where user_idx=:user_idx and team_idx=:team_idx";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_idx' => $user_idx, ':team_idx' => $team_idx));
	}

	public function addTeam($name, $desc, $url, $user_idx){
		$name = preg_replace("/\s+/", "", strip_tags($name));
		$desc = preg_replace("/\s+/", "", strip_tags($desc));
		$url = preg_replace("/\s+/", "", strip_tags($url));

		//팀정보 추가
		$sql = "INSERT INTO team (team_name, team_desc, team_date, team_url) VALUES (:team_name, :team_desc, now(), :team_url)";
		$query = $this->db->prepare($sql);
		$query->execute(array(':team_name' => $name, ':team_desc' => $desc, ':team_url' => $url));

		//팀에 멤버추가
		$this->inviteTeam($user_idx, $url, 1);
	}
}
?>