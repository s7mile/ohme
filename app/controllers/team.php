<?php
class team extends Controller {
	public function index($team_url){
		$home = 1;
		$menuModel = $this->loadModel("menu_model");
		$teamModel = $this->loadModel("team_model");

		$teamInfo = $teamModel->getTeamInfo($team_url);
		$todayMenu = $menuModel->getTodayMenu($teamInfo->idx);
		$roulMenu = $menuModel->getAllChooseMenu($teamInfo->idx);

		include 'app/views/header.php';
		include 'app/views/home.php';
		include 'app/views/footer.php';
	}

	public function menu($team_url){
		$teamModel = $this->loadModel("team_model");
		$menuModel = $this->loadModel("menu_model");

		$teamInfo = $teamModel->getTeamInfo($team_url);
		$menuList = $menuModel->getMenu($teamInfo->idx);
		$chooseMenu = $menuModel->getChooseMenuIdx();

		include 'app/views/header.php';
		include 'app/views/menu.php';
		include 'app/views/footer.php';
	}

	public function setting($team_url){
		$teamModel = $this->loadModel("team_model");
		$teamInfo = $teamModel->getTeamInfo($team_url);
		$memberList = $teamModel->getMemberList($teamInfo->idx);

		include 'app/views/header.php';
		include 'app/views/team_setting.php';
		include 'app/views/footer.php';
	}

	public function rank($team_url){
		$teamModel = $this->loadModel("team_model");
		$teamInfo = $teamModel->getTeamInfo($team_url);

		include 'app/views/header.php';
		include 'app/views/rank.php';
		include 'app/views/footer.php';
	}

	public function add(){
		$teamModel = $this->loadModel("team_model");
		$teamModel->addTeam($_POST['name'], $_POST['desc'], $_POST['url'], $_SESSION['loginIdx']);
	}

	public function invite(){
		$userModel = $this->loadModel("user_model");
		$user_idx = $userModel->getUserIdx($_POST['userid']);

		$teamModel = $this->loadModel("team_model");
		$teamModel->inviteTeam($user_idx, $_POST['team']);
	}

	public function invite_agree(){
		$teamModel = $this->loadModel("team_model");
		$teamModel->inviteAgree($_SESSION['loginIdx'], $_POST['team']);
	}
}
?>