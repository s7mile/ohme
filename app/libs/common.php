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

//date
function datePrint($date){
	$date2 = explode(" ", $date);
	if($date2[0] == date("Y-m-d"))
		$date = "오늘 ".$date2[1];
	else
		$date = $date2[0];

	echo $date;
}

//file check
function fileChk($file, $type=""){
	$file_img = $file['tmp_name'];
	if(is_uploaded_file($file_img)){
		$file_name = $file['name'];
		
		$fn = explode(".", $file_name);
		$chk = strtolower(end($fn));

		if($type == "img"){
			$array = array("gif", "jpg", "jpeg", "png");
			$link = "이미지 파일(gif, jpg, png)이 아닙니다";
		}else if($type == "thumb"){
			$array = array("gif", "jpg", "jpeg");
			$link = "이미지 파일(gif, jpg)이 아닙니다.";
		}else{
			$array = array("gif", "jpg", "jpeg", "png", "xls", "ppt", "pptx", "hwp", "docx", "doc", "dot", "dotx", "pdf", "zip", "csv");
			$link = "보안상 업로드 불가능한 파일이 있습니다";
		}
		if(!in_array($chk, $array)){
			echo $link;
			return false;
		}

		$file_name2 = date("ymdhis").rand(1000, 9999).".".$chk;
		if(is_dir("./data/member/".md5($_SESSION['loginId']))== false){
			mkdir("./data/member/".md5($_SESSION['loginId']), 0777);
		}

		move_uploaded_file($file_img, "./data/member/".md5($_SESSION['loginId'])."/".$file_name2);
	}

	return $file_name2;
}

//thumb
function thumbImg($file_name, $link, $max_width, $max_height){
	$file = './data/member/'.md5($_SESSION['loginId']).'/'.$file_name;
	$file_name2 = explode(".", $file_name);
	$save_filename = $file_name2[0].'_thumb.'.$file_name2[1];
	$ext = $file_name2[1]; //확장자

	$img_info = getImageSize($file);
	$img_width = $img_info[0];
	$img_height = $img_info[1];

	if(($img_width/$max_width) == ($img_height/$max_height)){
		//원본과 썸네일의 가로세로비율이 같은경우
		$dst_width=$max_width;
		$dst_height=$max_height;
		$crop_x = 0;
		$crop_y = 0;
	}else if(($img_width/$max_width) > ($img_height/$max_height)){
		//세로에 기준을 둔경우
		$dst_width=$max_height*($img_width/$img_height);
		$dst_height=$max_height;
		$crop_x = floor(($dst_width-$max_width)/2);
		$crop_y = 0;
	}else{
		//가로에 기준을 둔경우
		$dst_width=$max_width;
		$dst_height=$max_width*($img_height/$img_width);
		$crop_x = 0;
		$crop_y = floor(($dst_height-$max_height)/2);
	}

	switch($ext){
		case "jpg":
		case "jpeg":
			$src = ImageCreateFromJPEG($file); 
			$thumb = ImageCreate($max_width,$max_height); 

			$thumb = imagecreatetruecolor($max_width, $max_height);
			imagecopyresampled($thumb,$src,0,0,$crop_x,$crop_y,$dst_width,$dst_height,imagesx($src),imagesy($src));
			ImageJPEG($thumb,$link.$save_filename); 
			ImageDestroy($thumb);
		break;

		case "gif":
			$src = ImageCreateFromGIF($file); 
			$thumb = ImageCreate($max_width,$max_height); 

			$thumb = imagecreatetruecolor($max_width, $max_height);
			imagecopyresampled($thumb,$src,0,0,$crop_x,$crop_y,$dst_width,$dst_height,imagesx($src),imagesy($src));
			ImageGIF($thumb,$link.$save_filename); 
			ImageDestroy($thumb);
		break;

		case "png":
			$src = ImageCreateFromPNG($file); 
			$thumb = ImageCreate($max_width,$max_height); 

			$thumb = imagecreatetruecolor($max_width, $max_height);
			imagecopyresampled($thumb,$src,0,0,$crop_x,$crop_y,$dst_width,$dst_height,imagesx($src),imagesy($src));
			ImagePNG($thumb,$link.$save_filename); 
			ImageDestroy($thumb);
		break;
	}
}

function userProfile($id, $file, $thumb=""){
	if($thumb == 1){
		$userProfile = explode(".", $file);
		$userProfileLink = '/data/member/'.md5($id).'/'.$userProfile[0].'_thumb.'.$userProfile[1];
	}else{
		$userProfileLink = '/data/member/'.md5($id).'/'.$file;
	}
	return $userProfileLink;
}

function userProfilePrint($id, $name, $file){
	echo '<span>';
	if($file)
		echo '<img src="'.userProfile($id, $file, 1).'" alt="'.$name.'">';
	echo '</span>';
}
?>