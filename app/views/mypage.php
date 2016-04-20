<article id="mypageHead">
	<div class="profileArea">
		<span></span>
		<label for="profile" class="profileUpdate">프로필사진 수정</label>
		<input type="file" name="profile" id="profile" class="hidden">
	</div>
	<h2><?= $_SESSION['loginName']?>(<?= $_SESSION['loginId']?>)</h2>
</article>
<article id="mypageArea">
	<h2>기본정보</h2>
	<ul>
		<li>
			<label for="userId">아이디(이메일)</label>
			<input type="text" name="userId" id="userId" value="<?= $userInfo->user_id?>" readonly="readonly">
		</li>
		<li>
			<label for="userName">닉네임</label>
			<input type="text" name="userName" id="userName" value="<?= $userInfo->user_name?>" readonly="readonly">
		</li>
	</ul>

	<h2>비밀번호 변경</h2>
	<ul>
		<li>
			<label for="nowPw">현재 비밀번호</label>
			<input type="password" name="nowPw" id="nowPw" placeholder="현재 비밀번호를 입력해주세요">
		</li>
		<li>
			<label for="newPw">새로운 비밀번호</label>
			<input type="password" name="newPw" id="newPw" placeholder="새로운 비밀번호를 입력해주세요">
		</li>
		<li>
			<label for="newPw2">새로운 비밀번호 확인</label>
			<input type="password" name="newPw2" id="newPw2" placeholder="새로운 비밀번호 재입력해주세요">
		</li>
	</ul>
	<input type="button" class="button" id="submit" value="변경하기">
	<input type="reset" class="button gray" id="submit" value="취소">
</article>