<?php 
//MOD BY HH
ob_start();

$config = array();
include "config/config.php";

// header("Refresh: " . $config['refreshtime']);
date_default_timezone_set($config['timezone']);

include "include/cache.php";
LoadCacheIfValid();

if($config['timing']) {
	include "include/timing.php";
}

global $locale;
include "include/API.php";
$eventData = GetEvent();
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo $locale['title']; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="layout.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="js/resultservice.js"></script>
		<link rel="shortcut icon" href="images/favicon.ico" />
		 <script src="js/jquery-1.10.2.js"></script>
		 
	</head>
	<body>
		<?php include_once("include/analyticstracking.php") ?>
		<table cellspacing="3" cellpadding="0" border="0">
		<tr valign="top">
		<td colspan="3" align="center" class="siteheader">
		<?php
			PrintEvent();
		?>
		</td>
		</tr>
		<tr valign="top">
		<td>
		<?php 
			PrintSearchBox(200);
			PrintToplistMenu($eventData,200); 
			PrintMenu($eventData,200); 
		?>
		</td>
		<td>
		<div id='results'></div>
			
		</td>
		<td>
		<?php 
			PrintLocales(200);
			PrintTrackedTeams(200); 
			PrintSponsors(200);
		?>
		</td>
		</tr>
		
		<tr>
		<td colspan="3" align="center" class="siteheader" />
		<?php
			PrintFooter();
		?>
		</td>
		</tr>
		</table>
	</body>
	<script type="text/javascript">
	//var showQuery = '?startlist';
	var showQuery = '/';
//	var showQuery = '?startlist';
	function reRender(qString){
			 console.log( "reRender "+qString );
			showQuery = qString;
			$( "#results" ).load('/results.php'+qString);
			$( "#trackedteams" ).load('/trackstatusjquery.php');
	};

	$( document ).ready(function() {
	$( "#results" ).load('/results.php'+showQuery);
	 console.log( "ready!" );

	});
	setInterval(function(){
		var dummy = reRender(showQuery);
	},<?php echo $config['refreshtime'] . "000"; ?>);
	//},6000);
	
	

	document.getElementById('go').onclick = function () {

		//showQuery='?searchstring=haka&startlist='	
		//showQuery=document.getElementById('searchstring');
		showQuery= '?searchstring=' + $('#searchstring').val() + '&startlist=';
		//'?searchstring=haka&startlist='	
	 var dummy = reRender(showQuery);
	 console.log( "click!" );
	 console.log( showQuery );

    
};
	document.getElementById('startlist').onclick = function () {
				showQuery='?startlist'	

	 var dummy = reRender(showQuery);
	 console.log( "click!" );
	 console.log( showQuery );

    
};
	</script>
	
</html>
<?php
	SaveCacheFile();
?>