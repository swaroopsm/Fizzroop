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
	var flag;
	$.getJSON("session", function(session){
		flag=session.adminLoggedin;
		if(flag==true){
			$("#ajaxer").html("<div class='loader'><img src='images/loader.gif'/></div>");
			$.getJSON("abstract/view", function(data){
				obj = [];
				if(data.length>0){
					for(i=0;i<data.length;i++){
							var l = data[i].reviewers.length;
							var r = data[i].recommendations;
							var ratings = "";
							var t, ra="";
							for(var j=0;j<r.length;j++){
								ra = r[j].recommendation;
								switch(ra){
									case '1': ra = "T"; //@TODO Add icon for Talk.
														break;
												
									case '2': ra = "P"; //@TODO Add icon for Poster.
														break;
											
									case '3': ra = "R"; //@TODO Add icon for Reject.
														break;
												
									default : ra = "-";
														break;
								}
								ratings = ratings + ra + " ";
							}
							switch(l){
								case 0: obj.push({
									"title": "<a href='#"+data[i].abstractID+"' class='abstract_title'>"+data[i].abstractTitle+"</a>",
									"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
									"reviewer1": "-",
									"reviewer2": "-",
									"reviewer3": "-",
									"ratings": ratings,
									"score": data[i].score
								});
								break;
				
								case 1: obj.push({
									"title": "<a href='#"+data[i].abstractID+"' class='abstract_title'>"+data[i].abstractTitle+"</a>",
									"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
									"reviewer1": data[i].reviewers[0].reviewerFirstName,
									"reviewer2": "-",
									"reviewer3": "-",
									"ratings": ratings,
									"score": data[i].score
								});
								break;
				
								case 2: obj.push({
									"title": "<a href='#"+data[i].abstractID+"' class='abstract_title'>"+data[i].abstractTitle+"</a>",
									"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
									"reviewer1": data[i].reviewers[0].reviewerFirstName,
									"reviewer2": data[i].reviewers[1].reviewerFirstName,
									"reviewer3": "-",
									"ratings": ratings,
									"score": data[i].score
								});
								break;
				
								case 3: obj.push({
									"title": "<a href='#"+data[i].abstractID+"' class='abstract_title'>"+data[i].abstractTitle+"</a>",
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
											"sTitle": "&#9673; 1",
											"sClass": "reviewer1"
										},
										{ 
											"mDataProp": "reviewer2",
											"sTitle": "&#9673; 2",
											"sClass": "reviewer2"
										},
										{ 
											"mDataProp": "reviewer3",
											"sTitle": "&#9673; 3",
											"sClass": "reviewer3"
										},
										{ 
											"mDataProp": "ratings",
											"sTitle": "Rating",
											"sClass": "ratings"
										},
										{ 
											"mDataProp": "score",
											"sTitle": "Score",
											"sClass": "score"
										}
								]
					});		
				}
				else{
					$("#ajaxer").html("<h2 class='no-records'>\" No Abstracts have been uploaded yet! \"</h2>");
				}
		
			});
			return false;
		}
		else{
			window.location = "admin";
			return true;
		}
	});
	
	return false;
});

/**
	* Abstract Title click function that returns json of all the details of an Abstract.
**/

$(".abstract_title").live("click", function(){
	var id = $(this).attr("href");
	id = id.substring(1);
	$("#myModal").modal({
		keyboard: true,
		backdrop: 'static',
		show: true
	});
	$("#abstractModalLabel").html("");
	$("#abstractData").html('').append("<div class='loader'><img src='images/loader.gif' /></div>");
	$.getJSON("abstract/"+id, function(data){
		console.log(data); // take this out later post completion
		$("#abstractModalLabel").html(data[0].abstractTitle);
		$("#abstractData").html(
			"by "+data[0].attendeeFirstName+" "+data[0].attendeeLastName+"<br>"
			+"<br>"+"<h2>content</h2>"
			+data[0].abstractContent
			+"<div id='imagesppt'></div>" // need to add the images folder and write necessary JS
			+"<div class='reviewerclass'>"
			+data[0].reviewers[0].reviewerFirstName+" "+data[0].reviewers[0].reviewerLastName // First Reviewer
			+data[0].recommendations[0].recommendation+"<br>" // First reviewer recommendation
			+data[0].reviewers[1].reviewerFirstName+" "+data[0].reviewers[1].reviewerLastName // Second Reviewer
			+data[0].recommendations[1].recommendation+"<br>" // First reviewer recommendation
			// Third reviewer not present breaks the json. and it does not load. if else statement necessary
			// +data[0].reviewers[2].reviewerFirstName+" "+data[0].reviewers[2].reviewerLastName // Third Reviewer
			+"</div>"
			);
	});
	return false;
});


