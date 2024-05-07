<?php 
session_start();
include('./snippets/connection.php');
$activemainlink2="activemainlink";
$currentyear=date('Y');

	$outoption=produceOptionDates(1973,$currentyear,'');
?>
<!DOCTYPE html>
<html>
<head>
<title>OYO KOPA</title>
<meta http-equiv="Content-Language" content="en-us">
<meta charset="utf-8"/>
<meta http-equiv="Content-Type" content="text/html;"/>
<meta name="description" content="">
<meta name="keywords" content=""/>
<meta property="og:locale" content="en_US"/>
<meta property="fb:app_id" content=""/>
<meta property="fb:admins" content=""/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="http://pathtoimage"/>
<meta property="og:title" content="Page Title | website title"/>
<meta property="og:description" content="Visit this exciting blog for daily acccess to Muyiwa's business and career radio and television talk-show content that give you Insights, ideas and strategies for superior performance, high productivity and excellence in your career!"/>
<meta property="og:url" content="http://thepageurl"/>
<meta property="og:site_name" content="Page Title | website title"/>
<link rel="canonical" href="http://thepagename"/>
<link rel="stylesheet" href="./stylesheets/prettyphoto.css"/>
<link rel="shortcut icon" href="favicon.ico"/>
<script src="./scripts/jquery.js"></script>
<script src="./scripts/mylib.js"></script>
<script src="./scripts/prettyphotoadmin.js"></script>
<script src="./scripts/formchecker.js"></script>

</head>
<body>
<div id="main">
	
		<div id="mainlogopanel" class="container">
		
			<!--<img class="extraclass" src="./images/prettyphoto.jpg"/>
				
				<img class="extraextraclass" src="./images/Editorial.png"/>
			-->
			<h1><img class="extraclass" src="./images/prettyphoto.jpg"/>OYO KOPA </h1> 
			<h6>Editorial Community Development Group of NYSC Oyo State.</h6>
		</div>
		<div id="linkspanel">
			<!-- <img class="" src="./images/prettyphoto.png" /> -->
			<ul>
				<?php include("./snippets/toplinks.php");?>
			</ul>
		</div>
	

<div id="contentpanel">
	<!--<p class="spacing">You can update previously taken information here</p>
		-->
		<div class="searchpanehold">
			<p name="batchyear">
				<select name="batch" class="curved2">
					<option value="A">Batch A</option>
					<option value="B">Batch B</option>
					<option value="C">Batch C</option>
				</select>
				<select class="curved2" name="year">
					<?php echo $outoption;?>
				</select>
			</p>
			<p class="spaco"></p>
			<input class="curved" name="searchdata" Placeholder="Corper Name/code number" appdata-control="searchname2" onkeypress="searchKeyPress(event);" /><br>
 <script>
    function searchKeyPress(e)
    {
        // look for window.event in case event isn't passed in
        e = e || window.event;
        if (e.keyCode == 13)
        {
            document.getElementById('btnSearch').click();
        }
    }
    </script>

	<p class="spaco"></p>
			<input type="button" id="btnSearch" name="submitsearch" value="Submit" class="submitbutton"/>
<p class="spaco"></p>

		</div>
	<div id="contentdisplayhold">	

			<?php 
				$corpout=getAllCorpPhotos("","","","");
				echo $corpout['adminoutput'];
			?>

	</div>
</div>
	<div id="footerpanel">
		<div id="footerpanelcontent">
			<div id="copyright">
	<?php include('./snippets/footer.php');?>
			</div>
		</div>
	</div>
	</div>
</body>
</html>