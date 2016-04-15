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
		$sql = "SELECT * FROM team";
		$query = $this->db->prepare($sql);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function addTeam($name, $desc, $url){
		$name = preg_replace("/\s+/", "", strip_tags($name));
		$desc = preg_replace("/\s+/", "", strip_tags($desc));
		$date = date("Y-m-d h:i:s");
		$url = preg_replace("/\s+/", "", strip_tags($url));

		$sql = "INSERT INTO team (team_name, team_desc, team_date, team_url) VALUES (:team_name, :team_desc, :team_date, :team_url)";
		$query = $this->db->prepare($sql);
		$query->execute(array(':team_name' => $name, ':team_desc' => $desc, ':team_date' => $date, ':team_url' => $url));
	}
}
?>