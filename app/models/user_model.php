<?php
class user_model {
	function __construct($db) {
		try {
			$this->db = $db;
		} catch (PDOException $e) {
			exit('데이터베이스 연결에 오류가 발생했습니다.');
		}
	}

	//이메일 중복체크
	public function emailCheck($uid){
		$sql = "SELECT count(*) FROM user WHERE user_id='".$uid."'";
		$query = $this->db->prepare($sql);
		$query->execute();
		if($query->fetchColumn() > 0) return 0;

		return 1;
	}

	//유저정보 가져오기
	public function getUser($uid){
		$sql = "SELECT * FROM user WHERE user_id='".$uid."'";
		$query = $this->db->prepare($sql);
		$query->execute();
		return $query->fetch();
	}

	//회원가입
	public function signup($uid, $upw, $upw2, $uname){
		$uid = preg_replace("/\s+/", "", strip_tags($uid));
		$hashupw = password_hash(md5($upw), PASSWORD_BCRYPT);
		$uname = preg_replace("/\s+/", "", strip_tags($uname));

		if($upw != $upw2) alertmove('입력하신 비밀번호와 비밀번호확인이 달라요!');
		if($this->emailCheck($uid) == 0) alertmove('가입된 이메일이 있습니다');

		$sql = "INSERT INTO user (user_id, user_pw, user_name) VALUES (:user_id, :user_pw, :user_name)";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_id' => $uid, ':user_pw' => $hashupw, ':user_name' => $uname));

		movepage("/user/login");
	}

	//로그인
	public function login($uid, $upw){
		$uid = preg_replace("/\s+/", "", strip_tags($uid));
		$user = $this->getUser($uid);
		if(password_verify(md5($upw), $user->user_pw)){
			$_SESSION['loginId'] = $user->user_id;
			$_SESSION['loginName'] = $user->user_name;
			$_SESSION['loginIdx'] = $user->idx;
			movepage('/');
		} else {
			alertmove('아이디 또는 비밀번호가 달라요');
		}
	}
}
?>