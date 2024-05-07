function forceForm(){
$(document).ready(function(){
$(''+formObj+' input[name=entryvariant]').val();
});
}
$(document).ready(function(){
  var pagedata=document.URL;
  var pagedatatwo=pagedata.split(".");
 var realpage=pagedatatwo[0];
	// var usertype=$('input[name=userdata]').attr('data-type');;
	// var userid=$('input[name=userdata]').attr('value');
	$(document).on("blur",'input[type=text]',function(){
		$(this).css('border','1px solid #c9c9c9');
	});
	$(document).on("blur",'select',function(){
		$(this).css('border','0px');
	});
	$(document).on("blur",'textarea',function(){
		$(this).css('border','1px solid #c9c9c9');
	});
		$(document).on("mouseenter",'form #elementholder',function(){
		$(this).css('border','0px');
	});

	$(document).on("click",'input[type=button]',function(){
	var viewwindow=$('#viewneditcontent');
	var buttonname=$(this).attr('name');
	var buttonid=$(this).attr('id');
	var tester="";
	
	if(buttonname=="adminloginsubmit"){
	var formstatus=true;
	var inputname1=$('input[name=username]').val();
	var inputname2=$('input[name=password]').val();
	if(inputname1==""){
		window.alert('Please enter the username number');
		$("input[name=username]").css('border','1px solid red').focus();
		formstatus= false;
	}else if(inputname2==""){
		window.alert('Please enter your password');
		$("input[name=password]").css('border','1px solid red').focus();
		formstatus= false;
	}
		if(formstatus==true){
	$('form[name=adminloginform]').submit();
}		
	}

if(buttonname=="createentry"){
 var formstatus=true;
var inputname1=$('input[name=name1]');
var inputname2=$('input[name=state1]');
var inputname3=$('input[name=batch1]');
var inputname4=$('input[name=code1]');
var inputname5=$('input[name=ppa1]');
var inputname6=$('input[name=profpic1]');
var inputname7=$('input[name=entrycount]');
var testimg="";
	if(inputname6.val()!==""){
		testimg=getExtension(inputname6.val());
	}
if(inputname1.val()==""){
	window.alert('Please provide the corp member\'s fullname');
	$(inputname1).css('border','1px solid red').focus();
	formstatus= false;
}else if(inputname2.val()==""){
	window.alert('Please give the statecode.');
	$(inputname2).css('border','1px solid red').focus();
	formstatus= false;
}else if(inputname3.val()==""){
	window.alert('Please specify the batch');
	$(inputname3).css('border','1px solid red').focus();
	formstatus= false;
}else if(inputname4.val()==""){
	window.alert('Provide the code number');
	$(inputname4).css('border','1px solid red').focus();
	formstatus= false;
}/*else if(inputname5.val()==""){
	window.alert('Please State the corpers\' Place of primary assignment');
	$(inputname5).css('border','1px solid red').focus();
	formstatus= false;
}*/else if(inputname6.val()==""){
	window.alert('Please choose the corper\'s photograph');
	$(inputname6).css('border','1px solid red').focus();
	formstatus= false;
}else if(inputname6.val()!==""&&testimg['type']!=="image"){
		window.alert('Please only valid websafe images are allowed');
		$(inputname6).css('border','1px solid red').focus();
		formstatus= false;
	}		
if(inputname7.val()>1){
	for(var i=2;i<=inputname7.val();i++){
	var inputname8=$('input[name=name'+i+']');
	var inputname9=$('input[name=state'+i+']');
	var inputname10=$('input[name=batch'+i+']');
	var inputname11=$('input[name=code'+i+']');
	var inputname12=$('input[name=ppa'+i+']');
	var inputname13=$('input[name=profpic'+i+']');
	var testimg="";
	if(inputname13.val()!==""){
		testimg=getExtension(inputname13.val());
	}
	if(inputname8.val()==""){
		window.alert('Please provide the corp member\'s fullname');
		$(inputname8).css('border','1px solid red').focus();
		formstatus= false;
	}else if(inputname9.val()==""){
		window.alert('Please give the statecode.');
		$(inputname9).css('border','1px solid red').focus();
		formstatus= false;
	}else if(inputname10.val()==""){
		window.alert('Please specify the batch');
		$(inputname10).css('border','1px solid red').focus();
		formstatus= false;
	}else if(inputname11.val()==""){
		window.alert('Provide the code number');
		$(inputname11).css('border','1px solid red').focus();
		formstatus= false;
	}/*else if(inputname12.val()==""){
		window.alert('Please State the corpers\' Place of primary assignment');
		$(inputname12).css('border','1px solid red').focus();
		formstatus= false;
	}*/else if(inputname13.val()==""){
		window.alert('Please choose the corper\'s photograph');
		$(inputname13).css('border','1px solid red').focus();
		formstatus= false;
	}else if(inputname13.val()!==""&&testimg['type']!=="image"){
		// console.log(inputname13.val(),testimg['type'] );
		window.alert('Please only valid websafe images are allowed');
		$(inputname13).css('border','1px solid red').focus();
		formstatus= false;
	}		
	}

}
	// console.log(status);
if(formstatus==true){
	var tester=window.confirm('The form is ready to be submitted click ok to continue or cancel to review');
if(tester===true){
$('form[name=prettyphotoentryform]').submit();
}
}

}

if(buttonname=="createimport"){
	var formstatus=true;
	var inputname1=$('input[name=importfile]');
	var testimg="";
	if(inputname1.val()!==""){
		testimg=getExtension(inputname1.val());
	}
	if(inputname1.val()==""){
		window.alert('Please provide the excel file for import');
		$(inputname1).css('border','1px solid red').focus();
		formstatus= false;	
	}else if(inputname1.val()!==""&&testimg['rextension']!=="xls"&&testimg['rextension']!=="xlsx"){
		window.alert('Please provide a valid excel file for import');
		$(inputname1).css('border','1px solid red').focus();
		formstatus= false;	
	}



	if(formstatus==true){
		var tester=window.confirm('The form is ready to be submitted click ok to continue or cancel to review');
		if(tester===true){
			$('form[name=prettyphotoimportform]').submit();
		}
	}
}

if(buttonname=="submitsearch"){
	// window.alert('Clicked');
		var curdataview=$('input[name=searchdata]').attr("appdata-control");
var searchdata=$('input[name=searchdata]').val();
searchdata+=";"+$('select[name=year]').val()+";"+$('select[name=batch]').val();
// console.log(curdataview, searchdata);
var searchtest=searchdata.replace(/\s/g,"");


if(searchtest!==""){
	var sublinkreq=new Request();
  sublinkreq.generatetwo('#printzone',true);
  //enter the url
  sublinkreq.url('./snippets/display.php?displaytype='+curdataview+'&searchdata='+searchdata+'&extraval=admin');
  //send request
  sublinkreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  sublinkreq.update('div#printzone','html','fadeIn',1000);

	var sublinkreq2=new Request();
  sublinkreq2.generatetwo('div#contentdisplayhold div[data-name=contentholder]',true);
  //enter the url
  sublinkreq2.url('./snippets/display.php?displaytype='+curdataview+'&searchdata='+searchdata+'&extraval=admin');
  //send request
  sublinkreq2.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  sublinkreq2.update('div#contentdisplayhold','html','fadeIn',1000);

}else{
	window.alert('The search field is empty');
	$('input[name=searchdata]').css('border','1px solid red').focus();
}

}

});
});