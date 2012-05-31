<?
	@session_start();
	$efeito = $_GET['efeito'];
	$url = $_GET['url'];
	$ch = curl_init ($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	$rawdata=curl_exec ($ch);
	curl_close ($ch);
	function efeito($efeito,$data){
		$img = imagecreatefromstring($data);
		switch($efeito){
		  case 1:/*Normal*/  break;
		  case 2:/*Brilho*/    imagefilter($img,  IMG_FILTER_BRIGHTNESS, 60);break;
		  case 3:/*Blur*/       imagefilter($img,  IMG_FILTER_GAUSSIAN_BLUR);break;
		  case 4:/*Cartoon*/ imagefilter($img,  IMG_FILTER_MEAN_REMOVAL);imagefilter($img,  IMG_FILTER_GAUSSIAN_BLUR);break;
		  case 5:/*Lily*/     imagefilter($img,  IMG_FILTER_GRAYSCALE);imagefilter($img, IMG_FILTER_COLORIZE,45, 45, 0);break;
		  case 6:/*Gray*/     imagefilter($img,  IMG_FILTER_GRAYSCALE);imagefilter($img,  IMG_FILTER_CONTRAST, -20);break;
		  case 7:/*Sepia*/    imagefilter($img,  IMG_FILTER_GRAYSCALE);imagefilter($img, IMG_FILTER_COLORIZE, 85, 55, 35);break;
		  case 8:/*Contrast*/imagefilter($img,  IMG_FILTER_CONTRAST, -50);break;
		  case 9:/*Negativo*/imagefilter($img, IMG_FILTER_NEGATE);break;
		  case 10:/*Cartoon*/ imagefilter($img, IMG_FILTER_EDGEDETECT);imagefilter($img,  IMG_FILTER_BRIGHTNESS, 80);imagefilter($img,  IMG_FILTER_CONTRAST, -20);imagefilter($img,  IMG_FILTER_GAUSSIAN_BLUR);break;
		  }
		imagejpeg($img);
		imagedestroy($img);
	    
		return $img;
	}
	echo efeito($efeito,$rawdata);
?>