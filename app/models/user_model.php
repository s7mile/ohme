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
		$sql = "SELECT count(*) FROM user WHERE user_id=':user_id'";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_id' => $uid));
		if($query->fetchColumn() > 0) return 0;

		return 1;
	}

	//유저정보 가져오기
	public function getUser($uid){
		$sql = "SELECT * FROM user WHERE user_id=:user_id OR idx=:idx";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_id' => $uid, ':idx' => $uid));
		return $query->fetch();
	}

	public function getUserIdx($uid){
		$sql = "SELECT idx FROM user WHERE user_id=:user_id";
		$query = $this->db->prepare($sql);
		$query->execute(array(':user_id' => $uid));
		return $query->fetch()->idx;
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

		if($nowpw == ""){
			$res["result"] = false;
			$res["result_msg"] = "현재 비밀번호를 작성해주세요!";
			$res["target"] = "nowPw";
			echo json_encode($res);
			exit();
		}else if($newpw == ""){
			$res["result"] = false;
			$res["result_msg"] = "새로운 비밀번호를 작성해주세요!";
			$res["target"] = "newPw";
			echo json_encode($res);
			exit();
		}else if($newpw2 == ""){
			$res["result"] = false;
			$res["result_msg"] = "새로운 비밀번호 확인을 작성해주세요!";
			$res["target"] = "newPw2";
			echo json_encode($res);
			exit();
		}

		if($newpw != $newpw2){
			$res["result"] = false;
			$res["result_msg"] = "입력하신 새로운 비밀번호와 새로운 비밀번호확인이 달라요!";
			$res["target"] = "newPw";
			echo json_encode($res);
			exit();
		}

		$user = $this->getUser($_SESSION['loginId']);

		if(password_verify(md5($nowpw), $user->user_pw)){
			$sql = "UPDATE user SET user_pw=:user_pw";
			$query = $this->db->prepare($sql);
			$query->execute(array(':user_pw' => $hash_newpw));

			$res["result"] = true;
			$res["result_msg"] = "비밀번호가 변경되었어요!";
			echo json_encode($res);
		}else{
			$res["result"] = false;
			$res["result_msg"] = "현재 비밀번호를 다르게 입력하셨어요!";
			$res["target"] = "newPw";
			echo json_encode($res);
			exit();
		}

		
	}
}
?>