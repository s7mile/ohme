<?php
session_start();

function alertmove($msg, $link=""){
	echo '<script>';
	echo 'alert("'. $msg .'");';
	echo $link? 'document.location.href="'. $link .'";' : 'history.back();' ;
	echo '</script>';
	exit();
}

function movepage($link=""){
	echo '<script>';
	echo $link? 'document.location.href="'. $link .'";' : 'history.back();' ;
	echo '</script>';
	exit();
}
?>