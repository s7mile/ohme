<div id="roulArea" class="modal">
	<div class="bg"></div>
	<div class="wrap">
		<canvas id="wheelcanvas" width="650" height="650"></canvas>
		<button class="btn btn-info" id="spin" onclick="spin();" type="button">START</button>

		<input type="button" class="close" value="X">
	</div>
</div>
<?php
$menu = "";
if($roulMenu != false){
	foreach($roulMenu[0] as $roul){
		if($menu == '')
			$menu .= '{"name" : "'.$roul['menu_name'].'", "idx" : "'.$roul['idx'].'"}';
		
		else
			$menu .= ', {"name" : "'.$roul['menu_name'].'", "idx" : "'.$roul['idx'].'"}';
	}

	echo '<script type="text/javascript">';
	echo 'var menus = [';
	echo $menu;
	echo '];';
	echo '</script>';
}
?>
<script	type="text/javascript" src="/public/js/roulette.js"></script>