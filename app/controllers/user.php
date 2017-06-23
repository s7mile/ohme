<?php
class User extends Controller {
	public function index(){}

	public function team(){
		$teamModel = $this->loadModel("team_model");
		$teamList = $teamModel->getMyTeam();
		
		$li_1 = ' class="sel"';
		$li_2 = '';

		include 'app/views/header2.php';
		include 'app/views/team.php';
		include 'app/views/footer.php';
	}

	public function mypage(){
		$teamModel = $this->loadModel("team_model");
		$teamList = $teamModel->getMyTeam();

		$userModel = $this->loadModel("user_model");
		$userInfo = $userModel->getUser($_SESSION['loginId']);
		
		$li_1 = '';
		$li_2 = ' class="sel"';

		include 'app/views/header2.php';
		include 'app/views/mypage.php';
		include 'app/views/footer.php';
	}

	public function add(){
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
		$userModel = $this->loadModel("user_model");
		$userModel->passwordUpdate($_POST['nowPw'], $_POST['newPw'], $_POST['newPw2']);
	}
}
?>