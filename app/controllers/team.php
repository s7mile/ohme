<?php
class team extends Controller {
	public function index($team_url){
		sessionChk("로그인 후 이용가능해요!", "/login");

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
		sessionChk("로그인 후 이용가능해요!", "/login");

		$teamModel = $this->loadModel("team_model");
		$menuModel = $this->loadModel("menu_model");

		$teamInfo = $teamModel->getTeamInfo($team_url);
		$menuList = $menuModel->getMenu($teamInfo->idx);
		$chooseMenu = $menuModel->getChooseMenuIdx($teamInfo->idx);

		include 'app/views/header.php';
		include 'app/views/menu.php';
		include 'app/views/footer.php';
	}

	public function setting($team_url){
		sessionChk("로그인 후 이용가능해요!", "/login");

		$teamModel = $this->loadModel("team_model");
		$teamInfo = $teamModel->getTeamInfo($team_url);
		$memberList = $teamModel->getMemberList($teamInfo->idx);

		include 'app/views/header.php';
		include 'app/views/team_setting.php';
		include 'app/views/footer.php';
	}

	public function rank($team_url){
		sessionChk("로그인 후 이용가능해요!", "/login");

		$teamModel = $this->loadModel("team_model");
		$teamInfo = $teamModel->getTeamInfo($team_url);

		include 'app/views/header.php';
		include 'app/views/rank.php';
		include 'app/views/footer.php';
	}

	public function add(){
		sessionChk("잘못된 접근이에요!", "/");

		$teamModel = $this->loadModel("team_model");
		$teamModel->addTeam($_POST['name'], $_POST['desc'], $_POST['url'], $_SESSION['loginIdx']);
	}

	public function invite(){
		sessionChk("잘못된 접근이에요!", "/");

		$userModel = $this->loadModel("user_model");
		$user_idx = $userModel->getUserIdx($_POST['userid']);

		if($user_idx == -1) alertmove("입력하신 이메일로 가입된 회원이 없어요");

		$teamModel = $this->loadModel("team_model");
		$teamModel->inviteTeam($user_idx, $_POST['team']);
	}

	public function invite_agree(){
		sessionChk("잘못된 접근이에요!", "/");

		$teamModel = $this->loadModel("team_model");
		$teamModel->inviteAgree($_SESSION['loginIdx'], $_POST['team']);
	}
}
?>