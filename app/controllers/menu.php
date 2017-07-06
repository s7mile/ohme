<?php
class Menu extends Controller {
	public function add(){
		if(isset($_POST['team'])){
			$teamModel = $this->loadModel("team_model");
			$teamIdx = $teamModel->getTeamIdx($_POST['team']);
			$data['team'] = $teamIdx;
		}else{
			$data['team'] = 0;
		}
		$menuModel = $this->loadModel("menu_model");

		$data['name'] = $_POST['name'];
		$data['tag'] = $_POST['tag'];
		isset($_POST['x'])? $data['x'] = $_POST['x'] : $data['x'] = 0;
		isset($_POST['y'])? $data['y'] = $_POST['y'] : $data['y'] = 0;
		isset($_POST['address'])? $data['address'] = $_POST['address'] : $data['address'] = "";
		$menuModel->addMenu($data);
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

	public function select(){
		$teamModel = $this->loadModel("team_model");
		$teamIdx = $teamModel->getTeamIdx($_POST['team']);

		$menuModel = $this->loadModel("menu_model");
		$menuModel->selectMenu($_POST['menu'], $teamIdx);
	}
}
?>