<p class="buttonArea">
	<!-- <a href="javascript:;" class="button allSel" data-mode="sel">전체선택</a> -->
	<a href="javascript:;" class="button add">맛 좋은 메뉴 추가할래요</a>
</p>
<ul class="menuList" id="menuChoose">
<?php
	foreach($menuList as $menu){
		$sel = '';
		if(isset($chooseMenu))
			if(in_array($menu['idx'], $chooseMenu)) $sel = ' class="sel"';
?>
		<li<?php echo $sel; ?>>
			<a href="javascript:;" class="menu" data-menu="<?= $menu['idx'] ?>">
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
			</a>
			<a href="javascript: alert('메뉴편집은 거부한닷!');" class="other"></a>
		</li>
<?php } ?>
</ul>
<?php
	include "app/views/menu_add.php";
?>