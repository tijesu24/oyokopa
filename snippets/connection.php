<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
require_once 'paginator.class.php';
require_once "gifresizer.class.php";    //Including our class $host_addr="http://localhost/muyiwasblog/";
require_once 'html2text.class.php';
require_once('php_image_magician.php');
/*require_once "SocialAutoPoster/SocialAutoPoster.php";
require_once('tmhOAuth-master/tmhOAuth.php');
require 'PHPMailer-master/PHPMailerAutoload.php';*/
date_default_timezone_set("Africa/Lagos");
//$host_target_addr="http://".$_SERVER['HTTP_HOST']."/";
$host_addr="http://".$_SERVER['HTTP_HOST']."/oyokopa/";
//$host_addr="http://localhost/prettyphotos/";
$host_email_addr="set default email host addr";
//set to true on upload emails
$host_email_send=false;
$hostname_pvmart = "localhost";
$db = "photoprettify";
$username_pvmart = "root";
//change pword when uploading to server
$password_pvmart = "";
global $wasl;
$wasl = mysqli_connect($hostname_pvmart, $username_pvmart, $password_pvmart);

if (!$wasl) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select the database
if (!mysqli_select_db($wasl, $db)) {
    die("Database selection failed: " . mysqli_error($wasl));
}
function getExtension($str) {
    $i = strrpos($str,".");
    if (!$i) { return false; }
    $l = strlen($str) - $i;
    $ext = substr($str,$i+1,$l);
    return $ext;
}
function getFilename($filepath){
    $i = strrpos($filepath,"/");
    if (!$i) { return $filepath; }
    $filename=explode("/",$filepath);
    $tot=count($filename);
    return $filename[$tot-2];
}

