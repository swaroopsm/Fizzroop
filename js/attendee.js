/**
	* Validate form for emptyness
*/

jQuery.fn.validateFormEmpty = function(){
	
	var inputsTextList = $(this).find("input[type=text], input[type=password], textarea, select, input[type=file]");
	var inputsLabelList = $(this).find("label");
	var flag = 0;
	var errorMsg = "";
	for(var i=0;i<inputsTextList.length;i++){
		if($.trim(inputsTextList[i].value) == ''){
			errorMsg = errorMsg + "<strong>" + inputsLabelList[i].outerText.substring(0, inputsLabelList[i].outerText.length-1) + "</strong>, ";
			flag++;
		}
	}
	
	if(flag>0){
		errorMsg = errorMsg.substring(0,errorMsg.length-2)+" cannot be empty!";
		return {"success": false, "errorMsg": errorMsg}; 
	}
	else{
		return {"success": true};
	}
	
};

/**
	* Submit form via Ajax
*/

jQuery.fn.asyncSubmit = function(options){
	
	$(options.loadTarget).html(options.loader).show();
	var inputsList = $(this).find("input[type=text], input[type=password]");
	var paramList="";
	for(var i=0;i<inputsList.length;i++){
		paramList = paramList+inputsList[i].name+"="+inputsList[i].value+"&";
	}
	paramList = paramList.substring(0,paramList.length-1);
	var url = $(this).attr("action");
	var method = $(this).attr("method");
	var formID = "#"+$(this).attr("id");
	$.ajax({
		url: url,
		type: 'POST',
		data: paramList,
		success: function(data){
			var obj=jQuery.parseJSON(data);
			var resp;
			if(obj.success)
				resp = "<span class='span6 alert alert-success'>"+options.successMsg+"</span>";
			else
				resp = "<span class='span6 alert alert-danger'>"+options.errorMsg+"</span>";
			$(options.target).html(resp).hide().fadeIn(500);
			$(formID)[0].reset();
			$(options.loadTarget).html('').show();
		},
		error: function(data){
			console.log(data);
		}
	});
	
}

// Setup links for loading into modals and divs.

// Load abstract form
$("a.absubmit").click(function(){
	// clear the holding div first
	$('.submitabstractform').css({display:'block'});
	$('.message').css({display: 'none'});
	$('.guidelines').css({display: 'none'});
	return false;
});

$("a.absguide").click(function(){
	// clear the holding div first
	$('.guidelines').css({display:'block'});
	$('.message').css({display: 'none'});
	$('.submitabstractform').css({display:'none'});
	return false;
});


$("form#new_abstract").live("submit", function(e){
	e.preventDefault();
	var stat = $(this).validateFormEmpty();
	if(stat.success){
		$(this).ajaxSubmit(function(data){
		console.log(data)
	});
	}
	return false;
});

$("a.abview").click(function(){
	$.getJSON("abstract/"+absid, function(data){
		console.log(data);
		var messagediv = $('.message');
		messagediv.html('');
		messagediv.append("<h2>"+data[0].abstractTitle+"</h2><img src='"+data[0].abstractImageFolder+"'>");
		var abscontent = data[0].abstractContent;
		abscontent = $.parseJSON(abscontent);
		messagediv.append("<h3>Methods</h3><p>"+abscontent.methods+"</p>");
		messagediv.append("<h3>Aim</h3><p>"+abscontent.aim+"</p>");
		messagediv.append("<h3>Results</h3><p>"+abscontent.results+"</p>");
		messagediv.append("<h3>Conservation</h3><p>"+abscontent.conservation+"</p>");
		console.log(abscontent);
		
	});
});
