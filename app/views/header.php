<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<title>오늘의 메뉴</title>
	<link rel="stylesheet" href="/public/css/common.css">
	<script type="text/javascript" src="/public/js/jquery.min.js"></script>
	<script type="text/javascript" src="/public/js/common.js"></script>
</head>
<?php if(isset($home)){?>
<body id="main">
<?php }else{?>
<body>
<?php }?>
	<header id="header1">
		<div>
			<h1><img src="/public/img/logo_white.png" alt="오늘의 메뉴"></h1>
			<nav>
				<ul>
					<li><a href="/">홈</a></li>
					<li><a href="/menu">메뉴판</a></li>
					<li><a href="/rank">랭킹</a></li>
				</ul>
			</nav>
			<?php if( !isset($_SESSION["loginId"]) ){ ?>
			<a href="/login" class="button white" id="loginBtn">로그인</a>
			<?php }else{ ?>
			<a href="javascript:;" class="userInfo">
				<p><?= $_SESSION['loginName']?></p>
				<span>프로필사진</span>
			</a>
			<ul class="user dropDown right">
				<li><span><?= $_SESSION['loginName']?>님</span></li>
				<li><a href="/user/mypage">마이페이지</a></li>
				<li><a href="/user/logout">로그아웃</a></li>
			</ul>
			<?php } ?>
		</div>
	</header>
	<section>