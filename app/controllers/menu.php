<?php
class Menu extends Controller {
	public function add(){
		$menuModel = $this->loadModel("menu_model");
		$menuModel->addMenu($_POST['name'], $_POST['tag'], $_POST['team_idx']);
	}

	public function choose(){
		$menuModel = $this->loadModel("menu_model");
		$menuModel->chooseMenu($_POST['menuIdx']);
	}

	public function cancel(){
		$menuModel = $this->loadModel("menu_model");
		$menuModel->cancelMenu($_POST['menuIdx']);
	}
}
?>