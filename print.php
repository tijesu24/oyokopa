<?php 
session_start();
include('./snippets/connection.php');
$activemainlink3="activemainlink";
	$currentyear=date('Y');

	$outoption=produceOptionDates(1973,$currentyear,'');
?>
<!DOCTYPE html>
<html>

<head>
    <title>OYO KOPA</title>
    <meta http-equiv="Content-Language" content="en-us">
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html;" />
    <meta name="description" content="">
    <meta name="keywords" content="" />
    <meta property="og:locale" content="en_US" />
    <meta property="fb:app_id" content="" />
    <meta property="fb:admins" content="" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="http://pathtoimage" />
    <meta property="og:title" content="Page Title | website title" />
    <meta property="og:description"
        content="Visit this exciting blog for daily acccess to Muyiwa's business and career radio and television talk-show content that give you Insights, ideas and strategies for superior performance, high productivity and excellence in your career!" />
    <meta property="og:url" content="http://thepageurl" />
    <meta property="og:site_name" content="Page Title | website title" />
    <link rel="canonical" href="http://thepagename" />
    <link rel="stylesheet" href="./stylesheets/prettyphoto.css" />
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="./scripts/jquery.js"></script>
    <script src="./scripts/mylib.js"></script>
    <script src="./scripts/prettyphoto.js"></script>
    <script src="./scripts/formchecker.js"></script>
</head>

<body>
    <div id="main">
        <div id="mainlogopanel" class="container">

            <!--<img class="extraclass" src="./images/prettyphoto.jpg"/>
				
				<img class="extraextraclass" src="./images/Editorial.png"/>
			-->
            <h1><img class="extraclass" src="./images/prettyphoto.jpg" />OYO KOPA </h1>
            <h6>Editorial Community Development Group of NYSC Oyo State.</h6>
        </div>
        <div id="linkspanel">
            <!-- <img class="" src="./images/prettyphoto.png" /> -->
            <ul>
                <?php include("./snippets/toplinks.php");?>
            </ul>
        </div>


        <div id="contentpanel">
            <!--<p id="spacing">The control panel below has options for you to use concerning printing, simply click "Print All" to get all entries in print, then on the print page you can export to pdf</p>
	-->
            <div id="controlspane">
                <div class="optionout"><a href="##"
                        onclick="PrintElem('div#printzone','<?php echo $host_addr;?>stylesheets/prettyphoto.css')"
                        class="repo">Print</a></div>
                <div class="optionout"><a href="##" appdata-name="viewall" class="repo">View all</a></div>
                <div class="optionout"><a href="##" appdata-name="searchname" class="repo">Search Name</a></div>
                <div class="optionout"><a href="##" appdata-name="vcrange" class="repo">View codeno Range</a></div>
                <div class="optionout"><a href="##" appdata-name="pparange" class="repo">Search PPA</a></div>
                <div appdata-name="optionscontent">
                    <p name="infopoint" class="optionin"></p>
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
                        <input class="curved" name="searchdata" Placeholder="Type in the value(s)"
                            appdata-control="" /><br>
                        <p class="spaco"></p>
                        <input type="button" id="btnSearch" name="submitsearch" value="Submit" class="submitbutton" />
                        <p class="spaco"></p>
                        <script>
                        function searchKeyPress(e) {
                            // look for window.event in case event isn't passed in
                            e = e || window.event;
                            if (e.keyCode == 13) {
                                document.getElementById('btnSearch').click();
                            }
                        }
                        </script>
                    </div>
                </div>
            </div>
            <div id="printzone">
                <!-- <div id="printtopcontent">
				<div class="floatright pgnum">1</div>
			</div> -->
                <?php 
			// $outs=getAllCorpPhotos("","","print",""); 
			// echo $outs['printoutput'];
			$str=2015;
			$sub=substr($str, 2,4);
			// echo $sub;
		/*		$countheader=1;
				$pageheader="";
				$pageheader2="";
				$checker="off";
				for ($i=1; $i <=300 ; $i++) { 
					# code...
					$monitor=$i%49;
					// echo "".$monitor."<br>";
					if($i==1){
						$pageheader='<div id="printtopcontent">
										<div class="floatright pgnum">'.$countheader.'</div>
									</div>';
						$countheader+=1;
						echo $pageheader;
					}
					if($i%49<1){
						$checker="on";
					}else{
						if($checker=="on"){
							$pageheader='<div id="printtopcontent">
										<div class="floatright pgnum">'.$countheader.'</div>
									</div>';
						$countheader+=1;
						echo $pageheader;
						$checker="off";
						}
					}
					echo '
						<div class="prettyholder">
					      <div class="prettyimg"><img src="http://localhost/prettyphotos/./files/thumbnails/IMG_20121008_1544171679091c5a880faf6fb5e6087eb1b2dc.jpg"></div>
					      <div class="prettycontent">
					        <span class="corpnameout">Damian Anitoine</span><br>
					        IB/14A/1363<br>
					        PPA:
					        somewhere we dont know
					      </div>
					    </div>
					';
				}*/
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