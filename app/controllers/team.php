<?php
class team extends Controller {
	public function index($team_url){
		$home = 1;
		$menuModel = $this->loadModel("menu_model");
		$chooseMenu = $menuModel->getChooseMenu();
		include 'app/views/header.php';
		include 'app/views/home.php';
		include 'app/views/footer.php';
	}

	public function menu($team_url){
		$teamModel = $this->loadModel("team_model");
		$teamIdx = $teamModel->getTeamIdx($team_url);

		$menuModel = $this->loadModel("menu_model");
		$menuList = $menuModel->getMenu($teamIdx);
		$chooseMenu = $menuModel->getChooseMenuIdx();

		include 'app/views/header.php';
		include 'app/views/menu.php';
		include 'app/views/footer.php';
	}

	public function setting($team_url){
		$teamModel = $this->loadModel("team_model");
		$teamInfo = $teamModel->getTeamInfo($team_url);
		include 'app/views/header.php';
		include 'app/views/team_setting.php';
		include 'app/views/footer.php';
	}

	public function add(){
		$teamModel = $this->loadModel("team_model");
		$teamModel->addTeam($_POST['name'], $_POST['desc'], $_POST['url']);
	}
}
?>