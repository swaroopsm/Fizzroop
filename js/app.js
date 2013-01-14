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
							var reviewer1_actual, reviewer2_actual, reviewer3_actual;
							var reviewer1_blah = data[i].reviewers[0].reviewerFirstName;
							var reviewer2_blah = data[i].reviewers[1].reviewerFirstName;
							var reviewer3_blah = data[i].reviewers[2].reviewerFirstName;
							if(reviewer1_blah == ""){
								reviewer1_actual = "<span id='reviewer1_"+data[i].abstractID+"'><a href='#' data-row='1' data-reviewer='' data-abstract='"+data[i].abstractID+"' class='reviewer_assign_click'>Assign a Reviewer</a><span>";
							}
							else{
								reviewer1_actual = "<span id='reviewer1_"+data[i].abstractID+"'><a href='#' data-row='1' data-reviewer='"+data[i].reviewers[0].reviewerID+"' data-abstract='"+data[i].abstractID+"' class='reviewer_assign_click'>"+data[i].reviewers[0].reviewerFirstName+"</a></span>";
							}
							if(reviewer2_blah == ""){
								reviewer2_actual = "<span id='reviewer2_"+data[i].abstractID+"'><a href='#' data-row='2' data-reviewer='' data-abstract='"+data[i].abstractID+"' class='reviewer_assign_click'>Assign a Reviewer</a><span>";
							}
							else{
								reviewer2_actual = "<span id='reviewer2_"+data[i].abstractID+"'><a href='#' data-row='2' data-reviewer='"+data[i].reviewers[1].reviewerID+"' data-abstract='"+data[i].abstractID+"' class='reviewer_assign_click'>"+data[i].reviewers[1].reviewerFirstName+"</a></span>";
							}
							if(reviewer3_blah == ""){
								reviewer3_actual = "<span id='reviewer3_"+data[i].abstractID+"'><a href='#' data-row='3' data-reviewer='' data-abstract='"+data[i].abstractID+"' class='reviewer_assign_click'>Assign a Reviewer</a></span>";
							}
							else{
								reviewer3_actual = "<span id='reviewer3_"+data[i].abstractID+"'><a href='#' data-row='3' data-reviewer='"+data[i].reviewers[2].reviewerID+"' data-abstract='"+data[i].abstractID+"' class='reviewer_assign_click'>"+data[i].reviewers[2].reviewerFirstName+"</a></span>";
							}
							for(var j=0;j<r.length;j++){
								ra = r[j].recommendation;
								switch(ra){
									case '1': ra = "<img src='images/talk.png'>"; //@TODO Add icon for Talk.
														break;
												
									case '2': ra = "<img src='images/poster.png'>"; //@TODO Add icon for Poster.
														break;
											
									case '3': ra = "<img src='images/reject.gif'>"; //@TODO Add icon for Reject.
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
									"reviewer1": reviewer1_actual,
									"reviewer2": reviewer2_actual,
									"reviewer3": reviewer3_actual,
									"ratings": ratings,
									"score": data[i].score
								});
								break;
				
								case 1: obj.push({
									"title": "<a href='#"+data[i].abstractID+"' class='abstract_title'>"+data[i].abstractTitle+"</a>",
									"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
									"reviewer1": reviewer1_actual,
									"reviewer2": reviewer2_actual,
									"reviewer3": reviewer3_actual,
									"ratings": ratings,
									"score": data[i].score
								});
								break;
				
								case 2: obj.push({
									"title": "<a href='#"+data[i].abstractID+"' class='abstract_title'>"+data[i].abstractTitle+"</a>",
									"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
									"reviewer1": reviewer1_actual,
									"reviewer2": reviewer2_actual,
									"reviewer3": reviewer3_actual,
									"ratings": ratings,
									"score": data[i].score
								});
								break;
				
								case 3: obj.push({
									"title": "<a href='#"+data[i].abstractID+"' class='abstract_title'>"+data[i].abstractTitle+"</a>",
									"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
									"reviewer1": reviewer1_actual,
									"reviewer2": reviewer2_actual,
									"reviewer3": reviewer3_actual,
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
	$("#abstractBy").html('').append("<div class='loader'><img src='images/loader.gif' /></div>");
	$("#abstractContent").html("");
	$.getJSON("abstract/"+id, function(data){
		console.log(data); // take this out later post completion
		$("#hidden_abstractID").html("<input type='hidden' id='abstractID' value='"+data[0].abstractID+"'/>");
		$("#abstractModalLabel").html(data[0].abstractTitle);
		var revf1="", revf2="", revf3="", revl1="", revl2="", revl3="";
		var rec1="", rec2="", rec3="";
		var recs = data[0].recommendations;
		if(recs.length == 1){
				rec1 = recs[0].recommendation;
		}
		else if(recs.length == 2){
				rec1 = recs[0].recommendation;
				rec2 = recs[1].recommendation;
		}
		else if(recs.length == 3){
				rec1 = recs[0].recommendation;
				rec2 = recs[1].recommendation;
				rec3 = recs[2].recommendation;
		}
		else{
			
		}
		
		var comment = "";
		var revs = data[0].reviewers;
		if(revs.length == 1){
				revf1 = revs[0].reviewerFirstName;
				revl1 = revs[0].reviewerLastName;
		}
		else if(revs.length == 2){
				revf1 = revs[0].reviewerFirstName;
				revl1 = revs[0].reviewerLastName;
				revf2 = revs[1].reviewerFirstName;
				revl2 = revs[1].reviewerLastName;
		}
		else if(recs.length == 3){
				revf1 = revs[0].reviewerFirstName;
				revl1 = revs[0].reviewerLastName;
				revf2 = revs[1].reviewerFirstName;
				revl2 = revs[1].reviewerLastName;
				revf3 = revs[2].reviewerFirstName;
				revl3 = revs[2].reviewerLastName;
		}
		else{
			
		}
		
		if(data[0].comments.length > 0){
			for(var k=0;k<data[0].comments.length;k++){
				//@TODO @gonecase needs to fix some styling stuffs in order to display the comments neatly!!
				console.log(data[0].comments[k].commentContent);
			}
		}
		$("#abstractBy").html(
			"by "+data[0].attendeeFirstName+" "+data[0].attendeeLastName+"<br>"
			);
		$("#abstractContent").html(
			"<div id='imagesppt'></div>" // need to add the images folder and write necessary JS
			+"<div id='modalleft'>"
			+"<div id='abscontent' contenteditable='true'>"+data[0].abstractContent+"</div>"
			+"<div class='reviewerclass'>"
			+revf1+" "+revl1 // First Reviewer
			+rec1+"<br>" // First reviewer recommendation
			+revf2+" "+revl2 // Second Reviewer
			+rec2+"<br>" // First reviewer recommendation
			// Third reviewer not present breaks the json. and it does not load. if else statement necessary
			+revf3+" "+revl3 // Third Reviewer
			+rec3
			+"<div id='actions'>"+""+"</div>"
			+"</div>" // the left div
			+"<div class='clear'></div>" // clearing floats before the comments section
			+"<div id='comments'>"+"</div>"
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
	$("#reviewersModalLabel").html("");
	$("#reviewersData").html('').append("<div class='loader'><img src='images/loader.gif' /></div>");
	$.getJSON("reviewer/"+id, function(data){
		$("#hidden_reviewerID").html("<input type='hidden' id='inputReviewerID' value='"+data.reviewerID+"'/>");
		$("#reviewersModalLabel").html(data.reviewerFirstName+" "+data.reviewerLastName);
		if(data.abstracts){
			if(data.abstracts.length>0){
				$("#reviewersData").html("");
				$("#reviewersData").append(
					"<div id='editReviewerForm'>"
					+"Firstname: <input id='inputFirstName' value='"+data.reviewerFirstName+"'<br><br>"
					+"Lastname: <input id='inputLastName' value='"+data.reviewerLastName+"'<br><br>"
					+"Email: <input id='inputEmail' value='"+data.reviewerEmail+"'"
					+"</div>"
				);
				for(var i=0;i<data.abstracts.length;i++){
					$("#reviewersData").append("<div id='abstract_"+data.abstracts[i].abstractID+"'>Abstract "+(i+1)+": "+data.abstracts[i].abstractTitle+" <a href='#"+data.abstracts[i].abstractID+"' data-reviewer='"+data.reviewerID+"' class='unassign_reviewer'>Unassign</a><br></div>");
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
		$("#hidden_attendeeID").html("<input type='hidden' id='inputAttendeeID' value='"+data[0].attendeeID+"'/>");
		$("#attendeesModalLabel").html(data[0].attendeeFirstName+" "+data[0].attendeeLastName);
		$("#attendeesData").html("");
		$("#attendeesData").append(
			"<div id='editAttendeeForm'>"
					+"Firstname: <input id='inputAttendeeFirstName' value='"+data[0].attendeeFirstName+"'<br><br>"
					+"Lastname: <input id='inputAttendeeLastName' value='"+data[0].attendeeLastName+"'<br><br>"
					+"Email: <input id='inputAttendeeEmail' value='"+data[0].attendeeEmail+"'"
					+"</div>"
		);
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


/**
	* Edit button action for Abstracts.
**/

$("#abstract_edit_submit").live("click", function(){
	var id = $("#abstractID").val();
	var title = $("#abstractModalLabel").html().replace(/&nbsp;/gi, "");
	var content = $("#abscontent").html().replace(/&nbsp;/gi, "");
	var title_strip_html = title.replace(/(<([^>]+)>)/ig,"");
	var content_strip_html = content.replace(/(<([^>]+)>)/ig,"");
	$.post("abstract/update", {inputAbstractID: id, inputAbstractTitle: title, inputAbstractContent: content},
	function(data){
		console.log(data);
	});
});


/**
	*	Edit button action for Reviewers.
**/

$("#reviewer_edit_submit").live("click", function(){
	$.post("reviewer/update", {
			inputFirstName: $.trim($("#inputFirstName").val()),
			inputLastName: $.trim($("#inputLastName").val()),
			inputEmail: $.trim($("#inputEmail").val()),
			inputReviewerID: $("#inputReviewerID").val()
		},
	function(data){
		console.log(data);
	});
	return false;
});


/**
	*	Unassign click function.
**/

$(".unassign_reviewer").live("click", function(){
	var abstractID = $(this).attr("href").substring(1);
	var reviewerID = $("#inputReviewerID").val();
	$.post("abstract/unassign", {
		inputReviewerID: reviewerID,
		inputAbstractID: abstractID
	},
	function(data){
		obj = $.parseJSON(data);
		if(obj.success){
			$("#abstract_"+abstractID).fadeOut(300);
		}
	});
	return false;
});


/**
	*	Edit button action for Attendee.
**/

$("#attendee_edit_submit").live("click", function(){
	$.post("attendee/update", {
		inputAttendeeID: $("#inputAttendeeID").val(),
		inputFirstName: $.trim($("#inputAttendeeFirstName").val()),
		inputLastName: $.trim($("#inputAttendeeLastName").val()),
		inputEmail: $.trim($("#inputAttendeeEmail").val())
	},
	function(data){
		console.log(data);
	});
});


/**
	* Add Reviewer Modal open.
**/

$("#add_reviewer").live("click", function(){
	$("#js-messages").hide();
	$("#addReviewerModal").modal({
		keyboard: true,
		backdrop: 'static',
		show: true
	});
	return false;
});


/**
	* Add Reviewer click function.
**/

$("form#new_reviewer").submit(function(){
	var stat = $(this).validateFormEmpty();
	if(stat.success){
		$(this).asyncSubmit({
			'target': '#js-messages',
			'loadTarget': '#loader',
			'loader': '<br><img src="<?php echo base_url()."images/loader.gif"; ?>">',
			'successMsg': 'Reviewer added successfully!',
			'errorMsg': 'There was an error, please try again later!'
		});
	}else{
		$("#js-messages").html("<span class='span6 alert alert-danger'>"+stat.errorMsg+"</span>").hide().fadeIn(500);
	}
	return false;
});

/**
	*	Reviewer Assign click function.
**/

$(".reviewer_assign_click").live("click", function(){
	var abstractID = $(this).attr("data-abstract");
	var reviewerID = $(this).attr("data-reviewer");
	var reviewername = "reviewer"+$(this).attr("data-row");
	var currect_reviewers = [];
	$.getJSON("reviewer/view", function(data){
		for(var i=0;i<data.length;i++){
			if(data[i].abstracts.length>0){
				if($.inArray(abstractID, data[i].abstracts) > -1){
				}
				else{
					currect_reviewers.push(data[i]);
				}
			}
			else{
				currect_reviewers.push(data[i]);
			}
		}
		var reviewersLink = "";
		for(var k=0;k<currect_reviewers.length;k++){
			reviewersLink = reviewersLink + "<a href='#' class='assign_me' data-reviewername='"+reviewername+"' data-reviewer='"+currect_reviewers[k].reviewerID+"' data-abstract='"+abstractID+"'>"+currect_reviewers[k].reviewerFirstName+"</a>, ";
		}
		$("#reviewersListData").html(reviewersLink.substring(0, reviewersLink.length-2));
	});
	$("#reviewersListModal").modal({
		keyboard: true,
		backdrop: 'static',
		show: true
	});
	return false;
});


/**
	*Finally Assign a Reviewer to an Abstract
**/

$(".assign_me").live("click", function(){
	var reviewername = $.trim($(this).attr("data-reviewername"));
	var abstractID = $.trim($(this).attr("data-abstract"));
	var reviewerID = $.trim($(this).attr("data-reviewer"));
	$.post(
		"abstract/assign",
		{
			"abstractID": abstractID,
			"reviewerID": reviewerID,
			"reviewername": reviewername
		},
		function(obj){
			var data = $.parseJSON(obj)
			if(data.success){
				$("#reviewersListModal").modal('toggle')
				$("#"+reviewername+"_"+abstractID).html("<span id='"+reviewername+"_"+abstractID+"'><a href='#' data-row='"+reviewername.substring(reviewername.length-1, reviewername.length)+"' data-reviewer='"+data.reviewerID+"' data-abstract='"+abstractID+"' class='reviewer_assign_click'>"+data.reviewerFirstName+"</a></span>");
			}
		}
	);
});
