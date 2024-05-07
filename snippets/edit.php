<?php
include('connection.php');
$entryvariant=mysql_real_escape_string($_POST['entryvariant']);
$entryid=$_POST['entryid'];
$userrequest="";
if(isset($_POST['userrequest'])&&$_POST['userrequest']!==""){
	$userrequest=$_POST['userrequest'];
}
if($entryvariant=="editsinglecorpmember"){
	$entrycount=$_POST['entrycount'];
		$imgid=$_POST['imgid'];
	for($i=1;$i<=$entrycount;$i++){
		$fullname=mysql_real_escape_string($_POST['name'.$i.'']);
		
		genericSingleUpdate("corpentries","fullname",$fullname,"id",$entryid);
		$state=mysql_real_escape_string($_POST['state'.$i.'']);
		genericSingleUpdate("corpentries","state",$state,"id",$entryid);
		$batch=mysql_real_escape_string($_POST['batch'.$i.'']);
		genericSingleUpdate("corpentries","batch",$batch,"id",$entryid);
		$code=mysql_real_escape_string($_POST['code'.$i.'']);
		genericSingleUpdate("corpentries","code",$code,"id",$entryid);
		$ppa=mysql_real_escape_string($_POST['ppa'.$i.'']);
		genericSingleUpdate("corpentries","ppa",$ppa,"id",$entryid);
		$status=mysql_real_escape_string($_POST['status'.$i.'']);
		genericSingleUpdate("corpentries","status",$status,"id",$entryid);
		// $datetime= date("D, d M Y H:i:s");
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
		genericSingleUpdate("media","location",$contentpath,"ownerid",$entryid);
		genericSingleUpdate("media","details",$contentpath2,"ownerid",$entryid);
		genericSingleUpdate("media","filesize",$filesize,"ownerid",$entryid);
		genericSingleUpdate("media","width",$width,"ownerid",$entryid);
		genericSingleUpdate("media","height",$height,"ownerid",$entryid);	
		$realprevpic=$_POST['realpathcover'];
		$realprevpicthumb=$_POST['realpaththumb'];
		if(file_exists($realprevpic)){
		unlink($realprevpic);
		}
		if(file_exists($realprevpicthumb)){
		unlink($realprevpicthumb);
		}

		}

	}

}
	header("location:../edit.php");
}
?>