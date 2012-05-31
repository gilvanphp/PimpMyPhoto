<?php
	function Sav($efeito,$url,$permission){
		$graph_url= "https://graph.facebook.com/me/photos?"
		. "url=" .urlencode('http://pimpmyphoto.phpfogapp.com/facebook/ajax/effect.php?efeito='.$efeito.'&url='.$url.'')
		. "&method=POST"
		. "&access_token=" .$permission;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $graph_url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
		$data = curl_exec($ch);
		$showimg = 'efeito='.$efeito.' &url='.$url.'';
		return $showimg;	
	}
	if(isset($_GET['url'])){
		echo '<div id="fontb">Foto salvada no Album PimpMyPhoto</div>';
		?>
		<div id="i"><img src="http://pimpmyphoto.phpfogapp.com/facebook/ajax/effect.php?<?php echo Sav($_GET['efeito'],$_GET['url'],$_GET['permission'])?>"/></div>
		<?php
	}
?>
