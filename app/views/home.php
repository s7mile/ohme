<?php
	if(isset($roulMenu)){
		include "app/views/roulette.php";
		$openRoul = "javascript:;";
	}else{
		$openRoul = "javascript: alert('아무도 메뉴를 고르지 않았어요');";
	}
?>
<article id="selectMenu">
	<h3>오늘의 메뉴</h3>
	<?php if($todayMenu != false){ ?>
	<a href="javascript:;" class="reChoose">다시 뽑을래요&gt;&gt;</a>
	<p>
		<img src="/data/<?= $todayMenu->menu_img?>" alt="<?= $todayMenu->menu_name?>">
		<span><?= $todayMenu->menu_name?></span>
	</p>
	<?php }else{ ?>
	<a href="<?= $openRoul?>" class="chooseMenu">오늘의 메뉴를 뽑아주세요!</a>
	<?php } ?>
	<input type="hidden" id="team" name="team" value="<?= $team_url?>">
</article>

<ul id="foodList">
	<li></li>
	<li></li>
	<li></li>
	<li></li>
	<li></li>
	<li></li>
	<li></li>
</ul>

<div id="todayMenu">
	<h2>오늘 이거 먹어요!</h2>
	<ul class="menuList">
		<?php
		if($roulMenu == false){
		?>
		<li class="empty">
			오늘 고른 메뉴가 없어요:(
		</li>
		<?php
		}else{
			foreach($roulMenu as $menu){
		?>
		<li>
			<span>
				<?php if($menu['menu_img']){ ?>
				<img src="/data/<?= $menu['menu_img']?>" alt="">
				<?php } ?>
			</span>
			<ul>
				<li><h3><?= $menu['menu_name'] ?></h3></li>
				<li>
					<p class="star"></p>
					<p class="visit">6일전에 방문</p>
				</li>
				<li class="tag">
					<?php
					$tags = explode(",", $menu['menu_tag']);
					foreach($tags as $tag)
						echo '<span>'.$tag.'</span>';
					?>
				</li>
			</ul>
			<ul class="member">
				<?php foreach($roulMenu[1][$menu['idx']] as $member){ ?>
				<li>
					<?php userProfilePrint($member['id'], $member['name'], $member['img']); ?>
					<p><?= $member['name']?></p>
				</li>
				<?php } ?>
			</ul>
		</li>
		<?php
			}
		}
		?>
	</ul>
</div>
<? /*
<div id="todayMenu">
	<h2>오늘 별로 안땡겨요</h2>
	<ul class="menuList">
		<?php
		if($chooseTeamMenu == false){
		?>
		<li class="empty">
			오늘 고른 메뉴가 없어요:(
		</li>
		<?php
		}else{
			foreach($chooseTeamMenu as $menu){
		?>
		<li>
			<span></span>
			<ul>
				<li><h3><?= $menu['menu_name'] ?></h3></li>
				<li>
					<p class="star"></p>
					<p class="visit">6일전에 방문</p>
				</li>
				<li class="tag">
					<?php
					$tags = explode(",", $menu['menu_tag']);
					foreach($tags as $tag)
						echo '<span>'.$tag.'</span>';
					?>
				</li>
			</ul>
		</li>
		<?php
			}
		}
		?>
	</ul>
</div>
*/ ?>