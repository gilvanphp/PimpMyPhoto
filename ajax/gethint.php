<?php 
	@session_start();
	if(isset($_GET["q"])){
		$link = $_GET["q"];
		
		$array = explode("|", $link);
		
		include("../carousel.php");
?>
		<div id='newimage'>
		<img src="http://pimpmyphoto.phpfogapp.com/facebook/ajax/effect.php?efeito=<?echo $array[1]?>&url=<?echo $array[0]?>"/>
		</div>
<?
	}
	
?>
