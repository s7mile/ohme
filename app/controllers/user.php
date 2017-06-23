<?php
class User extends Controller {
	public function index(){}

	public function team(){
		sessionChk("로그인 후 이용가능해요!", "/login");

		$teamModel = $this->loadModel("team_model");
		$teamList = $teamModel->getMyTeam();
		
		$li_1 = ' class="sel"';
		$li_2 = '';

		include 'app/views/header2.php';
		include 'app/views/team.php';
		include 'app/views/footer.php';
	}

	public function mypage(){
		sessionChk("로그인 후 이용가능해요!", "/login");
		
		$teamModel = $this->loadModel("team_model");
		$teamList = $teamModel->getMyTeam();

		$userModel = $this->loadModel("user_model");
		$userInfo = $userModel->getUser($_SESSION['loginId']);
		
		$li_1 = '';
		$li_2 = ' class="sel"';

		$userProfileLink = userProfile($_SESSION['loginId'], $userInfo->user_profile_name, 1);

		include 'app/views/header2.php';
		include 'app/views/mypage.php';
		include 'app/views/footer.php';
	}

	public function add(){
		sessionChk("잘못된 접근이에요!", "/");
		
		$teamModel = $this->loadModel("team_model");
		$teamModel->addTeam($_POST['name'], $_POST['desc']);
	}

	public function signup(){
		$userModel = $this->loadModel("user_model");
		$userModel->signup($_POST['userId'], $_POST['userPw'], $_POST['userPw2'], $_POST['userName']);
	}

	public function login(){
		$userModel = $this->loadModel("user_model");
		$userModel->login($_POST['userId'], $_POST['userPw']);
	}

	public function logout(){
		session_destroy();
		movepage('/');
	}

	public function uiu(){
<<<<<<< HEAD
		sessionChk("잘못된 접근이에요!", "/");
		
=======
		$nowPw = "";
		$newPw = "";
		$newPw2 = "";

		$nowPw = $_POST['nowPw'];
		$newPw = $_POST['newPw'];
		$newPw2 = $_POST['newPw2'];

		if($nowPw == ""){
			$res["result"] = false;
			$res["result_msg"] = "현재 비밀번호를 작성해주세요!";
			$res["target"] = "nowPw";
			echo json_encode($res);
			exit();
		}else if($newPw == ""){
			$res["result"] = false;
			$res["result_msg"] = "새로운 비밀번호를 작성해주세요!";
			$res["target"] = "newPw";
			echo json_encode($res);
			exit();
		}else if($newPw2 == ""){
			$res["result"] = false;
			$res["result_msg"] = "새로운 비밀번호 확인을 작성해주세요!";
			$res["target"] = "newPw2";
			echo json_encode($res);
			exit();
		}

		if($newPw != $newPw2){
			$res["result"] = false;
			$res["result_msg"] = "입력하신 새로운 비밀번호와 새로운 비밀번호확인이 달라요!";
			$res["target"] = "newPw";
			echo json_encode($res);
			exit();
		}

>>>>>>> fa3efbb5f3a0cdcb5593a8d70c70a1195817e5f6
		$userModel = $this->loadModel("user_model");
		if( $userModel->passwordUpdate($nowPw, $newPw, $newPw2) ){
			$res["result"] = true;
			$res["result_msg"] = "비밀번호가 변경되었어요!";
			echo json_encode($res);
		}else{
			$res["result"] = false;
			$res["result_msg"] = "현재 비밀번호를 다르게 입력하셨어요!";
			$res["target"] = "nowPw";
			echo json_encode($res);
			exit();
		}
	}

	public function profileUpdate(){
		sessionChk("잘못된 접근이에요!", "/");
		
		$file = $_FILES['profile'];
		if($file_name = fileChk($file, "img")){
			thumbImg($file_name, "./data/member/".md5($_SESSION['loginId']).'/', "200", "200");
		}
		$userModel = $this->loadModel("user_model");
		$userModel->profileUpdate($file['name'], $file_name);

		movepage();
	}
}
?>