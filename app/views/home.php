<article id="selectMenu">
	<h3>오늘의 메뉴</h3>
	<!-- <p>
		<img src="https://s-media-cache-ak0.pinimg.com/564x/18/cf/68/18cf68b92f8bd545d61d57fdec4bb555.jpg" alt="">
		<span>샌드위치</span>
	</p> -->
	<a href="javascript:;">오늘의 메뉴를 뽑아주세요!</a>
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
	<ul class="tab">
		<li class="sel"><a href="javascript:;">나의 선택</a></li>
		<li><a href="javascript:;">팀원들의 선택</a></li>
	</ul>

	<article id="myMenu">
		<h2>내가 고른 메뉴</h2>
		<ul class="menuList">
			<?php
			if($chooseMenu == false){
			?>
			<li>
				오늘의 메뉴를 선택해주세요!
			</li>
			<?php
			}else{
				foreach($chooseMenu as $menu){
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
	</article>
	<article id="teamMenu">
		<h2>팀원들의 메뉴</h2>
		<div>
			<ul>
				<li>냠냠</li>
			</ul>
		</div>
	</article>
</div>

<?php
	include "app/views/roulette.php";
?>