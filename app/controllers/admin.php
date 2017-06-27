<?php
class Admin extends Controller {
	public function index(){
		include 'app/views/header_admin.php';
		include 'app/views/admin.php';
		include 'app/views/footer.php';
	}

	public function add(){
		include 'app/views/header_admin.php';
		include 'app/views/admin_form.php';
		include 'app/views/footer.php';
	}
}
?>