function getFileDetails($filepath,$typeoffile){
    $retvals=array();
    file_exists($filepath)?$filesize=filesize($filepath):$filesize="0B";
    if($typeoffile=="image"){
        if($filesize!=="0B"&&$filesize>0){
            list($width,$height)=getimagesize($filepath);
            $filesize=$filesize/1024;
            $filesize=round($filesize, 0, PHP_ROUND_HALF_UP);
            if(strlen($filesize)>3){
                $filesize=$filesize/1024;
                $filesize=round($filesize,2); 
                $filesize="".$filesize."MB";
            }else{
                $filesize="".$filesize."KB";
            }
        }
        $retvals['width']=$width;
        $retvals['height']=$height;
        $retvals['size']=$filesize;
    }else{
        if($filesize!=="0B"&&$filesize>0){
            list($width,$height)=getimagesize($filepath);
            $filesize=$filesize/1024;
            $filesize=round($filesize, 0, PHP_ROUND_HALF_UP);
            if(strlen($filesize)>3){
                $filesize=$filesize/1024;
                $filesize=round($filesize,2); 
                $filesize="".$filesize."MB";
            }else{
                $filesize="".$filesize."KB";
            }
        }
        $retvals['size']=$filesize;
    }

    return $retvals;
}
//for performing targeted single update functions
function genericSingleUpdate($tablename,$updateField,$updateValue,$orderfield,$ordervalue){
    $ordervalues="";
    if($tablename!==""&&$updateField!==""&&$orderfield!==""&&$ordervalue!==""){
        if(is_array($orderfield) && is_array($ordervalue)){
            $orderfieldvals=count($orderfield)-1;
            for($i=0;$i<=$orderfieldvals;$i++){
                if($i!==$orderfieldvals){
                    $ordervalues.="".$orderfield[$i]."='".$ordervalue[$i]."' AND ";
                }else{
                    $ordervalues.=" ".$orderfield[$i]."='".$ordervalue[$i]."'";
                }
            }
            $query="UPDATE $tablename SET $updateField='$updateValue' WHERE $ordervalues";
        }else{
            $query="UPDATE $tablename SET $updateField='$updateValue' WHERE $orderfield=$ordervalue";
        }
        //// echo $query;
        if($updateValue!==""){
            global $wasl;
$run=mysqli_query($wasl,$query)or die(mysql_error());        }
    }else{
        die('cant Update with empty value in critical column'); 
    }
}
function genericMultipleInsert($tablename,$colname,$colval){
    $totalcolnamecount=count($colname)-1;
    $totalcolvalscount=count($colval)-1;
    // // echo $totalcolvalscount;
    $columnnames="";
    $columnvalues="";
    for($i=0;$i<=$totalcolnamecount;$i++){
        if ($i==0) {
            //  // echo $colname[$i];
            $columnnames.="".$colname[$i]."";
            //// echo $columnnames.'<br>';
        }else{
            //    // echo $colname[$i];
            $columnnames.=",".$colname[$i]."";

        }
    }
    //// echo '<br>'.$totalcolvalscount.'<br><br>';
    $increment=$totalcolnamecount+1;
    for($i=0;$i<=$totalcolvalscount;$i+=$increment){
        $nextsize=$i+$totalcolnamecount;
        //// echo $nextsize.'<br>';
        //// echo $i.'<br>';
        $columnvalues="";
        for($t=$i;$t<=$nextsize;$t++){

            //// echo $t.'<br>'.$i.'<br>';
            if ($t==$i) {
                $columnvalues.=''.$colval[$t].'';
                //// echo $columnvalues.'<br>';
            }else{
                $columnvalues.=','.$colval[$t].'';
            }
        }
        $query="INSERT INTO $tablename ($columnnames)VALUES($columnvalues)";
        // // echo $query.'<br>';
        global $wasl;
$run=mysqli_query($wasl,$query)or die(mysql_error());    }
};
function image_check_memory_usage($img, $max_breedte, $max_hoogte){
    if(file_exists($img)){
        $K64 = 65536;    // number of bytes in 64K
        $memory_usage = memory_get_usage();
        $memory_limit = abs(intval(str_replace('M','',ini_get('memory_limit'))*1024*1024));
        $image_properties = getimagesize($img);
        $image_width = $image_properties[0];
        $image_height = $image_properties[1];
        $image_bits = $image_properties['bits'];
        $image_memory_usage = $K64 + ($image_width * $image_height * ($image_bits )  * 2);
        $thumb_memory_usage = $K64 + ($max_breedte * $max_hoogte * ($image_bits ) * 2);
        $memory_needed = intval($memory_usage + $image_memory_usage + $thumb_memory_usage);

        if($memory_needed > $memory_limit){
            ini_set('memory_limit',(intval($memory_needed/1024/1024)+5) . 'M');
            if(ini_get('memory_limit') == (intval($memory_needed/1024/1024)+5) . 'M'){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }else{
        return false;
    }
}
function fix_dirname($str){
    return str_replace('~',' ',dirname(str_replace(' ','~',$str)));
}

function fix_strtoupper($str){
    if( function_exists( 'mb_strtoupper' ) )
        return mb_strtoupper($str);
    else
        return strtoupper($str);
}


function fix_strtolower($str){
    if( function_exists( 'mb_strtoupper' ) )
        return mb_strtolower($str);
    else
        return strtolower($str);
}
function getSizeByFixedWidth($newWidth,$newHeight,$width,$height,$forceStretch)
{
    // *** If forcing is off...
    if ($forceStretch===false) {

        // *** ...check if actual width is less than target width
        if ($width < $newWidth) {
            return array('optimalWidth' => $width, 'optimalHeight' => $height);
        }
    }

    $ratio = $height / $width;

    $newHeight = $newWidth * $ratio;

    //return $newHeight;
    return array('optimalWidth' => $newWidth, 'optimalHeight' => $newHeight);
}
function getSizeByFixedHeight($newWidth,$newHeight,$width,$height,$forceStretch)
{
    // *** If forcing is off...
    if ($forceStretch===false) {

        // *** ...check if actual height is less than target height
        if ($height < $newHeight) {
            return array('optimalWidth' => $width, 'optimalHeight' => $height);
        }
    }

    $ratio = $width / $height;

    $newWidth = $newHeight * $ratio;

    //return $newWidth;
    return array('optimalWidth' => $newWidth, 'optimalHeight' => $newHeight);
}
function getSizeByAuto($newWidth,$newHeight,$width,$height,$forceStretch)
    # Purpose:    Depending on the height, choose to resize by 0, 1, or 2
    # Param in:   The new height and new width
    # Notes:
    #
{
    // *** If forcing is off...
    if ($forceStretch===false) {

        // *** ...check if actual size is less than target size
        if ($width < $newWidth && $height < $newHeight) {
            return array('optimalWidth' => $width, 'optimalHeight' => $height);
        }
    }

    if ($height < $width)
        // *** Image to be resized is wider (landscape)
    {
        //$optimalWidth = $newWidth;
        //$optimalHeight= $getSizeByFixedWidth($newWidth);

        $dimensionsArray = $getSizeByFixedWidth($newWidth, $newHeight);
        $optimalWidth = $dimensionsArray['optimalWidth'];
        $optimalHeight = $dimensionsArray['optimalHeight'];
    }
    elseif ($height > $width)
        // *** Image to be resized is taller (portrait)
    {
        //$optimalWidth = $getSizeByFixedHeight($newHeight);
        //$optimalHeight= $newHeight;

        $dimensionsArray = $getSizeByFixedHeight($newWidth, $newHeight);
        $optimalWidth = $dimensionsArray['optimalWidth'];
        $optimalHeight = $dimensionsArray['optimalHeight'];
    }
    else
        // *** Image to be resizerd is a square
    {

        if ($newHeight < $newWidth) {
            //$optimalWidth = $newWidth;
            //$optimalHeight= $getSizeByFixedWidth($newWidth);
            $dimensionsArray = $getSizeByFixedWidth($newWidth, $newHeight);
            $optimalWidth = $dimensionsArray['optimalWidth'];
            $optimalHeight = $dimensionsArray['optimalHeight'];
        } else if ($newHeight > $newWidth) {
            //$optimalWidth = $getSizeByFixedHeight($newHeight);
            //$optimalHeight= $newHeight;
            $dimensionsArray = $getSizeByFixedHeight($newWidth, $newHeight);
            $optimalWidth = $dimensionsArray['optimalWidth'];
            $optimalHeight = $dimensionsArray['optimalHeight'];
        } else {
            // *** Sqaure being resized to a square
            $optimalWidth = $newWidth;
            $optimalHeight= $newHeight;
        }
    }

    return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
}
function getDimensions($newWidth, $newHeight, $width,$height,$forceStretch,$option)
    #
    #       To clarify the $option input:
    #               0 = The exact height and width dimensions you set.
    #               1 = Whatever height is passed in will be the height that
    #                   is set. The width will be calculated and set automatically
    #                   to a the value that keeps the original aspect ratio.
    #               2 = The same but based on the width.
    #               3 = Depending whether the image is landscape or portrait, this
    #                   will automatically determine whether to resize via
    #                   dimension 1,2 or 0.
{

    switch (strval($option))
    {
        case '0':
        case 'exact':
            $optimalWidth = $newWidth;
            $optimalHeight= $newHeight;
            break;
        case '1':
        case 'portrait':
            $dimensionsArray = getSizeByFixedHeight($newWidth, $newHeight,$width,$height,$forceStretch);
            $optimalWidth = round($dimensionsArray['optimalWidth'],0, PHP_ROUND_HALF_UP);
            $optimalHeight = round($dimensionsArray['optimalHeight'],0, PHP_ROUND_HALF_UP);
            break;
        case '2':
        case 'landscape':
            $dimensionsArray = getSizeByFixedWidth($newWidth,$newHeight,$width,$height,$forceStretch);
            $optimalWidth = round($dimensionsArray['optimalWidth'],0, PHP_ROUND_HALF_UP);
            $optimalHeight = round($dimensionsArray['optimalHeight'],0, PHP_ROUND_HALF_UP);
            break;
        case '3':
        case 'auto':
            $dimensionsArray = getSizeByAuto($newWidth, $newHeight,$width,$height,$forceStretch);
            $optimalWidth = round($dimensionsArray['optimalWidth'],0, PHP_ROUND_HALF_UP);
            $optimalHeight = round($dimensionsArray['optimalHeight'],0, PHP_ROUND_HALF_UP);
            break;
    }

    return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
}
function imageResize($imagefile,$newwidth,$newheight,$imgextension,$watermarkval,$watermarkimg,$imgpath){
    /*
My image Resizer
resizes images based on the above passed parameters
####First Parameter $imagefile
-the image itself 
####Second Parameter $newwidth
-the new width of the image
####Third Parameter $newheight
-the new height of the image
####Fourth Parameter $imgextension
-the type of the image
####Fifth Parameter $watermarkvalue
-the watermark value for the image, values are"true" if water mark is
to be added to the image or "false" if not.
####Sixth Parameter $watermarkimg
-watermark image file path
####Seventh Parameter $imgpath
-path to place the new file in, must have the name of the new file
present in it
*/
    if(is_array($imagefile)){
        // $imagefilename=$imagefile[2];
        $originalimage=$imagefile[0];
        $imagefile2=$imagefile[1];
        list($width,$height)=getimagesize($originalimage);
        $forceStretch=true;
        if ($newwidth==""&&$newheight!=="") {
            $option=1;$newwidth=0;

        }elseif($newwidth!==""&&$newheight==""){
            $option=2;
            $newheight=0; 
        }elseif ($newwidth!==""&&$newwidth>0&&$newheight!==""&&$newheight>0) {
            # code...
            $option=0;
        }else{
            $option=3;
        }
    }else{
        list($width,$height)=getimagesize($imagefile);
    }

    $tmp="oops something went wrong";

    if($imgextension=="jpeg"||$imgextension=="jpg"){
        if($watermarkval===true){
            if(is_array($imagefile)){

            }else{

            }
        }else{
            if(is_array($imagefile)){
                // $matchtwo=checkExistingFile($uploadimgpaths[$i],$imagename2);
                if(image_check_memory_usage($originalimage,$newwidth,$newheight)){
                    $magicianObj = new imageLib($originalimage);
                    // echo $newwidth.$newheight.$option."<br>here";
                    $magicianObj -> resizeImage($newwidth, $newheight, "".$option."");
                    $magicianObj -> saveImage($imagefile2,80);
                    return true;
                }
            }else{
                $src = imagecreatefromjpeg($imagefile);
                $tmp=imagecreatetruecolor($newwidth,$newheight);
                imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
                imagejpeg($tmp,$imgpath,100);
                imagedestroy($src);
                imagedestroy($tmp);
                $tmp="successful";  
            }




        }
    }elseif ($imgextension=="gif") {
        if($watermarkval===true){

        }else{
            if(is_array($imagefile)){
                $gr = new gifresizer;    //New Instance Of GIFResizer 
                $gr->temp_dir = "frames"; //Used for extracting GIF Animation Frames
                $dimensionwork=getDimensions($newwidth,$newheight,$width,$height,$forceStretch,$option); 
                $cwidth=$dimensionwork['optimalWidth'];
                $cheight=$dimensionwork['optimalHeight'];
                $gr->resize($originalimage,$imagefile2,$cheight,$cheight); //Resizing the animation into a new file. 
            }else{
                $src = imagecreatefromgif($imagefile);
                $tmp=imagecreatetruecolor($newwidth,$newheight);
                imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
                imagegif($tmp,$imgpath);
                imagedestroy($src);
                imagedestroy($tmp);
                $tmp="successful";  
            }



        }


    }elseif ($imgextension=="png") {
        if($watermarkval===true){

        }else{
            if(is_array($imagefile)){
                if(image_check_memory_usage($originalimage,$newwidth,$newheight)){

                    $magicianObj = new imageLib($originalimage);
                    $magicianObj -> resizeImage($newwidth, $newheight, "".$option."");
                    $magicianObj -> saveImage($imagefile2,80);
                    return true;
                }
            }else{
                $src = @imagecreatefrompng($imagefile);
                $tmp=imagecreatetruecolor($newwidth,$newheight);
                imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
                imagePNG($tmp,$imgpath);
                imagedestroy($src);
                imagedestroy($tmp);
                $tmp="successful";
            }
        }
    }
    return $tmp;
}
function checkExistingFile($filepath,$filename){
    $retvals=array();
    $files=array();
    $dhandle= opendir($filepath);
    if($dhandle){
        while(false !== ($fname = readdir($dhandle))){
            if(($fname!='.') && ($fname!='..') && ($fname!= basename($_SERVER['PHP_SELF']))){
                //check if the file in mention is a directory , if no add it to the files array
                $files[]=(is_dir("./$fname")) ? "":$fname;
            }
            $totalfiles=count($files);
            $retvals['totalfilecount']=$totalfiles;
            $arraycount=$totalfiles-1;
            $match="false";
            for($i=0;$i<=$arraycount;$i++){
                if($filename==$files[$i]){
                    $match="true";
                }
            }
        }
        $testfile=$filepath.$filename;
        $httppresent=strpos($filepath,"http://localhost/");
        $httppresent2=strpos($filepath,"http://");
        $httppresent3=strpos($filepath,"ssl://");
        if($httppresent===0){
            $patharr=explode("/",$filepath);
            $count=count($patharr);
            $end=$count-1;
            $start=3;
            $construct="";
            for($i=4;$i<=$end;$i++){
                $construct==""?$construct.="../".$patharr[$i]."/":($construct!==""&&$i!==$end?$construct.=$patharr[$i]."/":($construct!==""&&$i==$end?$construct.=$patharr[$i]:$construct=$construct));
            }
            echo $construct;
            $testfile=$construct;
        }elseif ($httppresent===0) {
            # code...
            $patharr=explode("/",$filepath);
            $count=count($patharr);
            $end=$count-1;
            $start=3;
            $construct="";
            for($i=3;$i<=$end;$i++){
                $construct==""?$construct.="../".$patharr[$i]."/":($construct!==""&&$i!==$end?$construct.=$patharr[$i]."/":($construct!==""&&$i==$end?$construct.=$patharr[$i]:$construct=$construct));
            }
            // echo $construct;
            $testfile=$construct;
        }
        if(file_exists($testfile)){
            $match="true";  
            // echo $match;
        }
        $retvals['matchval']=$match;
        $extensions=getExtension($filename);
        $extension=strtolower($extensions);
        closedir($dhandle);
        return $retvals;
    }
}
function getRelativePathToSnippets($filepath){
    $retvals=array();
    $httppresent=strpos($filepath,"http://localhost/");
    $httppresent2=strpos($filepath,"http://");
    $httppresent3=strpos($filepath,"ssl://");
    if($httppresent===0){
        $patharr=explode("/",$filepath);
        $count=count($patharr);
        $end=$count-1;
        $start=3;
        $construct="";
        for($i=4;$i<=$end;$i++){
            $construct==""?$construct.="../".$patharr[$i]."/":($construct!==""&&$i!==$end?$construct.=$patharr[$i]."/":($construct!==""&&$i==$end?$construct.=$patharr[$i]:$construct=$construct));
        }
        echo $construct;
        $retvals['testfile']=$construct;
    }elseif ($httppresent===0) {
        # code...
        $patharr=explode("/",$filepath);
        $count=count($patharr);
        $end=$count-1;
        $start=3;
        $construct="";
        for($i=3;$i<=$end;$i++){
            $construct==""?$construct.="../".$patharr[$i]."/":($construct!==""&&$i!==$end?$construct.=$patharr[$i]."/":($construct!==""&&$i==$end?$construct.=$patharr[$i]:$construct=$construct));
        }
        // echo $construct;
        $retvals['testfile']=$construct;
    }else{
        $retvals['testfile']=$filepath;
    }
    return $retvals;
}
function getFileType($filename){
    $entrytype="";
    if(isset($_FILES[''.$filename.'']['name'])){
        $filerealname=$_FILES[''.$filename.'']['name'];
        //get img binaries
        $file=$_FILES[''.$filename.'']['tmp_name'];
        //get image type
        $filetype=$_FILES[''.$filename.'']['type'];
        //get image data size
        $filesize=$_FILES[''.$filename.'']['size'];
    }else{
        $filerealname=$filename;
    }
    $extension=getExtension($filerealname);
    $extension=strtolower($extension);
    if ($extension=="jpg"||$extension=="jpeg"||$extension=="png"||$extension=="gif") {
        # code...
        $entrytype="image";
    } elseif($extension=="mp4"||$extension=="3gp"||$extension=="flv"||$extension=="swf"||$extension=="webm") {
        $entrytype="video";   
    }elseif ($extension=="doc"||$extension=="docx"||$extension=="xls"||$extension=="xlsx"||$extension=="ppt"||$extension=="pptx") {
        # code...
        $entrytype="office";
    }elseif ($extension=="pdf") {
        # code...
        $entrytype="pdf";

    }elseif($extension=="mp3"||$extension=="ogg"||$extension=="wav"||$extension=="amr"){
        $entrytype="audio";
    }else{
        $entrytype="others";
    }
    return $entrytype;
}

function simpleUpload($filename,$path){
    $outs=array();
    $fileoutnormal="";
    $filerealname=$_FILES[''.$filename.'']['name'];
    //get img binaries
    $file=$_FILES[''.$filename.'']['tmp_name'];
    //get image type
    $filetype=$_FILES[''.$filename.'']['type'];
    //get image data size
    $anothersize="";
    $filefirstsize=$_FILES[''.$filename.'']['size'];
    $filesize=$filefirstsize/1024;
    //// echo $filefirstsize;
    $filesize=round($filesize, 0, PHP_ROUND_HALF_UP);
    if(strlen($filesize)>3){
        $filesize=$filesize/1024;
        $filesize=round($filesize,2); 
        $filesize="".$filesize."MB";
    }else{
        $filesize="".$filesize."KB";
    }
    $filename2 = stripslashes($filerealname);
    $extension=getExtension($filename2);
    $extension=strtolower($extension);
    $realimage=explode(".",$filename2);
    $dataname=$realimage[0];
    $match=checkExistingFile($path,$filerealname);
    if($match['matchval']=="true"){
        $nextentry=md5($match['totalfilecount']+1);
        $filerealname2=$dataname.$nextentry.".".$extension;
    }else{
        $filerealname2=$filerealname;
    }
    $filelocation=$path.$filerealname2;

    move_uploaded_file("$file","$filelocation");
    $fileoutnormal=str_replace("../", "./", $filelocation);
    $fileoutnormal==""?$fileoutnormal=$filelocation:$fileoutnormal=$fileoutnormal;
    $outs['filelocation']=$filelocation;
    $outs['fileoutnormal']=$fileoutnormal;
    $outs['filesize']=$filesize;
    $outs['realsize']=$filefirstsize;
    return $outs;
}

function genericImageUpload($imagefile,$uploadtype,$uploadimgpaths,$uploadimgsizes,$acceptedsize){
    /*
My upload manager.
-uploads image to server and returns the upload path of the image in an array for database storage
####First parameter $imagefile
-the image file to be uploaded obviously this.
####Second parameter $uploadtype
-type of upload, values are "single" and "varying",
*single=simple image migration to a folder using move_uploaded file 
function, end of story
*varying=for image upload in multiple sizes...this is inclusive of the 
original images size.
####Third parameter $uploadimgpaths
-this is an array containing the path to which to uplaod the image to,
it can also contain the paths for the varying image sizes if varying is
specified.
####Fourth parameter $uploadimgsizes
-this is an array of values in the form "width,height"..i.e "400,300"
it can also hold the value of "default" meaning that for that entry the 
original size of the image is to be used for that entry
####Fifth parameter $acceptedsize
-The accepted default size of the image when in multiples or otherwise
*/
    //get image name
    $imagename=$_FILES[''.$imagefile.'']['name'];
    //get img binaries
    $image=$_FILES[''.$imagefile.'']['tmp_name'];
    //get image type
    $imagetype=$_FILES[''.$imagefile.'']['type'];
    //get image data size
    $imagesize=$_FILES[''.$imagefile.'']['size'];

    if($imagename!==""){

        list($curimgwidth,$curimgheight)=getimagesize($image);

        $filename = stripslashes($_FILES[''.$imagefile.'']['name']);
        $extension=getExtension($filename);
        $extension=strtolower($extension);
        $realimage=explode(".",$filename);
        $imgname=$realimage[0];
        $imgpathcount=count($uploadimgpaths);
        $imgsizecount=count($uploadimgsizes);
        $defaultimglocation=$uploadimgpaths[0];
        $defaultsize=$uploadimgsizes[0];
        $path=array();
        if ($uploadtype=="varying") {
            if($imgpathcount>1&&$imgpathcount==$imgsizecount){
                $match=checkExistingFile($defaultimglocation,$imagename);
                if($match['matchval']=="true"){
                    $nextentry=md5($match['totalfilecount']+1);
                    $imagename2=$imgname.$nextentry.".".$extension;
                }else{
                    $imagename2=$imagename;
                }
                //upload original image
                $imagelocation=$defaultimglocation.$imagename2;
                move_uploaded_file("$image","$imagelocation");
                list($testwidth,$testheight)=getimagesize($imagelocation);
                $path[]=$imagelocation;
                $reallength=$imgpathcount-1;
                $locationentry=array();
                for($i=0;$i<=$reallength;$i++){
                    if($i!==0&&$uploadimgsizes[$i]!=="default"){
                        //check to make sure no conflict in next directory folder using the name
                        //of the currently uploaded file to maintain consistency
                        $match=checkExistingFile($uploadimgpaths[$i],$imagename);
                        // echo $match['matchval']."<br>".$uploadimgpaths[$i].$imagename2;
                        if($match['matchval']=="true"){
                            $nextentry=md5($match['totalfilecount']+1);
                            $imagename2=$imgname.$nextentry.".".$extension;
                            // echo "in here";
                        }else{
                            $imagename2=$imagename2;
                        }

                        $curpath=$uploadimgpaths[$i].$imagename2;
                        // echo $uploadimgsizes[$i]."the one".$curpath;
                        $cursize=explode(",",$uploadimgsizes[$i]);
                        $newwidth=$cursize[0];
                        $newheight=$cursize[1];
                        unset($locationentry);
                        $locationentry[]=$imagelocation;
                        $locationentry[]=$curpath;
                        imageResize($locationentry,$newwidth,$newheight,$extension,false,"",$curpath);
                        $path[]=$curpath;
                    }
                }
                // echo "<br>".$reallength." thereallengthafter<br>";

                // move_uploaded_file("$image","$imagelocation");
            }else{
                $match=checkExistingFile($defaultimglocation,$imagename);
                if($match['matchval']=="true"){
                    $nextentry=md5($match['totalfilecount']+1);
                    $imagename2=$imgname.$nextentry.".".$extension;
                }else{
                    $imagename2=$imagename;
                }
                $imagelocation=$defaultimglocation.$imagename2;
                move_uploaded_file("$image","$imagelocation");
                $path[]=$imagelocation;
            }   
        }else{
            $match=checkExistingFile($defaultimglocation,$imagename);
            if($match['matchval']=="true"){
                $nextentry=md5($match['totalfilecount']+1);
                $imagename2=$imgname.$nextentry.".".$extension;
                echo "in here";
            }else{
                $imagename2=$imagename;
            }
            $imagelocation=$defaultimglocation.$imagename2;
            move_uploaded_file("$image","$imagelocation");
            $exists=file_exists($imagelocation);
            $exists===true?$exist="true":$exist="false";
            echo $exist;
            if($acceptedsize!==""){
                $match=checkExistingFile($defaultimglocation,$imagename2);
                if($match['matchval']=="true"){
                    $nextentry=md5($match['totalfilecount']+1);
                    $imagename2=$imgname.$nextentry.".".$extension;
                }else{
                    $imagename2=$imagename;
                }
                $curpath=$defaultimglocation.$imagename2;
                echo $curpath;
                $acceptedsize=explode(",",$acceptedsize);
                $acceptedwidth=$acceptedsize[0];
                $acceptedheight=$acceptedsize[1];
                $locationentry=array();
                $locationentry[]=$imagelocation;
                $locationentry[]=$curpath;
                imageResize($locationentry,$acceptedwidth,$acceptedheight,$extension,false,"",$curpath);
                unlink($imagelocation);     
                $imagelocation=$curpath;
            }
            $path[]=$imagelocation;
        }
    }else{
        $path="no image";
    }
    return $path;

}
function produceImageFitSize($location,$contwidth,$contheight,$auto){
    global $host_addr;
    $output=array();
    $output['width']="20px";
    $output['height']="20px";
    $output['style']="";
    $output['truewidth']="";
    $output['trueheight']="";
    $style="";
    if($location!==""&&$contwidth!==""&&$contheight!==""){
        $imagefile=$host_addr.$location;
        $imagefile=str_replace(" ","%20",$imagefile);

        list($curwidth,$curheight)=getimagesize(''.$imagefile.'');
        $output['truewidth']=$curwidth;
        $output['trueheight']=$curheight;
        if ($contwidth>$contheight) {
            if($curwidth>$contwidth||$curheight>$contheight){

                if($curwidth>$curheight&&$curheight>=$contheight&&$curwidth>$contwidth){
                    $curwidth=$contwidth;

                    $style='cursor:pointer;height:'.$contheight.'px;width:'.$curwidth.'px;margin:auto;';
                }else if($curwidth<$curheight&&$curheight>$contheight&&$curwidth>$contwidth){
                    $extrawidth=floor($curwidth-$contheight);
                    $dimensionratio=$curwidth/$curheight;
                    // console.log(dimensionratio);

                    $curwidth=floor($contheight*$dimensionratio);
                    $widthdiff=$contwidth-$curwidth;
                    if($widthdiff>0){
                        $marginleft=floor($widthdiff/2);
                    }else{
                        $marginleft=0;
                    }
                    if($extrawidth>$contwidth&&$extrawidth>$contheight){
                        $extrawidth=$curwidth-$extrawidth;
                    }/*else if ($curwidth>$contwidth&&$curwidth>$contheight) {
    $curwidth=$curwidth-120;
}*/

                    $style='cursor:pointer;width:'.$curwidth.'px;height:'.$contheight.'px;margin-left:'.$marginleft.'px;';
                    if($auto=="on"){
                        $style='cursor:pointer;width:'.$curwidth.'px;height:'.$contheight.'px;';
                    }
                }else if($curwidth<$curheight&&$curheight>=$contheight&&$curwidth<$contwidth){
                    $dimensionratio=$curwidth/$curheight;

                    $curwidth=floor($contheight*$dimensionratio);
                    $widthdiff=$contwidth-$curwidth;
                    if($widthdiff>0){
                        $marginleft=floor($widthdiff/2);
                    }else{
                        $marginleft=0;
                    }

                    $style='cursor:pointer;width:'.$curwidth.'px;height:'.$contheight.'px;margin-left:'.$marginleft.'px;';
                }else if($curwidth>$curheight&&$curheight<$contheight&&$curwidth>$contwidth){
                    $dimensionratio=$curwidth/$curheight;
                    // console.log(dimensionratio);
                    $curwidth=floor($contheight*$dimensionratio);
                    $difference=$contheight-$curheight;
                    $margintop=floor($difference/2);
                    if($auto=="on"){
                        $style='cursor:pointer;width:'.$contwidth.'px;height:'.$curheight.'px;margin-top:auto;'; 
                    }else{      
                        $style='cursor:pointer;width:'.$contwidth.'px;height:'.$curheight.'px;margin-top:'.$margintop.'px;'; 
                    }
                }else if($curwidth<$curheight&&$curheight<$contheight){
                    $difference=$contheight-$curheight;
                    $margintop=floor($difference/2);
                    $curwidth=$curheight-10;
                    if($auto=="on"){
                        $style='cursor:pointer;width:'.$curwidth.'px;height:'.$curheight.'px;margin-top:auto;'; 
                    }else{      
                        $style='cursor:pointer;width:'.$curwidth.'px;height:'.$curheight.'px;margin-top:'.$margintop.'px;'; 
                    }
                }else if($curwidth==$curheight&&$curheight>$contheight){
                    $marginleft=$contwidth-$contheight;
                    $marginleft=$marginleft/2;
                    $style='cursor:pointer;width:'.$contheight.'px;height:'.$contheight.'px;margin-left:'.$marginleft.'px;'; 
                }

            }else{
                $difference=$contheight-$curheight;
                $margintop=floor($difference/2);
                $widthdiff=$contwidth-$curwidth;
                $marginleft=floor($widthdiff/2);
                $style='cursor:pointer;width:'.$curwidth.'px;height:'.$curheight.'px;margin-left:'.$marginleft.'px;margin-top:'.$margintop.'px;';
            }
        }elseif ($contwidth<$contheight) {
            # code...
        }
    }
    $style.='float:left;';
    $output['width']=$curwidth;
    $output['height']=$curheight;
    $output['style']=$style;
    return $output;
}

function getNextId($tablename){

    $query="SELECT * FROM $tablename";
    global $wasl;
$run=mysqli_query($wasl,$query);    $numrows=mysqli_num_rows($run);
    $nextid=$numrows+1;
    return $nextid;
}
function getSingleMediaData($partid,$parttype){
    global $wasl;
    $ordervalues="";
    if(is_array($partid) && is_array($parttype)){
        //proceed to generate combined test params for valid entry
        $orderfieldvals=count($parttype)-1;
        for($i=0;$i<=$orderfieldvals;$i++){
            if($i!==$orderfieldvals){
                $ordervalues.="".$parttype[$i]."='".$partid[$i]."' AND ";
            }else{
                $ordervalues.=" ".$parttype[$i]."='".$partid[$i]."'";
            }
            $query="SELECT * FROM media WHERE $ordervalues";
        }
    }else{
        $query="SELECT * FROM media WHERE $parttype=$partid";
    }
    global $wasl;
$run=mysqli_query($wasl,$query)or die(mysql_error());    $numrows=mysqli_num_rows($run);
    $row=array();
    $row=mysqli_fetch_assoc($run);
    return $row;
}


function getSingleMediaDataTwo($partid){
    $numrows=0;

    $query="SELECT * FROM media WHERE id=$partid";

    global $wasl;
$run=mysqli_query($wasl,$query)or die(mysql_error());    $numrows=mysqli_num_rows($run);


    $row=array();
    $row['adminoutput']="";
    $row['vieweroutput']="";
    if($numrows>0){
        $row=mysqli_fetch_assoc($run);
        $id=$row['id'];
        $ownerid=$row['ownerid'];
        $maintype=$row['maintype'];
        $mediatype=$row['mediatype'];
        $category=$row['categoryid'];
        $location=$row['location'];
        $details=$row['details'];
        $filesize=$row['filesize'];
        $width=$row['width'];
        $height=$row['height'];
        $title=$row['title'];
        $status=$row['status'];
    }
    return $row;
}
function checkEmail($email,$tablename,$columnname){
    $row=array();
    $query="SELECT * FROM $tablename where $columnname='$email'";
    global $wasl;
$run=mysqli_query($wasl,$query)or die(mysql_error());    $numrows=mysqli_num_rows($run);
    $row['testresult']="";
    if($numrows>0){
        $row=mysqli_fetch_assoc($run);
        $row['testresult']="matched";
    }else{
        $row['testresult']="unmatched";
    }
    return $row;
}
function produceOptionDates($from,$to,$display){
    $output="";
    if($display!==""){
        $output='<option value="">--'.$display.'--</option>';
    }
    if($to=="current"){
        $to=date('Y');
        for($i=$to;$i>=$from;$i--){
            $output.='<option value="'.$i.'">'.$i.'</option>';
        }
    }else{
        for($i=$to;$i>=$from;$i--){
            // echo $i;
            $output.='<option value="'.$i.'">'.$i.'</option>';
        } 
    }
    return $output;
}
function produceStates($countryid,$stateid){
    if(($countryid==""||$countryid==0)&&($stateid==""||$stateid==0)){ 
        $query="SELECT * FROM states";
    }
    if(($countryid!==""&&$countryid!==0)&&($stateid==""||$stateid==0)){
        $query="SELECT * FROM states where cid=$countryid"; 
    }
    if(($countryid==""||$countryid==0)&&($stateid!==""&&$stateid!==0)){
        $query="SELECT * FROM states where id=$stateid";  
    }

    global $wasl;
$run=mysqli_query($wasl,$query)or die(mysql_error().'line 472');

    $statetotal="";
    $state="";
    $row=array();
    while ($row=mysqli_fetch_assoc($run)) {
        # code...
        $statetotal.='<option value="'.$row['id'].'">'.$row['state'].'</option>';
        $state=$row['state'];
    }
    // $row2=mysql_fetch_array($run);

    $row['statename']=$state;
    $row['selectionoutput']='
<select name="state" class="curved2">
<option value="">--State--</option>
'.$statetotal.'
</select>
';
    $row['selectionoptions']='
'.$statetotal.'
';
    return $row;
}
function calenderOut($day,$month,$year,$viewer,$targetcontainermain,$theme,$controlquery){
    $occurencedates=array();
    if(is_array($targetcontainermain)){
        // echo "in here";
        $targetcontainer=$targetcontainermain[0];
        //for miscellaneous customization for any other entry you want to customize
        $controlviewtype=$targetcontainermain[1];
        // echo $controlviewtype;
        $occurencedates=explode(",",$controlviewtype);
        // echo "<br>".$occurencedates[1];
    }else{
        $controlviewtype="";
        $targetcontainer=$targetcontainermain;
    }
    $controloption='data-control="'.$controlviewtype.'"';
    global $host_addr,$host_target_addr;
    $row=array();
    $calHold="";
    $caltop="";
    $calDaynameholdcalday="";
    $calDaysHoldcalday="";
    $calDaysHoldweekend="";
    $calInfobox="";
    if($theme=="green"){
        $calHold='style="background:#053307;"';
        $caltop='style="color:#05D558;"';
        $calDaynameholdcalday='style="color:#05D558;"';
        $calDaysHoldcalday='style="color:#18FA7B;"';
        $calDaysHoldweekend='style="background:#D59D28;color:#fff;text-shadow:0px 0px 3px #DA2020;"';
        $calInfobox='style="color:#05D558;"';
    }elseif($theme=="red"){

    }
    $row['errorout']="Sorry you seem to have either left a value empty, or entered the wrong type of required data";
    //get current date value.
    $currentday=date('d');
    $currentmonth=date('m');
    $currentyear=date('Y');
    $currentdate="".$currentday."-".$currentmonth."-".$currentyear."";
    if($day!=="" && $month!=="" && $year!==""){
        //convert the month value into a numeric type if it is not already numeric
        $entrymonth=$month;
        //control values exceeding or less than the total number of months in the year
        if($entrymonth>12){
            $entrymonth=12;

        }else if ($entrymonth<1) {
            # code...
            $entrymonth=1;
        }
        if($entrymonth>0 && $entrymonth<13){
            $firstdate="1-".$entrymonth."-".$year."";
            $firstdate=strtotime($firstdate);
            $entrymonth2=date('F',$firstdate);
        }
        $row['errorout']="no error";
        $monthcount=31;
        $firstdate="1-".$entrymonth."-".$year."";
        $firstdate=strtotime($firstdate);
        $msd=date('D',$firstdate);
        $lst=0;
        $ledt="nada";
        $monthcount=date('t',$firstdate);
        //get number of days that
        $msd=="Mon"?$lst=1:($msd=="Tue"?$lst=2:($msd=="Wed"?$lst=3:($msd=="Thu"?$lst=4:($msd=="Fri"?$lst=5:($msd=="Sat"?$lst=6:$ledt)))));
        $excessdays="";
        $realdays="";
        if($lst>0){
            for($i=1;$i<=$lst;$i++){
                if($i==1){
                    $excessdays.='
<div id="calDay" name="" '.$calDaysHoldweekend.'title=""></div>
';  
                }else{
                    $excessdays.='
<div id="calDay" name="" title=""></div>
';  
                }
            }
        }

        for($t=1;$t<=$monthcount;$t++){
            $testdate=''.$t.'-'.$entrymonth.'-'.$year.'';
            $entrymonth<10&&strlen($entrymonth)<2?$testdatemonitor=''.$t.'-0'.$entrymonth.'-'.$year.'':$testdatemonitor=$testdate;
            $daytype="".date("l",mktime(0,0,0,$entrymonth,$t,$year))."";
            $today="";
            // echo $testdatemonitor." ".$occurencedates[0]." ".$occurencedates[1]."<br>";
            $calDaysHoldweekend2=$calDaysHoldweekend;
            $datapoint="";
            if($t==$currentday&&$entrymonth==$currentmonth&&$year==$currentyear){
                $today="today";
                $datapoint=$today;
            }elseif(in_array($testdatemonitor,$occurencedates)){
                $datapoint="eventdate";
            }

            if($daytype=="Sunday") {
                $teser=0;
                $today=="today"?$realdays.='<div id="calDay" name="'.$testdate.'" data-point="'.$datapoint.'" title="'.$t.'-'.$entrymonth.'-'.$year.'"data-target="'.$targetcontainer.'">'.$t.'</div>':$realdays.='<div id="calDay" name="'.$testdate.'" '.$calDaysHoldweekend.' data-point="'.$today.'" title="'.$t.'-'.$entrymonth.'-'.$year.'"data-target="'.$targetcontainer.'">'.$t.'</div>';

            }

            if($daytype!=="Sunday"){
                $realdays.='
<div id="calDay" name="'.$testdate.'" '.$calDaysHoldcalday.' data-point="'.$datapoint.'" title="'.$t.'-'.$entrymonth.'-'.$year.'"data-target="'.$targetcontainer.'">'.$t.'</div>
';  
            }

        }
        $totaldays=$excessdays.$realdays;
        //outputs
        $row['totaldaysout']=$totaldays;
        $admindisplay="";
        $adminstyle="";
        if($viewer=="admin"){
            $admindisplay=".";
            $adminstyle='style="float:none;"';
        }
        $row['formoutput']='
    <div id="calHold" '.$calHold.' '.$adminstyle.'>
      <div id="caltop" '.$caltop.'>
        <div id="calmonthpointer" name="calpointleft" data-target="'.$targetcontainer.'" data-theme="'.$theme.'" '.$controloption.'>
          <img src="'.$admindisplay.'./images/leftarrow.png" class="total"/>
        </div>
        <div id="calDispDetails" data-curmonth="'.$entrymonth.'" data-year="'.$year.'">
          '.$entrymonth2.', '.$year.'
        </div>
        <div id="calmonthpointer" name="calpointright"data-target="'.$targetcontainer.'" data-theme="'.$theme.'" '.$controloption.'>
          <img src="'.$admindisplay.'./images/rightarrow.png" class="total"/>
        </div>
      </div>      
      <div id="calBody">
        <div id="calDaynamehold">
          <div id="calDay" '.$calDaynameholdcalday.'>Sun</div>
          <div id="calDay" '.$calDaynameholdcalday.'>Mon</div>
          <div id="calDay" '.$calDaynameholdcalday.'>Tue</div>
          <div id="calDay" '.$calDaynameholdcalday.'>Wed</div>
          <div id="calDay" '.$calDaynameholdcalday.'>Thu</div>
          <div id="calDay" '.$calDaynameholdcalday.'>Fri</div>
          <div id="calDay" '.$calDaynameholdcalday.'>Sat</div>
        </div>
        <div id="calDaysHold"name="'.$targetcontainer.'">
          <!--<div id="calDay" name="theday-themonth-theyear" title="The date goes here:-12 Appointments">1</div>-->
          '.$totaldays.'
        </div>
      </div>
      <div id="calInfobox" '.$calInfobox.'>
        Click on a day to choose or view it.
      </div>
    </div>
';
        $row['totaloutput']='
    <div id="calHold">
      <div id="caltop">
        <div id="calmonthpointer" name="calpointleft" data-target="'.$targetcontainer.'" '.$controloption.'>
          <img src="'.$admindisplay.'./images/leftarrow.png" class="total"/>
        </div>
        <div id="calDispDetails" data-curmonth="'.$entrymonth.'" data-year="'.$year.'">
          '.$entrymonth2.', '.$year.'
        </div>
        <div id="calmonthpointer" name="calpointright" data-target="'.$targetcontainer.'" '.$controloption.'>
          <img src="'.$admindisplay.'./images/rightarrow.png" class="total"/>
        </div>
      </div>      
      <div id="calBody">
        <div id="calDaynamehold">
          <div id="calDay">Sun</div>
          <div id="calDay">Mon</div>
          <div id="calDay">Tue</div>
          <div id="calDay">Wed</div>
          <div id="calDay">Thu</div>
          <div id="calDay">Fri</div>
          <div id="calDay">Sat</div>
        </div>
        <div id="calDaysHold" name="'.$targetcontainer.'">
          <!--<div id="calDay" name="theday-themonth-theyear" title="The date goes here:-12 Appointments">1</div>-->
          '.$totaldays.'
        </div>
      </div>
      <div id="calInfobox" '.$calInfobox.'>
        Click on the day to view schedule for choosen date.
      </div>
    </div>
';
    }
    return $row;
}
function paginate($query){
    require_once 'paginator.class.php';
    $pages = new Paginator;  
    global $wasl;
$run=mysqli_query($wasl,$query)or die(mysql_error()."Line 646");
    $numrows=mysqli_num_rows($run);
    $pages->items_total = $numrows;  
    $pages->mid_range = 9;  
    $pages->paginate();  
    $pages->display_pages();
    $row['limitout']=$pages->limit;
    $query2=$query.$row['limitout'];
    // // echo $pages;
    $row=array();

    $row['outputcount']=$numrows;
    $row['pageout']=$pages->display_pages();
    $row['usercontrols']="<br><span> ".$pages->display_jump_menu()." ".$pages->display_items_per_page()."</span>";
    $row['limit']=$pages->limit;
    return $row;
}
function paginatejavascript($query){
    require_once 'paginator.class.php';
    $pages = new Paginator;  
    global $wasl;
$run=mysqli_query($wasl,$query)or die(mysql_error()."Line 1202");
    // echo $query;
    $numrows=mysqli_num_rows($run);
    $pages->items_total = $numrows;  
    $pages->mid_range = 9;  
    $pages->paginatejavascript();  
    $pages->display_pages();
    $row['limitout']=$pages->limit;
    $query2=$query.$row['limitout'];
    // // echo $pages;
    $row=array();

    $row['outputcount']=$numrows;
    $row['pageout']=$pages->display_pages();
    $row['usercontrols']="<br><span> ".$pages->display_items_per_page_javascript()."</span>";
    $row['limit']=$pages->limit;
    return $row;
}
function getSingleContentMedia($mediaid){
    global $host_addr,$host_target_addr;
    $row=array();
    $query="SELECT * FROM media WHERE id=$mediaid";
    global $wasl;
$run=mysqli_query($wasl,$query)or die(mysql_error()." Line 999");
    $row=mysqli_fetch_assoc($run);
    $relpath=$row['location'];
    $mainpath=$host_addr.$row['location'];
    $filenamesplit=explode("/",$relpath);
    $medianame=$filenamesplit[count($filenamesplit)-1];
    $filetype=getFileType($mainpath);
    $extension=getExtension($relpath);
    if($filetype=="image"){
        $datasrc=$host_addr.$row['details'];
    }elseif($filetype=="audio"){
        $datasrc=''.$host_addr.'/images/audiodisp.jpg';
    }elseif($filetype=="video"){
        $datasrc=''.$host_addr.'/images/videodisp.jpg';
    }
    $row['adminoutput']='
<div id="editmediacontent" name="mediacontent'.$mediaid.'">
      <div id="editmediacontentoptions">
        <div id="editmediacontentoptionlinks">
          <a href="##" name="delete" data-id="'.$mediaid.'" data-medianame="'.$medianame.'" data-mediatype="'.$filetype.'" data-src=".'.$relpath.'"data-width="'.$row['width'].'" data-height="'.$row['height'].'"><img name="delete" src="../images/trashfirst.png" title="Delete media?" class="total"></a>
          <a href="##" name="view" data-id="'.$mediaid.'" data-medianame="'.$medianame.'" data-mediatype="'.$filetype.'" data-src=".'.$relpath.'" data-width="'.$row['width'].'" data-height="'.$row['height'].'"><img name="view" src="../images/viewpicfirst.png" title="View media" class="total"></a>               
        </div>
      </div>  
      <img src="'.$datasrc.'" title="'.$medianame.','.$filetype.','.$row['filesize'].'" name="realimage" style="height:100%;margin:auto;">
    </div>
';
    return $row;

}
function getAllContentMedia($viewer,$limit,$type){
    global $host_addr,$host_target_addr;
    $row=array();
    $type==""?$type="all":$type=$type;
    $testit=strpos($limit,"-");
    $testit===0||$testit===true||$testit>0?$limit="":$limit=$limit;
    $limit==""?$limit="LIMIT 0,15":$limit=$limit;
    if($limit==""&&$viewer=="admin"&&$type=="all"){
        $query="SELECT * FROM media WHERE ownertype='contentmedia' ORDER BY id DESC $limit";
        $rowmonitor['chiefquery']="SELECT * FROM media WHERE ownertype='contentmedia' ORDER BY id DESC";
    }elseif($limit!==""&&$viewer=="admin"&&$type=="all"){
        $query="SELECT * FROM media WHERE ownertype='contentmedia' ORDER BY id DESC $limit";
        $rowmonitor['chiefquery']="SELECT * FROM media WHERE ownertype='contentmedia' ORDER BY id DESC";
    }elseif($viewer=="admin"&&($type=="images"||$type=="image")){
        $type="image";
        $query="SELECT * FROM media WHERE ownertype='contentmedia' AND mediatype='$type' AND status='active' ORDER BY id asc $limit";
        $rowmonitor['chiefquery']="SELECT * FROM media WHERE ownertype='contentmedia' AND mediatype='$type' AND status='active' ORDER BY id asc";  
    }elseif($viewer=="admin"&&$type=="audio"){
        $query="SELECT * FROM media WHERE ownertype='contentmedia' AND mediatype='$type' AND status='active' ORDER BY id asc $limit";
        $rowmonitor['chiefquery']="SELECT * FROM media WHERE ownertype='contentmedia' AND mediatype='$type' AND status='active' ORDER BY id asc";  
    }elseif($viewer=="admin"&&$type=="video"){
        $query="SELECT * FROM media WHERE ownertype='contentmedia' AND mediatype='$type' AND status='active' ORDER BY id asc $limit";
        $rowmonitor['chiefquery']="SELECT * FROM media WHERE ownertype='contentmedia' AND mediatype='$type' AND status='active' ORDER BY id asc";  
    }
    // echo $query;
    global $wasl;
$run=mysqli_query($wasl,$query)or die(mysql_error()." Line 2744");
    $numrows=mysqli_num_rows($run);
    $adminoutput="<td colspan=\"100%\">No entries</td>";
    $adminoutputtwo="";
    $vieweroutput='<font color="#1a1a1a">Sorry, No Boats have been created yet</font>';
    $vieweroutputtwo='<font color="#1a1a1a">Sorry, No boats have been created with that brand and name</font>';
    $boattotal='<option value="">Choose a Boat Brand & make</option>';
    if($numrows>0){
        $adminoutput="";
        $adminoutputtwo="";
        $vieweroutput="";
        while($row=mysqli_fetch_assoc($run)){
            $outs=getSingleContentMedia($row['id']);
            $adminoutput.=$outs['adminoutput'];
            // $adminoutputtwo.=$outs['adminoutputtwo'];
            // $vieweroutput.=$outs['vieweroutput'];
            // $vieweroutputtwo=$outs['vieweroutputtwo'];
            // $boattotal.='<option value="'.$row['id'].'">'.$row['name'].' - Year '.$row['year'].'</option>';
        }

    }
    $top="";
    $bottom="";
    /*$top='<table id="resultcontenttable" cellspacing="0">
      <thead><tr><th>CoverPhoto</th><th>Boat Type</th><th>Name</th><th>Year</th><th>Price</th><th>location</th><th>status</th><th>View/Edit</th></tr></thead>
      <tbody>';
$bottom=' </tbody>
    </table>';*/
    $row['chiefquery']=$rowmonitor['chiefquery'];
    $outs=paginatejavascript($rowmonitor['chiefquery']);
    $outsviewer=paginate($rowmonitor['chiefquery']);
    $paginatetop='
<div id="paginationhold">
  <div class="meneame">
    <input type="hidden" name="curquery" value="'.$rowmonitor['chiefquery'].'"/>
    <input type="hidden" name="outputtype" value="mediacontent|'.$type.'"/>
    <input type="hidden" name="currentview" data-ipp="15" data-page="1" value="1"/>
    <div class="pagination" data-name="paginationpageshold">'.$outs['pageout'].'</div>
    <div class="pagination">
        '.$outs['usercontrols'].'
    </div>
  </div>
</div>
<div id="paginateddatahold" data-name="contentholder">';

    $paginatebottom='
</div><div id="paginationhold">
  <div class="meneame">
    <div class="pagination" data-name="paginationpageshold">'.$outs['pageout'].'</div>
  </div>
</div>';
    $row['adminoutput']=$paginatetop.$top.$adminoutput.$bottom.$paginatebottom;
    $row['adminoutputtwo']=$top.$adminoutput.$bottom;
    // $row['vieweroutput']=$vieweroutput;

    return $row;

}
/*Converts numbers to english word equivalent*/
function convertNumber($number){
    list($integer, $fraction) = explode(".", (string) $number);

    $output = "";

    if ($integer[0] == "-")
    {
        $output = "negative ";
        $integer    = ltrim($integer, "-");
    }
    else if ($integer[0] == "+")
    {
        $output = "positive ";
        $integer    = ltrim($integer, "+");
    }

    if ($integer[0] == "0")
    {
        $output .= "zero";
    }
    else
    {
        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
        $group   = rtrim(chunk_split($integer, 3, " "), " ");
        $groups  = explode(" ", $group);

        $groups2 = array();
        foreach ($groups as $g)
        {
            $groups2[] = convertThreeDigit($g[0], $g[1], $g[2]);
        }

        for ($z = 0; $z < count($groups2); $z++)
        {
            if ($groups2[$z] != "")
            {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                    $z < 11
                    && !array_search('', array_slice($groups2, $z + 1, -1))
                    && $groups2[11] != ''
                    && $groups[11][0] == '0'
                    ? " and "
                    : ", "
                );
            }
        }

        $output = rtrim($output, ", ");
    }

    if ($fraction > 0)
    {
        $output .= " point";
        for ($i = 0; $i < strlen($fraction); $i++)
        {
            $output .= " " . convertDigit($fraction[$i]);
        }
    }

    return $output;
}

function convertGroup($index)
{
    switch ($index)
    {
        case 11:
            return " decillion";
        case 10:
            return " nonillion";
        case 9:
            return " octillion";
        case 8:
            return " septillion";
        case 7:
            return " sextillion";
        case 6:
            return " quintrillion";
        case 5:
            return " quadrillion";
        case 4:
            return " trillion";
        case 3:
            return " billion";
        case 2:
            return " million";
        case 1:
            return " thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
    {
        return "";
    }

    if ($digit1 != "0")
    {
        $buffer .= convertDigit($digit1) . " hundred";
        if ($digit2 != "0" || $digit3 != "0")
        {
            $buffer .= " and ";
        }
    }

    if ($digit2 != "0")
    {
        $buffer .= convertTwoDigit($digit2, $digit3);
    }
    else if ($digit3 != "0")
    {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0")
    {
        switch ($digit1)
        {
            case "1":
                return "ten";
            case "2":
                return "twenty";
            case "3":
                return "thirty";
            case "4":
                return "forty";
            case "5":
                return "fifty";
            case "6":
                return "sixty";
            case "7":
                return "seventy";
            case "8":
                return "eighty";
            case "9":
                return "ninety";
        }
    } else if ($digit1 == "1")
    {
        switch ($digit2)
        {
            case "1":
                return "eleven";
            case "2":
                return "twelve";
            case "3":
                return "thirteen";
            case "4":
                return "fourteen";
            case "5":
                return "fifteen";
            case "6":
                return "sixteen";
            case "7":
                return "seventeen";
            case "8":
                return "eighteen";
            case "9":
                return "nineteen";
        }
    } else
    {
        $temp = convertDigit($digit2);
        switch ($digit1)
        {
            case "2":
                return "twenty-$temp";
            case "3":
                return "thirty-$temp";
            case "4":
                return "forty-$temp";
            case "5":
                return "fifty-$temp";
            case "6":
                return "sixty-$temp";
            case "7":
                return "seventy-$temp";
            case "8":
                return "eighty-$temp";
            case "9":
                return "ninety-$temp";
        }
    }
}

function convertDigit($digit)
{
    switch ($digit)
    {
        case "0":
            return "zero";
        case "1":
            return "one";
        case "2":
            return "two";
        case "3":
            return "three";
        case "4":
            return "four";
        case "5":
            return "five";
        case "6":
            return "six";
        case "7":
            return "seven";
        case "8":
            return "eight";
        case "9":
            return "nine";
    }
}
/*end*/
function deleteMedia($partid){
    global $host_addr,$host_target_addr;
    $mediadata=getSingleMediaDataTwo($partid);
    $realpath=".".$mediadata['location']."";
    $realpaththumb=".".$mediadata['details']."";
    if(file_exists($realpath)){
        unlink($realpath);
        if($mediadata['ownertype']=="boat"){
            if(file_exists($realpaththumb)){
                unlink($realpaththumb);
            }
        }
    }
    genericSingleUpdate("media","status","inactive","id",$partid);
    genericSingleUpdate("media","mainid","0","id",$partid);
    genericSingleUpdate("media","maintype","none","id",$partid);
    genericSingleUpdate("media","ownertype","none","id",$partid);
    genericSingleUpdate("media","ownerid","0","id",$partid);
    $output="done";
    return $output;
}

function getSingleCorpPhoto($id){
    global $host_addr,$host_target_addr;
    $row=array();
    $query="SELECT * FROM corpentries WHERE id=$id";
    global $wasl;
$run=mysqli_query($wasl,$query)or die(mysql_error()." Line 1582");
    $numrows=mysqli_num_rows($run);
    $row=mysqli_fetch_assoc($run);
    $fullname=$row['fullname'];
    $state=$row['state'];
    $batch=$row['batch'];
    $code=$row['code'];
    $ppa=$row['ppa'];
    $imgid=$row['imgid'];
    $status=$row['status'];
    $entrydate=$row['entrydate'];
    $imagepath = $row['imgpath'];
    $unidepartment = strtoupper($row['unidepartment']);
    $mediaquery="SELECT * FROM media WHERE ownerid=$id";
    $mediarun=mysqli_query($wasl,$mediaquery)or die(mysql_error()." Line 2087");
    $medianumrows=mysqli_num_rows($mediarun);
    $mediarow=mysqli_fetch_assoc($mediarun);
    // $thumb=$mediarow['details'];
    $thumb=$imagepath;
    $thumb==""?$thumb="/images/default.gif":$thumb;
    // $coverpic=$mediarow['location'];
    $coverpic=$imagepath;
    $coverpic==""?$coverpic="/images/default.gif":$coverpic;
    $row['realpaththumb']=$host_addr.$thumb;
    $row['realpathcover']=$host_addr.$coverpic;
    $statecode=$state."/".$batch."/".$code;
    $statecode=strtoupper($statecode);
    $row['statecode']=$statecode;
    $row['adminoutput']='
      <tr data-id="'.$id.'">
        <td><img src="'.$host_addr.$thumb.'"style="height:150px;"/></td><td>'.$fullname.'</td><td>'.$statecode.'</td><td>'.$ppa.'</td><td>'.$entrydate.'</td><td>'.$status.'</td><td name="trcontrolpoint"><a href="#&id='.$id.'" name="edit" data-type="editsinglecorpmember" data-divid="'.$id.'">Edit</a></td>
      </tr>
      <tr name="tableeditcontainer" data-state="inactive" data-divid="'.$id.'">
        <td colspan="100%">
          <div id="completeresultdisplay" data-type="editmodal" data-load="unloaded" data-divid="'.$id.'">
            <div id="completeresultdisplaycontent" data-type="editdisplay" data-divid="'.$id.'">

            </div>
          </div>
        </td>
      </tr>
      ';
    $row['adminoutputtwo']='
      <form name="prettyphotoeditform" action="./snippets/edit.php" method="post" enctype="multipart/form-data">
      <div id="formheader">Edit '.$statecode.'.</div>
                  <input name="entryvariant" type="hidden" value="editsinglecorpmember"/>
              <div id="formend">
                <div name="entries">
                  <input name="entryid" type="hidden" value="'.$id.'"/>
                  <input name="realpaththumb" type="hidden" value="'.$row['realpaththumb'].'"/>
                  <input name="realpathcover" type="hidden" value="'.$row['realpathcover'].'"/>
                  <input name="imgid" type="hidden" value="'.$imgid.'"/>
                  <input name="entrycount" type="hidden" value="1"/>
                  <div id="formend">
                    <div id="elementholder">
                      Corp Member Name *
                      <input name="name1"  placeholder="Corp Member Fullname" value="'.$fullname.'" class="curved"/>
                    </div>
                    <div id="elementholder">
                      State Code *:<br>
                      <input type="text" class="curved curvedbackcolorone" placeholder="OY" value="'.$state.'" maxlength="2" style="width:13%;margin-left:1%;" name="state1"/>
                      <input type="text" class="curved curvedbackcolorone" placeholder="14B" value="'.$batch.'" maxlength="3" style="width:15%;margin-left:1%;" name="batch1"/>
                      <input type="text" class="curved curvedbackcolorone" placeholder="XXXX" value="'.$code.'" maxlength="4" style="width:32%;margin-left:0%;" name="code1"/>
                    </div>
                    <div id="elementholder">
                      PPA *
                      <input name="ppa1"  placeholder="Place of Primary Ass" value="'.$ppa.'" class="curved"/>
                    </div>
                    <div id="elementholder">
                      Photograph *
                      <input name="profpic1" type="file" class="curved"/>
                    </div>
                  </div>

                </div>

              </div>
              <div id="formend">
                Change Status<br>
                <select name="status1" class="curved2">
                  <option value="">Change Status</option>
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
              <div id="formend">
                <input type="submit" name="createentry" value="Submit" class="submitbutton"/>
              </div>
        </form>
    ';
    $row['printoutput']='
      <div class="prettyholder">
      <div class="prettyimg"><img src="'.$host_addr.$coverpic.'"></div>
      <div class="prettycontent">
        <span class="corpnameout">'.$fullname.'</span><br>
        '.$statecode.'<br>
        '.$ppa.'<br>
        '.$unidepartment.'
      </div>
    </div>
    ';
    return $row;
}
function getAllCorpPhotos($viewer,$limit,$type,$typevals){
    global $host_addr,$host_target_addr;
    $currentyear=date('Y');
    $limit!==""?$limit=$limit:$limit="";
    $testit=strpos($limit,"-");
    $testit!==false?$limit="":$limit=$limit;
    // echo $testit."testitval".$limit;
    $limit==""?$limit="LIMIT 0,15":$limit;
    $row=array();
    $paginateout="corpentries";
    $printoutput="Sorry No entries have been captured yet";
    $query="SELECT * FROM corpentries order by code $limit";
    $rowmonitor['chiefquery']="SELECT * FROM corpentries order by code asc ";
    if($type=="group"){
        $printoutput="Sorry the search yielded no results";
        $typedata="";
        for($i=0;$i<count($typevals);$i++){
            $typedata==""?$typedata="WHERE id='".$typevals[$i]."' OR code='".$typevals[$i]."' AND status='active'":$typedata.="OR id='".$typevals[$i]."' OR code='".$typevals[$i]."' AND status='active'";
        }
        $query="SELECT * FROM corpentries $typedata order by code $limit";
        $rowmonitor['chiefquery']="SELECT * FROM corpentries $typedata order by code asc";
    }else if($type=="print"){
        $query="SELECT * FROM corpentries WHERE status='active' order by code ";
        $rowmonitor['chiefquery']="SELECT * FROM corpentries WHERE status='active' order by code ";
    }else if($type=="searchname"||$type=="searchname2"){
        $printoutput="Sorry the search yielded no results";
        $typedata="";
        $bsearch=explode(";",$typevals);
        if(count($bsearch)>1){
            $y=$bsearch[1];
            $ymain=$y!==""?substr($y,2,4):"";
            $batch=$bsearch[2];
            $ybatch=$ymain.$batch;
            $ybatch==""?$ybatch=substr($currentyear,2,4)."A":$ybatch;
            $typedata="WHERE fullname LIKE '%".$bsearch[0]."%' AND batch LIKE '%".$ybatch."%' OR code LIKE '%".$bsearch[0]."%' AND batch LIKE '%".$ybatch."%'";
        }else{
            $typedata==""?$typedata="WHERE fullname LIKE '%".$bsearch[0]."%' OR WHERE code LIKE '%".$bsearch[0]."%'":$typedata;

        }
        if($type=="searchname2"){  
            $paginateout="searchname2;$bsearch[0];$y;$batch";

        }
        $query="SELECT * FROM corpentries $typedata order by id desc $limit";
        $rowmonitor['chiefquery']="SELECT * FROM corpentries $typedata order by id desc";
    }else if($type=="vcrange"){
        $printoutput="Sorry the search yielded no results";
        $typedata="";
        $y=$typevals[2];
        $ymain=$y!==""?substr($y,2,4):substr($currentyear,2,4);
        $batch=$typevals[3];
        $ybatch=$ymain.$batch;
        $ybatch==""?$ybatch=substr($currentyear,2,4)."A":$ybatch;
        if($typevals[1]!==""&&$typevals[1]!==0){
            $typedata==""?$typedata="WHERE code>=".$typevals[0]." AND code<=".$typevals[1]." AND batch LIKE '%".$ybatch."%' AND status='active'":$typedata;
        }else{
            $typedata==""?$typedata="WHERE code=".$typevals[0]." AND status='active'":$typedata;

        }
        $query="SELECT * FROM corpentries $typedata order by id asc ";
        $rowmonitor['chiefquery']="SELECT * FROM corpentries $typedata order by id desc";
        $paginateout="vcrange|$typevals[0]|$typevals[1]|$y|$batch";

    }else if($type=="vcrange2"){
        $printoutput="Sorry the search yielded no results";
        $typedata="";
        $y=$typevals[2];
        $ymain=$y!==""?substr($y,2,4):substr($currentyear,2,4);
        $batch=$typevals[3];
        $ybatch=$ymain.$batch;
        // echo $ybatch."<br>";
        $ybatch==""?$ybatch=substr($currentyear,2,4)."A":$ybatch;
        if($typevals[1]!==""&&$typevals[1]!==0){
            $typedata==""?$typedata="WHERE code>=".$typevals[0]." AND code<=".$typevals[1]." AND batch LIKE '%".$ybatch."%'":$typedata;
        }else{
            $typedata==""?$typedata="WHERE code=".$typevals[0]."":$typedata;

        }
        $query="SELECT * FROM corpentries $typedata order by id desc $limit";
        $rowmonitor['chiefquery']="SELECT * FROM corpentries $typedata order by id desc";
        $paginateout="vcrange2|$typevals[0]|$typevals[1]|$y|$batch";
        // echo $typedata.$paginateout;
        // echo $rowmonitor['chiefquery'];
    }else if($type=="pparange"){
        $printoutput="Sorry the search yielded no results";
        $bsearch=explode(";",$typevals);
        $y=$bsearch[1];
        $ymain=$y!==""?substr($y,2,4):"";
        $batch=$bsearch[2];
        $ybatch=$ymain.$batch;
        $ybatch==""?$ybatch=substr($currentyear,2,4)."A":$ybatch;
        $typedata="";
        $typedata==""?$typedata="WHERE ppa LIKE '%".$bsearch[0]."%' AND batch LIKE '%".$ybatch."%' AND status='active'":$typedata;
        $query="SELECT * FROM corpentries $typedata order by code asc";
        $rowmonitor['chiefquery']="SELECT * FROM corpentries $typedata order by code asc";
    }
    // echo $query;
    global $wasl;
$run=mysqli_query($wasl,$query)or die(mysql_error()." Line 1698");
    $numrows=mysqli_num_rows($run);
    $adminoutput="Sorry No entries have been captured yet";
    $adminoutputtwo="Sorry No entries have been captured yet";

    if($numrows>0){
        $adminoutput="";
        $adminoutputtwo="";
        $printoutput="";
        $countheader=1;
        $pageheader="";
        $pageheader2="";
        $checker="off";
        $imonitor=1;
        while($row=mysqli_fetch_assoc($run)){
            $out=getSingleCorpPhoto($row['id']);
            $adminoutput.=$out['adminoutput'];
            // $adminoutputtwo.=$out['adminoutput'];
            // if($imonitor==1){
            //     $pageheader='<div id="printtopcontent">
            //         <div class="floatright pgnum">'.$countheader.'</div>
            //       </div>';
            //     $countheader+=1;
            //     $printoutput.=$pageheader;
            // }
            // if($imonitor%49<1){
            //     $checker="on";
            // }else{
            //     if($checker=="on"){
            //         $pageheader='
            //         <div id="printtopcontent">
            //         <div class="floatright pgnum">'.$countheader.'</div>
            //       </div>';
            //         $countheader+=1;
            //         $printoutput.=$pageheader;
            //         $checker="off";
            //     }
            // }
            $printoutput.=$out['printoutput'];
            $imonitor++;
        }
    }
    $outs=paginatejavascript($rowmonitor['chiefquery']);
    $testq=strpos($rowmonitor['chiefquery'],"%'");
    if($testq===0||$testq===true||$testq>0){
        $rowmonitor['chiefquery']=str_replace("%","%'",$rowmonitor['chiefquery']);
    }
    $top='<table id="resultcontenttable" cellspacing="0">
      <thead><tr><th>CoverPhoto</th><th>Fullname</th><th>Code Number</th><th>Place of Primary Assignment</th><th>Entry Date</th><th>Status</th><th>View/Edit</th></tr></thead>
      <tbody>';
    $bottom=' </tbody>
    </table>';
    $paginatetop='
<div id="paginationhold">
  <div class="meneame">
    <input type="hidden" name="curquery" value="'.$rowmonitor['chiefquery'].'"/>
    <input type="hidden" name="outputtype" value="'.$paginateout.'"/>
    <input type="hidden" name="currentview" data-ipp="15" data-page="1" value="1"/>
    <div class="pagination" data-name="paginationpageshold">'.$outs['pageout'].'</div>
    <div class="pagination">
        '.$outs['usercontrols'].'
    </div>
  </div>
</div>
<div id="paginateddatahold" data-name="contentholder">';

    $paginatebottom='
</div><div id="paginationhold">
  <div class="meneame">
    <div class="pagination" data-name="paginationpageshold">'.$outs['pageout'].'</div>
  </div>
</div>';
    $row['adminoutput']=$paginatetop.$top.$adminoutput.$bottom.$paginatebottom;
    $row['adminoutputtwo']=$top.$adminoutput.$bottom;
    // $row['adminoutputtwo']="";
    $row['printoutput']=$printoutput;

    return $row;
}
?>