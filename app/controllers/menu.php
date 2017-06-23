<?php
class Menu extends Controller {
	public function add(){
		sessionChk("잘못된 접근이에요!", "/");
		
		$teamModel = $this->loadModel("team_model");
		$teamIdx = $teamModel->getTeamIdx($_POST['team']);

		$menuModel = $this->loadModel("menu_model");
		$menuModel->addMenu($_POST['name'], $_POST['tag'], $teamIdx);
	}

	public function update(){
		sessionChk("잘못된 접근이에요!", "/");

		$menuModel = $this->loadModel("menu_model");
		$menuModel->updateMenu($_POST['name'], $_POST['tag'], $_POST['idx']);
	}

	public function choose(){
		sessionChk("잘못된 접근이에요!", "/");
		
		$teamModel = $this->loadModel("team_model");
		$teamIdx = $teamModel->getTeamIdx($_POST['team']);

		$menuModel = $this->loadModel("menu_model");
		$menuModel->chooseMenu($_POST['menuIdx'], $teamIdx);
	}

	public function cancel(){
		sessionChk("잘못된 접근이에요!", "/");
		
		$teamModel = $this->loadModel("team_model");
		$teamIdx = $teamModel->getTeamIdx($_POST['team']);

		$menuModel = $this->loadModel("menu_model");
		$menuModel->cancelMenu($_POST['menuIdx'], $teamIdx);
	}

	public function select(){
		sessionChk("잘못된 접근이에요!", "/");
		
		$teamModel = $this->loadModel("team_model");
		$teamIdx = $teamModel->getTeamIdx($_POST['team']);

		$menuModel = $this->loadModel("menu_model");
		$menuModel->selectMenu($_POST['menu'], $teamIdx);
	}
}
?>