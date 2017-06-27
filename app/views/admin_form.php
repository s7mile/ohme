<article id="mypageArea">
	<h2>메뉴(음식점) 추가</h2>
	<div id="map">
		<div class="searchArea">
			<input type="text" name="search" id="search" value="월계1동" placeholder="주소를 입력해주세요">
			<input type="button" value="주소 검색" class="button fill" id="searchSubmit">
		</div>
	</div>
	<ul>
		<li>
			<label for="address">위치</label> 
			<input type="text" name="x" id="x" readonly>
			<input type="text" name="y" id="y" readonly>
			<input type="text" name="address" id="address">
		</li>
		<li>
			<label for="name">식당이름</label>
			<input type="text" name="name" id="name" value="<? if(isset($menuInfo)) $menuInfo->menu_name?>" placeholder="식당이름">
		</li>
		<li>
			<label for="tag">태그</label>
			<div class="di">
				<input type="text" id="tag" placeholder="태그">
				<input type="button" id="addTag" class="button" value="추가">
				<p class="di">ex) 뜨거운/차가운, 고기, 찌개, 한식/중식/일식/양식, 밥/면...</p>
				<p id="tagList"></p>
				<input type="hidden" name="tag" id="sendTag">
			</div>
		</li>
	</ul>
	<input type="button" class="button" id="submit" value="추가하기">
	<input type="reset" class="button gray" id="submit" value="취소">
</article>
<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=rUqQr5OWOLf8TEwbXCps&submodules=geocoder"></script>
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

	//현재 위치로 지도 이동
	var map = new naver.maps.Map('map', {
		center: new naver.maps.LatLng(x, y),
		zoom: 13,
		zoomControl: true, //줌 컨트롤의 표시 여부
		zoomControlOptions: { //줌 컨트롤의 옵션
			position: naver.maps.Position.TOP_RIGHT
		}
	});
	var marker = new naver.maps.Marker({
		position: new naver.maps.LatLng(x, y),
		map: map
	});

	//선택할때마다 위치값 넣기
	naver.maps.Event.addListener(map, 'click', function(e) {
		marker.setPosition(e.latlng);
		$("#x").val(e.latlng.x);
		$("#y").val(e.latlng.y);

		naver.maps.Service.reverseGeocode({
			location: new naver.maps.LatLng(e.latlng.y, e.latlng.x)
		}, function(status, response) {
			if (status === naver.maps.Service.Status.ERROR)
				return alert('0: 지도가 오류났어요ㅠㅠ');

			$("#address").val(response.result.items[0].address);
		});
	});

	$("#search").on("keydown", function(e){
		var keycode = e.which;
		if(keycode === 13)
			searchAddressToCoordinate($("#search").val(), map, marker);
	});

	$("#searchSubmit").on("click", function(e){
		e.preventDefault();
		searchAddressToCoordinate($("#search").val(), map, marker);
	});
}
function searchAddressToCoordinate(address, map, marker) {
    naver.maps.Service.geocode({
        address: address
    }, function(status, response) {
        if (status === naver.maps.Service.Status.ERROR)
            return alert('1: 지도가 오류났어요ㅠㅠ');

        var item = response.result.items[0],
        	point = new naver.maps.Point(item.point.x, item.point.y);
        $("#address").val(item.address);
        $("#x").val(point.x);
		$("#y").val(point.y);

        map.setCenter(point);
        marker.setPosition(point);
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