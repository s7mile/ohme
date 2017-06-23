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
<<<<<<< HEAD
		sessionChk("잘못된 접근이에요!", "/");

		$userModel = $this->loadModel("user_model");
		$user_idx = $userModel->getUserIdx($_POST['userid']);

		if($user_idx == -1) alertmove("입력하신 이메일로 가입된 회원이 없어요");

		$teamModel = $this->loadModel("team_model");
		$teamModel->inviteTeam($user_idx, $_POST['team']);
=======
		$userId = "";
		$userId = $_POST['userid'];

		if($userId == ""){
			$res["result"] = false;
			$res["result_msg"] = "초대할 팀원의 이메일을 적어주세요!";
			$res["target"] = "join_user";
			echo json_encode($res);
			exit();
		}else{
			$userModel = $this->loadModel("user_model");
			$user_idx = $userModel->getUserIdx($userId);

			if($user_idx){	
				$teamModel = $this->loadModel("team_model");
				$teamModel->inviteTeam($user_idx, $_POST['team']);
				$res['result'] = true;
				$res['result_msg'] = '초대했어요! 팀원이 동의할 때까지 기다려주세요!';
				echo json_encode($res);
			}else{
				$res['result'] = false;
				$res['result_msg'] = '입력하신 이메일로 가입된 분이 없어요ㅠㅠ';
				$res['target'] = 'join_user';
				echo json_encode($res);
			}
		}


>>>>>>> fa3efbb5f3a0cdcb5593a8d70c70a1195817e5f6
	}

	public function invite_agree(){
		sessionChk("잘못된 접근이에요!", "/");

		$teamModel = $this->loadModel("team_model");
		$teamModel->inviteAgree($_SESSION['loginIdx'], $_POST['team']);
	}
}
?>