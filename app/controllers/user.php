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
		sessionChk("잘못된 접근이에요!", "/");
		
		$userModel = $this->loadModel("user_model");
		$userModel->passwordUpdate($_POST['nowPw'], $_POST['newPw'], $_POST['newPw2']);
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