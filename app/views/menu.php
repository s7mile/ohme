<script>
function geoLocation(){
	if (navigator.geolocation)
		navigator.geolocation.getCurrentPosition(showPosition,showError);
	else
		alert("Geolocation is not supported by this browser.");
}
//위치 추적 Success
function showPosition(position){
	var x = position.coords.latitude;
	var y = position.coords.longitude;
	
    $.ajax({
         type : "post",
         url : "https://maps.googleapis.com/maps/api/geocode/json?latlng="+x+","+y+"&key=AIzaSyBqLfIxBX-NpWNgCYyFFH6y0nReZtjbxUw",
         data : {},
         success : function(result){
         	console.log(result);
         	$("#nowPos").text("현재위치 : " + result.results[1].formatted_address);
         },
         error : function(err){
            console.log("Error");
         }
    });

}
//위치 추적 Faile
function showError(error){
	switch (error.code){
		case error.PERMISSION_DENIED:
			alert("User denied the request for Geolocation.");
			break;
		case error.POSITION_UNAVAILABLE:
			alert("Location information is unavailable.");
			break;
		case error.TIMEOUT:
			alert("The request to get user location timed out.");
			break;
		case error.UNKNOWN_ERROR:
			alert("An unknown error occurred.");
			break;
	}
}
geoLocation();
</script>
<p class="topArea">
	<span id="nowPos">현재위치 : 잠시만 기다려주세요!</span>
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
					<li class="tag"><?php
						$tags = explode(",", $menu['menu_tag']);
						foreach($tags as $tag)
							echo '<span>'.$tag.'</span>';
					?></li>
				</ul>
			</a>
			<a href="javascript:;" class="other"></a>
		</li>
<?php } ?>
</ul>
<?php
	include "app/views/menu_form.php";
?>