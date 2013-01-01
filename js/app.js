/**
	* Custom JS necessary for application
*/


/**
	* Validate form for emptyness
*/

jQuery.fn.validateFormEmpty = function(){
	
	var inputsTextList = $(this).find("input[type=text], input[type=password]");
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
	var inputsList = $(this).find("input[type=text]");
	var paramList="";
	for(var i=0;i<inputsList.length;i++){
		paramList = paramList+inputsList[i].name+"= "+inputsList[i].value+"&";
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
				resp = "<span class='span6 alert alert-success'><a class='close' data-dismiss='alert' href='#'>&times;</a>"+options.successMsg+"</span>";
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


$("#manageAbstracts").live("click", function(){
	$("#loader").show();
	$.getJSON("abstract/view", function(data){
		obj = [];
		for(i=0;i<data.length;i++){
			var l = data[i].reviewers.length;
			var r = data[i].recommendations;
			var ratings = "";
			var t, ra="";
			for(var j=0;j<r.length;j++){
				ra = r[j].recommendation;
				switch(ra){
					case 0: ra += "N";
									break;
									
					case 1: ra += "T";
									break;
									
					case 2: ra += "P";
									break;
									
					case 3: ra += "R";
									break;
									
					default: ra += "N/A";
				}
				ratings = ratings + ra + " ";
			}
			switch(l){
				case 0: obj.push({
					"title": "<a href='#'>"+data[i].abstractTitle+"</a>",
					"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
					"reviewer1": "-",
					"reviewer2": "-",
					"reviewer3": "-",
					"ratings": ratings,
					"score": data[i].score
				});
				break;
				
				case 1: obj.push({
					"title": "<a href='#'>"+data[i].abstractTitle+"</a>",
					"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
					"reviewer1": data[i].reviewers[0].reviewerFirstName,
					"reviewer2": "-",
					"reviewer3": "-",
					"ratings": ratings,
					"score": data[i].score
				});
				break;
				
				case 2: obj.push({
					"title": "<a href='#'>"+data[i].abstractTitle+"</a>",
					"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
					"reviewer1": data[i].reviewers[0].reviewerFirstName,
					"reviewer2": data[i].reviewers[1].reviewerFirstName,
					"reviewer3": "-",
					"ratings": ratings,
					"score": data[i].score
				});
				break;
				
				case 3: obj.push({
					"title": "<a href='#'>"+data[i].abstractTitle+"</a>",
					"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
					"reviewer1": data[i].reviewers[0].reviewerFirstName,
					"reviewer2": data[i].reviewers[1].reviewerFirstName,
					"reviewer3": data[i].reviewers[2].reviewerFirstName,
					"ratings": ratings,
					"score": data[i].score
				});
				break;
				
			}
		}
		$("#ajaxer").html("<h2 id='title'>ABSTRACTS MANAGER</h2><table id='test'></table>");
		$('table#test').dataTable({
				"aaData": obj,
				"sScrollX": "100%",
 				"bScrollCollapse": true,
 				"bScrollAutoCss": false,
 				"iDisplayLength": 50,
				"aoColumns": [
				    { 
				    	"mDataProp": "title",
				    	"sTitle": "Title",
				    	"sClass": "title"
				    },
				    { 
				    	"mDataProp": "attendee",
				    	"sTitle": "Attendee",
				    	"sClass": "attendee"
				    },
				    { 
				    	"mDataProp": "reviewer1",
				    	"sTitle": "&#10022; 1",
				    	"sClass": "reviewer1"
				    },
				    { 
				    	"mDataProp": "reviewer2",
				    	"sTitle": "&#10022; 2",
				    	"sClass": "reviewer2"
				    },
				    { 
				    	"mDataProp": "reviewer3",
				    	"sTitle": "&#10022; 3",
				    	"sClass": "reviewer3"
				    },
				    { 
				    	"mDataProp": "ratings",
				    	"sTitle": "Ratings",
				    	"sClass": "ratings"
				    },
				    { 
				    	"mDataProp": "score",
				    	"sTitle": "Score",
				    	"sClass": "score"
				    }
				]
	});		
	});
	return false;
});



//but if you did this? then ehat?
