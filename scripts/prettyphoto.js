function downloadPdf(el) {
    var iframe = document.createElement("iframe");
    iframe.src = "./snippets/download.php?id=1";
    iframe.onload = function() {
        // iframe has finished loading, download has started
        el.innerHTML = "Download";
    }
    iframe.style.display = "none";
    document.body.appendChild(iframe);
}
$(document).ready(function(){
	$(document).on("click","#formend a",function(){
var linkname=$(this).attr('name');
var targetcontainer=$(this).attr('data-target');
var branchcount=$('input[name=containercount]').val();
var nextcount=Math.floor(branchcount)+1;
if(linkname=="entryadd"){
var branchcount=$('input[name=entrycount]').val();
  var nextcount=Math.floor(branchcount)+1;
  // console.log(nextcount,branchcount);
  if(nextcount<=10){
var outs='<div id="formend">'+
'		<div id="elementholder">'+
'			Corp Member Name('+nextcount+') *'+
'			<input name="name'+nextcount+'"  placeholder="Corp Member Fullname('+nextcount+')" class="curved"/>'+
'		</div>'+
'		<div id="elementholder">'+
'			State Code *:<br>'+
'			<input type="text" class="curved curvedbackcolorone" placeholder="OY" maxlength="2" style="width:13%;margin-left:1%;" name="state'+nextcount+'"/>'+
'			<input type="text" class="curved curvedbackcolorone" placeholder="14B" maxlength="3" style="width:15%;margin-left:1%;" name="batch'+nextcount+'"/>'+
'			<input type="text" class="curved curvedbackcolorone" placeholder="XXXX" maxlength="4" style="width:32%;margin-left:0%;" name="code'+nextcount+'"/>'+
'		</div>'+
'		<div id="elementholder">'+
'			PPA('+nextcount+') *'+
'			<input name="ppa'+nextcount+'"  placeholder="Place of Primary Ass.('+nextcount+')" class="curved"/>'+
'		</div>'+
'		<div id="elementholder">'+
'			Photograph('+nextcount+') *'+
'			<input name="profpic'+nextcount+'" type="file" class="curved"/>'+
'		</div>'+
'	</div>';
$(outs).insertBefore('div[name=entries] div.entrymarker');
//selection.appendTo(outs);
$('input[name=entrycount]').attr('value',''+nextcount+'');
}else{
  window.alert('Max of ten entries, thank you');
}
}
});

$(document).on("click","div#controlspane div.optionout a",function(){
	var curdataview=$(this).attr("appdata-name");
	$("div[appdata-name=optionscontent]").css({"height":"0px","min-height":"0px","padding":"0px","overflow":"hidden"});
	$("div[appdata-name=optionscontent] input[name=searchdata]").val("");
	$("div[appdata-name=optionscontent] input[name=searchdata]").attr("appdata-control",""+curdataview+"");
		$("div[appdata-name=optionscontent] p[name=infopoint]").text("");
	if(curdataview=="searchname"){
		$("div[appdata-name=optionscontent] p[name=batchyear]").fadeIn(500);
		$("div[appdata-name=optionscontent] input[name=searchdata]").attr("Placeholder","Type the name here");
		$("div[appdata-name=optionscontent] p[name=infopoint]").text("You can search for individual corpers and then print only their photos, you can also use this to print out results based on corp members having the same letter starting thier names");
		$("div[appdata-name=optionscontent]").animate({height:"90"},500,function(){
			$(this).css({"height":"auto","min-height":"90","padding-bottom":"8px","padding":"auto"});
		});
	}else if (curdataview=="vcrange") {
		$("div[appdata-name=optionscontent] p[name=batchyear]").fadeIn(500);
		$("div[appdata-name=optionscontent] input[name=searchdata]").attr("Placeholder","Lower_codeno;Higher_codeno");
		$("div[appdata-name=optionscontent] p[name=infopoint]").text("Search for corp members using their code nos, make sure to choose a batch and year otherwise current year batch 'A' will be used , N.B not the State Code, just the Code Number only, if you want you can enter two set of code numbers, a small one and a large e.g(1132;1156) this will produce results in the range from 1132 to 1156, please adhere to the format else the application will raise errors");
		$("div[appdata-name=optionscontent]").animate({height:"90"},500,function(){
			$(this).css({"height":"auto","min-height":"90"});
		});
	}else if (curdataview=="pparange") {
		$("div[appdata-name=optionscontent] p[name=batchyear]").fadeIn(500);
		$("div[appdata-name=optionscontent] input[name=searchdata]").attr("Placeholder","Type the ppa name here");
		$("div[appdata-name=optionscontent] p[name=infopoint]").text("Search for corp members using their ppa");
		$("div[appdata-name=optionscontent]").animate({height:"90"},500,function(){
			$(this).css({"height":"auto","min-height":"90"});
		});
	}else if(curdataview=="viewall"){
		// alert(curdataview);
		var sublinkreq=new Request();
  sublinkreq.generatetwo('#printzone',true);
  //enter the url
  sublinkreq.url('./snippets/display.php?displaytype='+curdataview+'&extraval=admin');
  //send request
  sublinkreq.opensend('GET');
  //update dom when finished, takes four params targetElement,entryType,entryEffect,period
  sublinkreq.update('div#printzone','html','fadeIn',1000);
	}

});


});