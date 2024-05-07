<?php
include('connection.php');
if(isset($_GET['displaytype'])){
$displaytype=$_GET['displaytype'];
$extraval=$_GET['extraval'];
}elseif (isset($_POST['displaytype'])) {
$displaytype2=$_GET['displaytype'];	
}


if($displaytype==""){
// echo $displaytype;

}elseif ($displaytype=="calenderout") {
	$extraout=explode("-:-", $extraval);
	// $theme=mysql_real_escape_string($_GET['theme']);
	$ecount=count($extraout);
	if($ecount>3){
	$day=$extraout[0];
	$month=$extraout[1];
	$year=$extraout[2];
	$data_target=$extraout[3];
	$theme=$extraout[4];
	}
	if(count($extraout)>4){
		$data_target=array();
		$data_target[0]=$extraout[3];
		$data_target[1]=$extraout[5];
	}
	// echo $day.$month.$year;
	$outs=calenderOut($day,$month,$year,'',$data_target,$theme,'');
	// echo $theme;
	echo $outs['totaldaysout'];
}elseif($displaytype=="editsinglecorpmember"){
$editid=$_GET['editid'];
$outs=getSingleCorpPhoto($editid);
echo $outs['adminoutputtwo'];
}elseif($displaytype=="viewall"){
$outs=getAllCorpPhotos("","","print",""); echo $outs['printoutput'];

}elseif($displaytype=="searchname"||$displaytype=="searchname2"){
$searchdata=$_GET['searchdata'];
$outs=getAllCorpPhotos("","","$displaytype","$searchdata");
if($displaytype=="searchname"){
	echo $outs['printoutput'];
}else if($displaytype=="searchname2"){
	echo $outs['adminoutput'];

}
}elseif($displaytype=="vcrange"||$displaytype=="vcrange2"){
$searchdata=$_GET['searchdata'];
// echo $searchdata;
$bsearch=explode(";",$searchdata);
if(count($bsearch)==1){
	$bsearch[1]=0;
}
if(!is_numeric($bsearch[0])||!is_numeric($bsearch[1])){
echo "Improper construction of search parameter, follow instructions and try again";
}else{
if(count($bsearch)>4){
echo "Improper construction of search parameter, follow instructions and try again";
}else{	
$outs=getAllCorpPhotos("","","$displaytype",$bsearch);
if($displaytype=="vcrange"){
	echo $outs['printoutput'];
}else if($displaytype=="vcrange2"){
	echo $outs['adminoutput'];

}
}
}
}elseif($displaytype=="pparange"){
$searchdata=$_GET['searchdata'];
$outs=getAllCorpPhotos("","","$displaytype","$searchdata");
echo $outs['printoutput'];
}elseif ($displaytype=="paginationpages") {
	# code...
	// echo $displaytype;
	$curquery=$_GET['curquery'];
	$testq=strpos($curquery,"%'");
	if($testq===0||$testq===true||$testq>0){
	$curquery=str_replace("%'","%",$curquery);
	}
	$outs=paginatejavascript($curquery);
	echo $outs['pageout'];
}elseif ($displaytype=="paginationpagesout") {
	# code...
	// echo $displaytype;
	$curquery=$_GET['curquery'];
	$testq=strpos($curquery,"%'");
	if($testq===0||$testq===true||$testq>0){
	$curquery=str_replace("%'","%",$curquery);
	}
	$outs=paginatejavascript($curquery);
	$limit=$outs['limit'];
	global $wasl;
	$type=mysqli_real_escape_string($wasl,$_GET['outputtype']);
	$query2="".$curquery.$outs['limit']."";
	$run=mysqli_query($wasl,$query2)or die(mysql_error());
	$otype=$type;
	$nexttype=strpos($type,'mediacontent');
	$nexttype2=strpos($type,'vcrange2');
	$nexttype3=strpos($type,'searchname2');
	$nexttype4=strpos($type,'subscribers');
	if($nexttype===0||$nexttype===true||$nexttype>0){
	$type="mediacontent";
	}elseif ($nexttype2===0||$nexttype2===true||$nexttype2>0) {
		# code...
	$type="vcrange2";
	}elseif ($nexttype3===0||$nexttype3===true||$nexttype3>0) {
		# code...
	$type="searchname2";
	}elseif ($nexttype4===0||$nexttype4===true||$nexttype4>0) {
		# code...
	$type="subscribers";
	}
	$numrows=mysqli_num_rows($run);
	if($type!==""){
	if($numrows>0){
	if ($type=="mediacontent") {
		# code...
		$data=explode('|',$otype);
	$etype=$data[1];
	$outs=getAllContentMedia("admin",$limit,$etype);
	echo $outs['adminoutputtwo'];
	}else if($type=="vcrange2"){
		$data=explode('|',$otype);
		$etype=$data[0];
		array_shift($data);
		$outs=getAllCorpPhotos("",$limit,$type,$data);
		echo $outs['adminoutputtwo'];
	}else if($type=="searchname2"){
		$data=explode(';',$otype);
		array_shift($data);
		$dataout="";
		foreach($data as $content){
			$dataout==""?$dataout=$content:$dataout.=";".$content;
		}
		// echo $dataout;
		$outs=getAllCorpPhotos("",$limit,$type,$dataout);
		echo $outs['adminoutputtwo'];
	}else if($type=="corpentries"){
		$outs=getAllCorpPhotos("admin",$limit,"","");
		echo $outs['adminoutputtwo'];
	}	
	}else{
			echo'No database entries ';
		
	}
	}elseif ($type=="") {
		# code...
	}elseif ($displaytype=="newpagination") {
		# code...
	}
}elseif ($displaytype=="delete") {
	# code...
	$mediaid=$extraval;
$outs=deleteMedia($mediaid);
echo $outs;
}elseif($displaytype=="mainsearch"){

}
?>