<?php
class home extends Controller {
	public function index(){
		$menuModel = $this->loadModel("menu_model");
		$chooseMenu = $menuModel->getChooseMenu();
		include 'app/views/header.php';
		include 'app/views/home.php';
		include 'app/views/footer.php';
	}
}
?>