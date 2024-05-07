<?php
include('connection.php');
$entryvariant=$_POST['entryvariant'];
if($entryvariant==""){

}elseif($entryvariant=="createmedia"){
$piccount=$_POST['piccount'];
//echo $piccount;
if($piccount>0){
  for($i=1;$i<=$piccount;$i++){
    $filename='defaultpic'.$i.'';
  $albumpic=$_FILES['defaultpic'.$i.'']['tmp_name'];
if($albumpic!==""){
    $filetypedata=getFileType($filename);
  if($filetypedata=="image"){
$image="defaultpic".$i."";
if(isset($imagepath)){
unset($imagepath);
unset($imagesize);
}
$imagepath=array();
$imagesize=array();
$imgpath[0]='../media/multimedia/';
$imgpath[1]='../media/thumbs/';
$imgsize[0]="default";
$imgsize[1]=",100";
// echo count($imgsize);
$acceptedsize="";
$imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
$len=strlen($imgouts[0]);
// echo $imgouts[0]."<br>";
$contentpath=substr($imgouts[0], 1,$len);
$len2=strlen($imgouts[1]);
// echo $imgouts[1]."<br>";
$contentpath2=substr($imgouts[1], 1,$len2);
// get image size details
$filedata=getFileDetails($imgouts[0],"image");
$filesize=$filedata['size'];
$width=$filedata['width'];
$height=$filedata['height'];
$contenttype='image';
}else if($filetypedata=="audio"||$filetypedata=="video"){
if($filetypedata=='audio'){
$outscontent=simpleUpload($filename,'../media/multimedia/audio/');
$contenttype="audio";
}elseif ($filetypedata=='video') {
  # code...
$outscontent=simpleUpload($filename,'../media/multimedia/videos/');
$contenttype="video";
}

$contentfilepath=$outscontent['filelocation'];
$len=strlen($contentfilepath);
$contentpath=substr($contentfilepath, 1,$len);
$filesize=$outscontent['filesize'];
$contentpath2="";
$width="";
$height="";
}/*else if($filetypedata=="others"){

}*/
// insert file content info into database
$mediaquery="INSERT INTO media(ownertype,details,mediatype,location,filesize,width,height)VALUES('contentmedia','$contentpath2','$contenttype','$contentpath','$filesize','$width','$height')";
// echo $mediaquery."<br>";
$mediarun=mysqli_query($wasl, $mediaquery)or die(mysql_error());
}
}
}
header('location:../admin/adminindex.php');
}else if ($entryvariant=="createnewentries") {
	# code...
	$entrycount=$_POST['entrycount'];
	for($i=1;$i<=$entrycount;$i++){
		$uid=getNextId("corpentries");
		$fullname=mysqli_real_escape_string($wasl, $_POST['name'.$i.'']);
		$state=mysqli_real_escape_string($wasl, $_POST['state'.$i.'']);
		$batch=mysqli_real_escape_string($wasl, $_POST['batch'.$i.'']);
		$code=mysqli_real_escape_string($wasl, $_POST['code'.$i.'']);
		$ppa=mysqli_real_escape_string($wasl, $_POST['ppa'.$i.'']);
		$datetime= date("D, d M Y H:i:s");
		$filename='profpic'.$i.'';

  $albumpic=$_FILES['profpic'.$i.'']['tmp_name'];
if($albumpic!==""){
    $filetypedata=getFileType($filename);
  if($filetypedata=="image"){
		$image="profpic".$i."";
		if(isset($imagepath)){
		unset($imagepath);
		unset($imagesize);
   }
$imagepath=array();
$imagesize=array();
$imgpath[0]='../files/originals/';
$imgpath[1]='../files/thumbnails/';
$imgsize[0]="default";
$imgsize[1]=",195";
// echo count($imgsize);
$acceptedsize="";
$imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
$len=strlen($imgouts[0]);
// echo $imgouts[0]."<br>";
$contentpath=substr($imgouts[0], 1,$len);
$len2=strlen($imgouts[1]);
// echo $imgouts[1]."<br>";
$contentpath2=substr($imgouts[1], 1,$len2);
// get image size details
$filedata=getFileDetails($imgouts[0],"image");
$filesize=$filedata['size'];
$width=$filedata['width'];
$height=$filedata['height'];
$contenttype='image';
$imgid=getNextId("media");
$mediaquery="INSERT INTO media(ownerid,ownertype,details,mediatype,location,filesize,width,height)VALUES('$uid','corper','$contentpath2','$contenttype','$contentpath','$filesize','$width','$height')";
// echo $mediaquery."<br>";
$mediarun=mysqli_query($wasl, $mediaquery)or die(mysql_error());
}
	}
// $corpquery="INSERT INTO corpentries(fullname,state,batch,code,ppa,imgid,entrydate)VALUES('$fullname','$state','$batch','$code','$ppa','$imgid','$datetime')";
$corpquery="INSERT INTO corpentries(fullname,state,batch,code,ppa,imgid,entrydate,unidepartment,imgpath)VALUES('$fullname','$state','$batch','$code','$ppa','$imgid','$datetime','$unidepartment','$imagepathactual')";

// echo $corpquery."<br>";
$corprun=mysqli_query($wasl, $corpquery)or die(mysql_error());
}
header("location:../edit.php");
}else if($entryvariant=="importentries"){
	$inputFileName=$_FILES['importfile']['tmp_name'];
	//  Read your Excel workbook
			require_once 'phpexcel/Classes/PHPExcel/IOFactory.php';
		  try {
		      $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		      $objReader = PHPExcel_IOFactory::createReader($inputFileType);
		      $objPHPExcel = $objReader->load($inputFileName);
		  } catch(Exception $e) {
		      die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
		  }
	// STORE ALL IMAGES FROM FILE
	$imgarray=array();
foreach ($objPHPExcel->getActiveSheet()->getDrawingCollection() as $drawing) {
    if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {

        ob_start();

        call_user_func(

            $drawing->getRenderingFunction(),

            $drawing->getImageResource()
        );
            // echo  $drawing->getName();

        $imageContents = ob_get_contents();
        print($imageContents);
        ob_end_clean();
        echo "in here<br>";
    }else if($drawing instanceof PHPExcel_Worksheet_Drawing){
    		echo "it entered here ";	
            // echo  $drawing->getName()."<br>";
            // echo  $drawing->getImageIndex()."<br>";
            $zipReader = fopen($drawing->getPath(),'r');
	        $imageContents = '';
	        while (!feof($zipReader)) {
	            $imageContents .= fread($zipReader,1024);
	        }
	        fclose($zipReader);
	        $extension = $drawing->getExtension();
            $myFileName = ''.str_replace("/", "-", $drawing->getName()).'.'.$extension;
		    file_put_contents("../files/originals/$myFileName",$imageContents);
		    file_put_contents("../files/thumbnails/$myFileName",$imageContents);
		    $imgarray[''.str_replace("/", "-", $drawing->getName()).'']="./files/originals/$myFileName";
    }else{
    	echo "nothing worked with the images";
    }

}

		  //  Get worksheet dimensions
		  $sheet = $objPHPExcel->getSheet(0); 
		  $highestRow = $sheet->getHighestRow(); 
		  $highestColumn = $sheet->getHighestColumn();
			$count=1;
		for ($row = 1; $row <= $highestRow; $row++){ 
		  	$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                      NULL,
                                      TRUE,
                                        FALSE);
	        for ($j=0; $j <$highestRow ; $j++) { 
	        	// echo $j;
	        	// echo $rowData[0][0];
                if(isset($rowData[0][$j])&&$rowData[0][$j]==$rowData[0][1]&&$rowData[0][1]!==""&&strtolower($rowData[0][0])!=="photo"){
					global $wasl;
	        		$fullname=mysqli_real_escape_string($wasl, $rowData[0][1]);
	        		$state=mysqli_real_escape_string($wasl, $rowData[0][2]);
	        		$batch=mysqli_real_escape_string($wasl, $rowData[0][3]);
	        		$code=mysqli_real_escape_string($wasl, $rowData[0][4]);
	        		$statecode2=$state."/".$batch."/".$code;
	        		$statecode=mysqli_real_escape_string($wasl, $rowData[0][5]);
	        		$ppa=mysqli_real_escape_string($wasl, $rowData[0][6]);
					$datetime= date("D, d M Y H:i:s");
					$unidepartment = mysqli_real_escape_string($wasl, $rowData[0][7]);
					$imagepathactual = mysqli_real_escape_string($wasl, $rowData[0][8]);
	        		echo $fullname." - ".$statecode." Preparing....<br>";
	        		$querytest="SELECT * FROM corpentries WHERE fullname='$fullname' OR state='$state' AND batch='$batch' AND code='$code'";
                        // echo $querytest."<br>";
	             	$runtest=mysqli_query($wasl, $querytest)or die(mysql_error()." Line 171<BR>");
	             	$numrowstest=mysqli_num_rows($runtest);
	             	if($numrowstest<1){
						$uid=getNextId("corpentries");
						$imgid=getNextId("media");
						$corpquery="INSERT INTO corpentries(fullname,state,batch,code,ppa,imgid,entrydate,unidepartment)VALUES('$fullname','$state','$batch','$code','$ppa','$imgid','$datetime','$unidepartment','$imagepathactual')";
						// $corpquery="INSERT INTO corpentries(fullname,state,batch,code,ppa,imgid,entrydate,unidepartment)VALUES('$fullname','$state','$batch','$code','$ppa','$imagepathactual','$datetime','$unidepartment')";
						// echo $corpquery."<br>";
						$corprun=mysqli_query($wasl, $corpquery)or die(mysql_error());
	        			echo $fullname." - ".$statecode." stored<br><br>";
	        		
	        			if(isset($imgarray["".str_replace("/","-",$statecode2).""])&&$imgarray["".str_replace("/","-",$statecode2).""]!==""){
						$imgpresent="yea baby";
						$filename=".".$imgarray["".str_replace("/","-",$statecode2).""];
					    $filetypedata=getFileType($filename);
					  	if($filetypedata=="image"){
							$image=$filename;
							if(isset($imagepath)){
								unset($imagepath);
								unset($imagesize);
						   	}
						$imagepath=array();
						$imagesize=array();
						// $imgpath[0]='../files/originals/';
						$imgpath[0]='../files/thumbnails/';
						// $imgsize[0]="default";
						$imgsize[0]=",195";
						// echo count($imgsize);
						$acceptedsize="";
						// $imgouts=genericImageUpload($image,"varying",$imgpath,$imgsize,$acceptedsize);
						// $len=strlen($imgouts[0]);
						// echo $imgouts[0]."<br>";
						$contentpath=$imgarray["".str_replace("/","-",$statecode2).""]; /*substr($imgouts[0], 1,$len)*/
						// $len2=strlen($imgouts[0]);
						// echo '<img src=".'.$contentpath.'" /><br>';
						$contentpath2=$imgarray["".str_replace("/","-",$statecode2).""];
						// echo '<img src=".'.$contentpath2.'" /><br>';
						// get image size details
						$filedata=getFileDetails(".".$imgarray["".str_replace("/","-",$statecode2).""],"image");
						$filesize=$filedata['size'];
						$width=$filedata['width'];
						$height=$filedata['height'];
						$contenttype='image';
						// $imgid=getNextId("media");
						$mediaquery="INSERT INTO media(ownerid,ownertype,details,mediatype,location,filesize,width,height)VALUES('$uid','corper','$contentpath2','$contenttype','$contentpath','$filesize','$width','$height')";
						// echo $mediaquery."<br>";
						$mediarun=mysqli_query($wasl, $mediaquery)or die(mysql_error());
						}
					}else{
						$imgpresent="No man";
					}
	             		if($imgpresent=="No man"){
							// $imgid=getNextId("media");
							$mediaquery="INSERT INTO media(ownerid,ownertype,details,mediatype,location,filesize,width,height)VALUES('$uid','corper','','','','','','')";
							$mediarun=mysqli_query($wasl, $mediaquery)or die(mysql_error());
	             		}
	             	}else{
	        			echo $fullname." - ".$statecode." Already Exists<br><br>";

	             	}
                        // echo $query."<br>";
	        	}
	        		$count++;
	        }
		  }
		  


	// header("location:../edit.php");
}
?>