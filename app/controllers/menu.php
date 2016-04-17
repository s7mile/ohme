<?php
class Menu extends Controller {
	public function add(){
		$teamModel = $this->loadModel("team_model");
		$teamIdx = $teamModel->getTeamIdx($_POST['team']);

		$menuModel = $this->loadModel("menu_model");
		$menuModel->addMenu($_POST['name'], $_POST['tag'], $teamIdx);
	}

	public function choose(){
		$teamModel = $this->loadModel("team_model");
		$teamIdx = $teamModel->getTeamIdx($_POST['team']);

		$menuModel = $this->loadModel("menu_model");
		$menuModel->chooseMenu($_POST['menuIdx'], $teamIdx);
	}

	public function cancel(){
		$teamModel = $this->loadModel("team_model");
		$teamIdx = $teamModel->getTeamIdx($_POST['team']);

		$menuModel = $this->loadModel("menu_model");
		$menuModel->cancelMenu($_POST['menuIdx'], $teamIdx);
	}
}
?>