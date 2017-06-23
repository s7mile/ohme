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
		$sql = "SELECT count(*) FROM user WHERE user_id=:user_id";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_id' => $uid));
		if($query->fetchColumn() > 0) return 0;

		return 1;
	}

	//유저정보 가져오기
	public function getUser($uid){
		$sql = "SELECT * FROM user WHERE user_id=:user_id OR idx=:idx limit 1";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_id' => $uid, ':idx' => $uid));
		return $query->fetch();
	}

	public function getUserIdx($uid){
		$sql = "SELECT idx FROM user WHERE user_id=:user_id limit 1";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_id' => $uid));
		if($query->fetch()) return $query->fetch()->idx;
		else return -1;
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

		movepage("/login");
	}

	//로그인
	public function login($uid="", $upw=""){
		$uid = preg_replace("/\s+/", "", strip_tags($uid));
		$user = $this->getUser($uid);
		if($user == ""){alertmove("가입되지 않은 아이디에요");}
		if(password_verify(md5($upw), $user->user_pw)){
			$_SESSION['loginId'] = $user->user_id;
			$_SESSION['loginName'] = $user->user_name;
			$_SESSION['loginIdx'] = $user->idx;
			movepage('/user/team');
		} else {
			alertmove('비밀번호가 달라요');
		}
	}

	//마이페이지
	public function passwordUpdate($nowpw="", $newpw="", $newpw2=""){
		$hash_newpw = password_hash(md5($newpw), PASSWORD_BCRYPT);
		$user = $this->getUser($_SESSION['loginId']);

		if(password_verify(md5($nowpw), $user->user_pw)){
			$sql = "UPDATE user SET user_pw=:user_pw WHERE idx=:idx";
			$query = $this->db->prepare($sql);
<<<<<<< HEAD
			$query->execute(array(':user_pw' => $hash_newpw, ':idx' => $_SESSION['loginIdx']));
=======
			$query->execute(array(':user_pw' => $hash_newpw));

			return 1;
>>>>>>> fa3efbb5f3a0cdcb5593a8d70c70a1195817e5f6
		}else{
			return 0;
		}

		
	}

	//마이페이지
	public function profileUpdate($file_org, $file_new){
		$sql = "UPDATE user SET user_profile=:user_profile, user_profile_name=:user_profile_name WHERE idx=:idx";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_profile' => $file_org, ':user_profile_name' => $file_new, ':idx' => $_SESSION['loginIdx']));
	}
}
?>