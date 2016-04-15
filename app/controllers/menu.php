<?php
class Menu extends Controller {
	public function index(){
		$menuModel = $this->loadModel("menu_model");
		$menuList = $menuModel->getMenu();
		$chooseMenu = $menuModel->getChooseMenuIdx();

		include 'app/views/header.php';
		include 'app/views/menu.php';
		include 'app/views/footer.php';
	}

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