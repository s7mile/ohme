<article id="addMenu" class="modal">
	<div class="bg"></div>
	<div class="wrap">
		<h2>맛 좋은 메뉴 추가</h2>
		<div class="cont">
			<input type="hidden" id="team" name="team" value="<?= $team_url?>">
			<div>
				<label for="name">식당이름</label>
				<input type="text" id="name" name="name" placeholder="식당이름">
			</div>
			<div>
				<label for="tag">태그</label>
				<div class="fl">
					<input type="text" id="tag" placeholder="태그">
					<input type="button" id="addTag" class="button" value="추가">
					<p>ex) 뜨거운/차가운, 고기, 찌개, 한식/중식/일식/양식, 밥/면...</p>
					<p id="tagList"></p>
					<input type="hidden" name="tag" id="sendTag">
				</div>
			</div>
		</div>
		<div class="btnArea">
			<input type="button" id="submit" value="등록">
			<input type="button" class="close" value="취소">
		</div>
	</div>
</article>