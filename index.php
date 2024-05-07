<?php 
session_start();
include('./snippets/connection.php');
$activemainlink="activemainlink";
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
<script src="./scripts/prettyphoto.js"></script>
<script src="./scripts/formchecker.js"></script>
<script type="text/javascript">

</script>
</head>
<body id="bodyy">
	<div id="wrapper">
	<div id="main">
	
		<div id="mainlogopanel" class="container">
		
			<h1><img class="extraclass" src="./images/prettyphoto.jpg"/>OYO KOPA </h1> 
			<p class="logomotto">Editorial Community Development Group of NYSC Oyo State.</p>
		</div>
	
	
<div id="contentpanel2">
	<form action="./snippets/login.php" method="POST" name="adminform">
					<input type="hidden" name="entryvariant"/>
					<BR><br><br>	
					<BR><br><br>	
								
					<div id="formend">
							<div id="formend">
								<BR>
								<div id="">
									Username: *
									<input name="username"  placeholder="Username" class="curved8"/>
								</div>
								<BR>
								<div id="">
									Password: * 
									<input type="password" name="password"  placeholder="Password" class="curved8"/>
								</div>
							</div>
					</div>
					<div id="formend">
						<br><br>
						<input type="submit" name="submit" value="Login" class="submitbutton"/>
					</div>

		</form>
		<br>
		<br>
		<!--<p style="text-align:center;font-size:3em;"><br>OR<br></p>-->
		

</div>
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