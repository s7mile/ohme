<?php
class User extends Controller {
	public function index(){}

	public function team(){
		$teamModel = $this->loadModel("team_model");
		$teamList = $teamModel->getMyTeam();

		include 'app/views/header2.php';
		include 'app/views/team.php';
		include 'app/views/footer.php';
	}

	public function mypage(){
		$teamModel = $this->loadModel("team_model");
		$teamList = $teamModel->getMyTeam();

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
}
?>