<article id="teamSettingHead">
	<div>
		<span></span>
		<h2><?= $teamInfo->team_name?></h2>
		<ul class="tab2">
			<li class="sel"><a href="/<?= $team_url?>/setting">멤버관리</a></li>
		</ul>
	</div>
</article>

<article id="memberSetting">
	<div class="invite">
		<input type="hidden" id="team" name="team" value="<?= $team_url?>">
		<input type="text" id="join_user" name="join_user">
		<input type="button" class="button" id="submit" value="초대하기">
	</div>

	<ul class="tableHead">
		<li>
			<div class="user"></div>
			<div class="like">선호하는 메뉴</div>
			<div class="date">최근 선택한 날짜</div>
			<div class="date">함께한 날짜</div>
		</li>
	</ul>
	<ul>
		<?php foreach($memberList as $member){ ?>
		<li>
			<div class="user">
				<span></span>
				<strong><?= $member->user_name?> (<?= $member->user_id?>)</strong>
			</div>
			<div class="like">1위 심슨탕 2위 코코이찌방야 3위 혜화돌쇠아저씨</div>
			<div class="date"><?= $member->final_date?></div>
			<div class="date">
				<?php
				if($member->status == 0)
					echo "초대 중";
				else
					echo $member->join_date;

				?>
			</div>
		</li>
		<?php } ?>
	</ul>
</article>