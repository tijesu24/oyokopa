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
// Using jQuery.

$(function() {
    $('form').each(function() {
        $(this).find('input').keypress(function(e) {
            // Enter pressed?
            if(e.which == 10 || e.which == 13) {
                this.form.submit();
            }
        });

        $(this).find('input[type=submit]').hide();
    });
});
</script>
</head>
<body>
	<div id="wrapper">
	<div id="main">
	
		<div id="mainlogopanel" class="container">
		
			<!--<img class="extraclass" src="./images/prettyphoto.jpg"/>
				
				<img class="extraextraclass" src="./images/Editorial.png"/>
			-->
			<h1><img class="extraclass" src="./images/prettyphoto.jpg"/>OYO KOPA </h1> 
			<p class="logomotto">Editorial Community Development Group of NYSC Oyo State.</p>
		</div>
		<div id="linkspanel">
			<!-- <img class="" src="./images/prettyphoto.png" /> -->
			<ul>
				<?php include("./snippets/toplinks.php");?>
			</ul>
		</div>
	
<div id="contentpanel">
	<br>
	<p class="spacing">The Main Objective of this project is to build a Functional, User Friendly and Robust Application for the Editorial Department NYSC, Oyo State, one that potrays Efficiency and reduces manual labour thereby making content managment easy in deploying a Standard photo album usually created for all corp member respective of their batches.
	To Create New Corp member Entries use the form below, afterwards, you can edit the entries or simply print them out or save them to pdf, Please run this Application preferably in Google Chrome or Firefox 34.5</p>
	<br><form name="prettyphotoentryform" action="./snippets/basicsignup.php" method="post" enctype="multipart/form-data"/>
					<div id="formheader">New Entry.</div>
							<input name="entryvariant" type="hidden" value="createnewentries"/>
					<div id="formend">
						<div name="entries">
							<input name="entrycount" type="hidden" value="1"/>
							<div id="formend">
								<div id="elementholder">
									CORPER FULL-NAME *
									<input name="name1"  placeholder="Corp Member Fullname(1)" class="curved"/>
								</div>
								<div id="elementholder">
									STATE CODE *:<br>
									<input type="text" class="curved curvedbackcolorone" placeholder="OY" maxlength="2" style="width:13%;margin-left:1%;" name="state1"/>
									<input type="text" class="curved curvedbackcolorone" placeholder="14B" maxlength="3" style="width:15%;margin-left:1%;" name="batch1"/>
									<input type="text" class="curved curvedbackcolorone" placeholder="XXXX" maxlength="4" style="width:32%;margin-left:0%;" name="code1"/>
								</div>
								<div id="elementholder">
									PPA(1)
									<input name="ppa1"  placeholder="Place of Primary Ass.(1)" class="curved"/>
								</div>
								<div id="elementholder">
									PHOTOGRAPH(1) *
									<input name="profpic1" type="file" class="curved"/>
								</div>
							</div>
							<div class="entrymarker"></div>
						</div>
							<a href="##entryadd" style="position:relative;clear: both;  color: white;width:100%;float:none;font-size:2em;text-align:center;" name="entryadd" data-target="div[name=entries]">click here to add another entry</a>
					</div>
					<div id="formend">
						<input type="button" name="createentry" value="Submit" class="submitbutton"/>
					</div>
					<!-- <div id="bottomlabel"><img src="./images/csi.png" class="total"></div> -->
		</form>
		<br>
		<br>
		<!--<p style="text-align:center;font-size:3em;"><br>OR<br></p>-->
		<form name="prettyphotoimportform" action="./snippets/basicsignup.php" method="post" enctype="multipart/form-data"/>
					<div id="formheader">Import Entries.</div>
					<!--<input name="entryvariant" type="hidden" value="importentries"/>--><BR>
					<div id="formend"><select name="entryvariant" class="curved2"><option value="">--Select type--</option><option value="importentries">IMPORT ALL ENTRIES</option><option value="importppa">IMPORT PPA ONLY</option></select>
	</div>
							<div id="formend">
								<div id="elementholder1">
									Import file(Please use a valid excel file i.e .xls, .xlsx) *
									<input name="importfile" type="file" class="curved"/>
								</div>
							</div>
					<div id="formend">
						<input type="button" name="createimport" value="Submit" class="submitbutton"/>
					</div>
					<!-- <div id="bottomlabel"><img src="./images/csi.png" class="total"></div> -->
				</form>
		<br>
		<br>
		
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