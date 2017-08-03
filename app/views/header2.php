<?php
if(isset($home)){
	$body = '<body id="main">';
}else{
	$body = '<body>';
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<title>오늘의 메뉴</title>
	<!-- 모바일 -->
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<!-- 모바일 -->
	<link rel="stylesheet" href="/public/css/common.css">
	<script type="text/javascript" src="/public/js/jquery.min.js"></script>
	<script type="text/javascript" src="/public/js/common.js"></script>
</head>

	<header id="header2">
		<div>
			<h1><img src="/public/img/logo.png" alt="오늘의 메뉴"></h1>
			<a href="javascript:;" class="userInfo">
				<p><?= $_SESSION['loginName']?></p>
				<span>프로필사진</span>
			</a>
			<ul class="user dropDown right">
				<li><span><?= $_SESSION['loginName']?>님</span></li>
				<li><a href="/user/mypage">마이페이지</a></li>
				<li><a href="/user/logout">로그아웃</a></li>
			</ul>

			<ul class="tab2">
				<li<?= $li_1?>><a href="/user/team">팀</a></li>
				<li<?= $li_2?>><a href="/user/mypage">마이페이지</a></li>
			</ul>
		</div>
	</header>
	<section class="userSection">