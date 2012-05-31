<?php
 require_once 'facebook.php';
 $app_id = "320111878025593";
 $app_secret="caf194f54a1448bb7fb932a810db1d76";
    $message = "Escolha um filtro para melhorar suas imagens, um modo rapido e facil para deixar suas foto estilosas e lindas!";
	$canvas_page="http://apps.facebook.com/pimpmyphotoapp/";
    $requests_url = "https://www.facebook.com/dialog/apprequests?app_id=" 
                . $app_id . "&redirect_uri=" . urlencode($canvas_page)
                . "&message=" . $message;
 function callFb($url){
		$ch = curl_init();
		curl_setopt_array($ch, array(CURLOPT_URL => $url,CURLOPT_RETURNTRANSFER => true));
 
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
 $canvas = "http://apps.facebook.com/pimpmyphotoapp/";
 $auth_url= "http://www.facebook.com/dialog/oauth?client_id=".$app_id."&redirect_uri=".urlencode($canvas)."&scope=user_photos,email,read_stream,publish_stream";
 $signed_request = $_REQUEST["signed_request"];
 list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

     $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
?>
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<link href="http://pimpmyphoto.phpfogapp.com/facebook/style.css" rel="stylesheet" type="text/css">
	<script type="text/javascript">
	function showHint(str)	{
	var xmlhttp;
	if (str.length==0){ 
	  document.getElementById("txtHint").innerHTML="";
	  return;
	  }
	if (window.XMLHttpRequest){
	  xmlhttp=new XMLHttpRequest();
	  }
	else{
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function(){
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)		{
		document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		window.location.hash="txtHint";
		}
	 }
	xmlhttp.open("GET","http://pimpmyphoto.phpfogapp.com/facebook/ajax/gethint.php?q="+str,true);
	xmlhttp.send();
	}
	function Save(str){
	var foto;
	 if (window.XMLHttpRequest){
	  foto=new XMLHttpRequest();
	  }
	else{
	  foto=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	 foto.onreadystatechange=function(){
	  if (foto.readyState==4 && foto.status==200){
		document.getElementById("phoSalvas").innerHTML=foto.responseText;
		window.location.hash="phoSalvas";
		}
	 }
	  foto.open("GET","http://pimpmyphoto.phpfogapp.com/facebook/ajax/save.php?efeito="+str,true);
	  foto.send();
	}
	function Request(){
		top.location.href="<? echo $requests_url;?>";
	}
	function Sair(){
		top.location.href="http://www.facebook.com/";
	}
	</script>
	</head>
	<body>
	<?
	if (empty($data["user_id"])) {
            echo("<script> top.location.href='". $auth_url . "'</script>");
    } else{
			$url = "https://graph.facebook.com/".$data["user_id"]."?access_token=".$data["oauth_token"]."&fields=name";
			$ret_json = callFb($url);
			$user = json_decode($ret_json, true);
	
			$url = "https://graph.facebook.com/".$data["user_id"]."/photos?access_token=".$data["oauth_token"]."&fields=source,picture";
			$ret_json = callFb($url);
			$fotos = json_decode($ret_json, true);

			$url = "https://graph.facebook.com/".$data["user_id"]."/albums?access_token=".$data["oauth_token"]."&fields=id";
			$ret_json = callFb($url);
			$album_id = json_decode($ret_json, true);
	
	?>
			<img src="http://i1164.photobucket.com/albums/q562/juk2/logo-n.png"/>
			<div id="txtHint"></div>
			<div id="phoSalvas"></div>
			<div id="fontb"><?echo $user['name'];?> escolha alguma de suas imagens</div>
	<?php
		$e = "|1";
	    foreach($fotos['data'] as $obj){
			echo "<div id='i'>
				<a href='javascript:void(0);'  id=".$obj['source'].$e.'|'.$data["oauth_token"]."  onclick='showHint(this.id)'>
				<img src='".$obj['picture']."' border='0'/></a>
			</div>";
		}
		foreach($album_id['data'] as $key){
			$url = "https://graph.facebook.com/".$key["id"]."/photos?access_token=".$data["oauth_token"]."&fields=source,picture&limit=500";
			$ret_json = callFb($url);
			$fotos_albums = json_decode($ret_json, true);
			foreach($fotos_albums['data'] as $keys){
				echo "<div id='i'>
				<a href='javascript:void(0);' id=".$keys['source'].$e.'|'.$data["oauth_token"]."  onclick='showHint(this.id)'>
				<img src='".$keys['picture']."' border='0'/></a>
				</div>";
			}
		}
     }
	?>
	<br/>
	</body>
	</html>