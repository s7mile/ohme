<?php
class Application {
	private $controller = null;
	private $action = null;

	public function __construct(){
		$cancontroll = false;
		$url = "";
		if(isset($_GET['url'])){
			$url = rtrim($_GET['url'], '/');
			$url = filter_var($url, FILTER_SANITIZE_URL);
		}
		$params = explode('/', $url);
		$counts = count($params);
		$this->controller = "main";
		$this->action = "index";

		if(isset($params[0])){
			if($params[0]) $this->controller = $params[0];
		}
		if(file_exists('./app/controllers/'.$this->controller.'.php')){
			include './app/controllers/'.$this->controller.'.php';
			$this->controller = new $this->controller();

			if(isset($params[1])){
				if($params[1]) $this->action = $params[1];
			}
			if(method_exists($this->controller, $this->action)){ //method_exists -> 클래스 안에 메소드가 선언되어있는지 확인하는 함수(객체변수, 메소드이름)
				$cancontroll = true;
				switch($counts){
					case '0':
					case '1':
					case '2':
						$this->controller->{$this->action}();
					break;
					case '3':
						$this->controller->{$this->action}($params[2]);
					break;
					case '4':
						$this->controller->{$this->action}($params[2], $params[3]);
					break;
					case '5':
						$this->controller->{$this->action}($params[2], $params[3], $params[4]);
					break;
				}
			}
		}else{
			include './app/controllers/team.php';
			$this->controller = "team";
			$this->controller = new $this->controller();

			if(isset($params[1])){
				if($params[1]) $this->action = $params[1];
			}
			if(method_exists($this->controller, $this->action)){
				$cancontroll = true;
				switch($counts){
					case '0':
					case '1':
					case '2':
						$this->controller->{$this->action}($params[0]);
					break;
					case '3':
						$this->controller->{$this->action}($params[2]);
					break;
					case '4':
						$this->controller->{$this->action}($params[2], $params[3]);
					break;
					case '5':
						$this->controller->{$this->action}($params[2], $params[3], $params[4]);
					break;
				}
			}
		}

		if($cancontroll == false){
			echo "잘못된 접근데스네!";
		}
	}
}
?>