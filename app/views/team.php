<p class="buttonArea">
	<a href="javascript:;" class="button add">팀 추가할래요</a>
</p>
<ul id="teamList">
	<?php foreach($teamList as $team){ ?>
	<li>
		<a href="/<?= $team['team_url']?>">
			<div>
				<strong><?= $team['team_name']?></strong>
				<p class="desc"><?= $team['team_desc']?></p>
				<p class="updateMenu">최근에 선택한 메뉴 : 심슨탕(3일 전)</p>
			</div>
			<p class="member">5명</p>
		</a>
	</li>
	<? } ?>
</ul>
<?php
	include "app/views/team_add.php";
?>