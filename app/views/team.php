<p class="buttonArea">
	<a href="javascript:;" class="button add">팀 만들래요</a>
</p>
<ul id="teamList">
	<?php
	foreach($teamList as $team){
		if($team['status'] == 0){
	?>
	<li class="invite">
		<a href="javascript:;" class="inviteTeam">
			<input type="hidden" name="team" class="team" value="<?= $team['team_url']?>">
			<div>
				<strong><?= $team['team_name']?></strong>
				<p class="desc"><?= $team['team_desc']?></p>
				<p class="updateMenu">초대받은 날짜 : <?= $team['join_date']?></p>
			</div>
		</a>
	</li>
	<?php
		}else{ ?>
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
	<?php
		}
	}
	?>
</ul>
<?php
	include "app/views/team_add.php";
?>