/**
	* Manage Reviewers click function.
**/
$("#manageReviewers").live("click", function(){
	
	$.getJSON("session", function(session){
		flag=session.adminLoggedin;
		if(flag==true){
			$("#ajaxer").html("<div class='loader'><img src='images/loader.gif'/></div>");
			$.getJSON("reviewer/view", function(data){
				if(data.length > 0){
					var obj = [];
					for(var j=0;j<data.length;j++){
						obj.push({
							"reviewerFirstName": "<a href='#"+data[j].reviewerID+"' class='reviewer_id'>"+data[j].reviewerFirstName+"</a>",
							"reviewerLastName": "<a href='#"+data[j].reviewerID+"' class='reviewer_id'>"+data[j].reviewerLastName+"</a>",
							"reviewerEmail": data[j].reviewerEmail,
							"workingAbstracts": data[j].workingAbstracts
						});
					}
					$("#ajaxer").html("<h2 id='title'>REVIEWERS MANAGER</h2><table id='test'></table>");
					$('table#test').dataTable({
								"aaData": obj,
								"sScrollX": "100%",
				 				"bScrollCollapse": true,
				 				"bScrollAutoCss": false,
				 				"iDisplayLength": 50,
								"aoColumns": [
															{
																"mDataProp": "reviewerFirstName",
																"sTitle": "Firstname"
															},
															{
																"mDataProp": "reviewerLastName",
																"sTitle": "Lastname"
															},
															{
																"mDataProp": "reviewerEmail",
																"sTitle": "Email"
															},
															{
																"mDataProp": "workingAbstracts",
																"sTitle": "Abstracts Assigned"
															}
								]
					});
				}
				else{
					$("#ajaxer").html("<h2 class='no-records'>\" There are no Reviewers added! \"</h2>");
				}
			});
		}
		else{
			window.location = "admin";
			return true;
		}
	});
});


/**
	* Reviewer Firstname/Lastname click function that returns json of all the details of a Reviewer.
**/

$(".reviewer_id").live("click", function(){
	var id = $(this).attr("href");
	id = id.substring(1);
	$("#reviewersModal").modal({
		keyboard: true,
		backdrop: 'static',
		show: true
	});
	$("#abstractModalLabel").html("");
	$("#abstractData").html('').append("<div class='loader'><img src='images/loader.gif' /></div>");
	$.getJSON("reviewer/"+id, function(data){
		$("#reviewersModalLabel").html(data.reviewerFirstName+" "+data.reviewerLastName);
		if(data.abstracts){
			if(data.abstracts.length>0){
				$("#reviewersData").html("");
				for(var i=0;i<data.abstracts.length;i++){
					$("#reviewersData").append("Abstract "+(i+1)+": "+data.abstracts[i].abstractTitle+"<br>");
				}
			}
			else{
				$("#reviewersData").html("Working on no abstracts...");
			}	
		}
	});
	return false;
});


/**
	* Manage Attendees click function.
**/

$("#manageAttendees").live("click", function(){
	var flag;
	$.getJSON("session", function(session){
		flag=session.adminLoggedin;
		if(flag==true){
			$("#ajaxer").html("<div class='loader'><img src='images/loader.gif'/></div>");
			$.getJSON("attendee/view", function(data){
				if(data.length > 0){
					var obj = [];
					for(var i=0;i<data.length;i++){
						if(data[i].registered==1){
							var reg="YES";
						}
						else{
							var reg="NO";
						}
						obj.push({
							"attendeeFirstName": "<a href='#"+data[i].attendeeID+"' class='attendee_id'>"+data[i].attendeeFirstName+"</a>",
							"attendeeLastName": "<a href='#"+data[i].attendeeID+"' class='attendee_id'>"+data[i].attendeeLastName+"</a>",
							"attendeeEmail": data[i].attendeeEmail,
							"registered": reg
						});
					}
					$("#ajaxer").html("<h2 id='title'>ATTENDEES MANAGER</h2><table id='test'></table>");
					$('table#test').dataTable({
								"aaData": obj,
								"sScrollX": "100%",
				 				"bScrollCollapse": true,
				 				"bScrollAutoCss": false,
				 				"iDisplayLength": 50,
								"aoColumns": [
															
															{
																"mDataProp": "attendeeFirstName",
																"sTitle": "Firstname"
															},
															{
																"mDataProp": "attendeeLastName",
																"sTitle": "Lastname"
															},
															{
																"mDataProp": "attendeeEmail",
																"sTitle": "Email"
															},
															{
																"mDataProp": "registered",
																"sTitle": "Registered?"
															}
								]
						});
				}
				else{
					$("#ajaxer").html("<h2 class='no-records'>\" There are no Attendees registered! \"</h2>");
				}
			});
		}
		else
		{
			window.location = "admin";
			return true;
		}
	});
	return false;
});


/**
	*	Attendee Firstname/Lastname click function that returns json of all the details of an Attendee.
**/

$(".attendee_id").live("click", function(){
	var id = $(this).attr("href");
	id = id.substring(1);
	$("#attendeeModal").modal({
		keyboard: true,
		backdrop: 'static',
		show: true
	});
	$("#attendeesModalLabel").html("");
	$("#attendeesData").html('').append("<div class='loader'><img src='images/loader.gif' /></div>");
	$.getJSON("attendee/"+id, function(data){
		console.log(data);
		$("#attendeesModalLabel").html(data[0].attendeeFirstName+" "+data[0].attendeeLastName);
		$("#attendeesData").html("");
		var reg = data[0].registered;
		if(reg==1){
			$("#attendeesData").append("<h3>"+data[0].attendeeFirstName+" "+data[0].attendeeLastName+" is registered!</h3>");
		}
		else{
			$("#attendeesData").append("<h3>"+data[0].attendeeFirstName+" "+data[0].attendeeLastName+" is not registered!</h3>");
		}
	});
	return false;
});
