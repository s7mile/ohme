<?php
class main extends Controller {
	public function index(){
		$main = 1;
		$menu = ["떡볶이", "김치찌개", "분식", "부대찌개", "냉면", "샌드위치", "밥버거", "순대국", "수육국밥", "라면", "카레", "초밥/회", "치킨", "삼계탕", "육개장", "타코", "즉석떡볶이", "짜장면", "짬뽕", "탕수육", "짬짜면", "탕짜면", "탕짬면", "유린기", "훠궈", "딤섬", "만두", "김치말이국수", "회덮밥", "회냉면", "갈치조림", "돈까스"];
		include 'app/views/header_basic.php';
		include 'app/views/main.php';
		include 'app/views/footer.php';
	}
}
?>