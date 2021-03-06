/**
	* Custom JS necessary for application
*/


console.log(base_url);

/**
	* Validate form for emptyness
*/

jQuery.fn.validateFormEmpty = function(){
	
	var inputsTextList = $(this).find("input[type=text], input[type=password], textarea, select");
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
	var inputsList = $(this).find("input[type=text], input[type=password], textarea, select");
	var paramList="";
	for(var i=0;i<inputsList.length;i++){
		paramList = paramList+inputsList[i].name+"="+inputsList[i].value+"&";
	}
	paramList = paramList.substring(0,paramList.length-1);
	paramList += "&"+token[0]+"="+token[1];
	console.log(paramList);
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
			if(options.callback){
				switch(options.callback){
					case 'new_attendee': new_attendee_change(obj);
										 break;

					case 'new_reviewer': new_reviewer_change(obj);
										 break;
				}
			}
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
														
									case '0': ra = "<img src='images/reject.gif'>"; //@TODO Add icon for Reject.
														break;
												
									default : ra = "-";
														break;
								}
								ratings = ratings + ra + " ";
							}
							var status;
							switch(data[i].approved){
									case '1': status = "<img src='images/talk.png' title='Talk'>"; //@TODO Add icon for Talk.
														break;
												
									case '2': status = "<img src='images/poster.png' title='Poster'>"; //@TODO Add icon for Poster.
														break;
											
									default: status = "<img src='images/reject.gif' title='Rejected'>"
												
							}
							switch(l){
								case 0: obj.push({
									"title": "<a href='#"+data[i].abstractID+"' class='abstract_title'>"+data[i].abstractTitle+"</a>",
									"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
									"reviewer1": reviewer1_actual,
									"reviewer2": reviewer2_actual,
									"reviewer3": reviewer3_actual,
									"ratings": ratings,
									"score": data[i].score,
									"status": status
								});
								break;
				
								case 1: obj.push({
									"title": "<a href='#"+data[i].abstractID+"' class='abstract_title'>"+data[i].abstractTitle+"</a>",
									"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
									"reviewer1": reviewer1_actual,
									"reviewer2": reviewer2_actual,
									"reviewer3": reviewer3_actual,
									"ratings": ratings,
									"score": data[i].score,
									"status": status
								});
								break;
				
								case 2: obj.push({
									"title": "<a href='#"+data[i].abstractID+"' class='abstract_title'>"+data[i].abstractTitle+"</a>",
									"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
									"reviewer1": reviewer1_actual,
									"reviewer2": reviewer2_actual,
									"reviewer3": reviewer3_actual,
									"ratings": ratings,
									"score": data[i].score,
									"status": status
								});
								break;
				
								case 3: obj.push({
									"title": "<a href='#"+data[i].abstractID+"' class='abstract_title'>"+data[i].abstractTitle+"</a>",
									"attendee": data[i].attendeeFirstName+" "+data[i].attendeeLastName,
									"reviewer1": reviewer1_actual,
									"reviewer2": reviewer2_actual,
									"reviewer3": reviewer3_actual,
									"ratings": ratings,
									"score": data[i].score,
									"status": status
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
										},
										{
											"mDataProp": "status",
											"sTitle": "Status",
											"sClass": "status"
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
		console.log(data);
		if(data[0].bursary){
			var bursary = $.parseJSON(data[0].bursary);
		}
		else{
			var bursary = "";
		}
		$("#hidden_abstractID").html("<input type='hidden' id='abstractID' value='"+data[0].abstractID+"'/>");
		$("#abstractModalLabel").html(data[0].abstractTitle);
		var abstractimageurl = "";
		if (data[0].abstractImageFolder == base_url+"uploads/") {
			abstractimageurl += "";
		} else {
			abstractimageurl += "<div id='imagesppt'><img src='"+data[0].abstractImageFolder+"'/></div><div class='imagelink'>"+"<a href='"+data[0].abstractImageFolder+"' target='_blank'>See the Image Full size(It will open in a new window).</a></div>"
		}
		var abstractcontent = $.parseJSON(data[0].abstractContent);
		console.log(abstractcontent);
		var reviewer_and_score = "";
		if(data[0].reviewers.length > 0){
			reviewer_and_score += "<div class='assignedreviewers'><h3>Reviewers Assigned: </h3>";
				for(var m=0;m<data[0].reviewers.length;m++){
					reviewer_and_score += "<p>"+data[0].reviewers[m].reviewerFirstName+" "+data[0].reviewers[m].reviewerLastName+"</p>"
				}
			reviewer_and_score += "</div>"
		}
		comment = "";
		if(data[0].detailed_scores.length > 0){
			//reviewer_and_score += "";
			reviewer_and_score += "<div class='reviewerandscore'><div class='avgscore'><div class='smallertitle'>AVERAGE SCORE BY REVIEWERS</div>"+data[0].score+"/10</div>";
			for(var l=0;l<data[0].detailed_scores.length;l++){
				var reviewer_recommendation = ""
				if(data[0].detailed_scores[l].recommendation){
					var r_rec = data[0].detailed_scores[l].recommendation;
					switch(r_rec){
						case '1': reviewer_recommendation = "<img src='images/talk.png' title='Talk'>";
											break;
											
						case '2': reviewer_recommendation = "<img src='images/poster.png' title='Poster'>";
											break;
											
						case '0': reviewer_recommendation = "<img src='images/reject.gif' title='Rejected'>";
											break;
											
						case '': reviewer_recommendation = "<img src='images/reject.gif' title='Rejected'>";
												 break;
											
						default: reviewer_recommendation = "<img src='images/reject.gif' title='Rejected'>";
					}
				}
				if(data[0].detailed_scores[l].reviewer){
					var score_obj = $.parseJSON(data[0].detailed_scores[l].score);
					reviewer_and_score += "<div class='singlereviewer'><h3>"+data[0].detailed_scores[l].reviewer[0].reviewerFirstName+" "+data[0].detailed_scores[l].reviewer[0].reviewerLastName+"</h3><p>&#10143; Conservation Score: "+score_obj.conservation+"</p><p>&#10143; Science Score: "+score_obj.science+"</p><p>&#10143; Recommended: "+reviewer_recommendation+"</p></div>";
				}
			}
			reviewer_and_score += "</div>";
		}
		
		if(data[0].comments.length > 0){
			comment += "<h3>Reviewers' Comments: </h3>";
			for(var k=0;k<data[0].comments.length;k++){
				var comment_type = data[0].comments[k].commentType;
				//@TODO Think of a way to hold the commentID to update or create a comment.
				if(comment_type == 1){
					var comment1_id=data[0].comments[k].commentID;
					comment += "<p>&#10143;"+data[0].comments[k].reviewerFirstName+" told Reviewer: <p><textarea id='comment_reviewer_"+data[0].comments[k].commentID+"'>"+data[0].comments[k].commentContent+"</textarea></p></p>";
				}
				if(comment_type == 2){
					var comment2_id=data[0].comments[k].commentID;
					comment += "<p>&#10143;"+data[0].comments[k].reviewerFirstName+" told Admin: <p><textarea id='comment_admin_"+data[0].comments[k].commentID+"'>"+data[0].comments[k].commentContent+"</textarea></p></p><button data-comment1='"+comment1_id+"' data-comment2='"+comment2_id+"' class='update_comments_btn'>Update Comment</button><hr>";
				}
			}
		}
		else{
			// comment += "<p>Comment to Reviewer: <textarea id='comment_reviewer'></textarea></p>";
			comment += "";
		}
		$("#abstractBy").html(
			"by "+data[0].attendeeFirstName+" "+data[0].attendeeLastName+"<br>"
			);
		$("#abstractContent").html(
			abstractimageurl
			//"<div id='imagesppt'><img src='"+data[0].abstractImageFolder+"'/></div>" // need to add the images folder and write necessary JS
			+"<div id='modalleft'>"
			+"<div id='abscontent'>"
			+"<div class='abscontentdiv'><h3>Methods</h3>"
			+"<div class='editable' contenteditable='true' id='edit_abstract_methods'>"+abstractcontent.methods+"</div></div>"
			+"<div class='abscontentdiv'><h3>Aim</h3>"
			+"<div class='editable' contenteditable='true' id='edit_abstract_aim'>"+abstractcontent.aim+"</div></div>"
			+"<div class='abscontentdiv'><h3>Conservation</h3>"
			+"<div class='editable' contenteditable='true' id='edit_abstract_conservation'>"+abstractcontent.conservation+"</div></div>"
			+"<div class='abscontentdiv'><h3>Results</h3>"
			+"<div class='editable' contenteditable='true' id='edit_abstract_results'>"+abstractcontent.results+"</div>"
			+"</div>"
			+"<div>"
			+"<br><h3>Authors</h3>"
			+"<p>"+data[0].abstractAuthors+"</p>"
			+"</div>"
			+"<div><br><h3>Bursary</h3>"
			+"<p>Why Bursar: "+bursary.bursary_why+"</p>"
			+"<p>Reason for Bursar: "+bursary.bursary_for+"</p>"
			+"</div>"
			+"<br><button class='btn btn-primary' id='abstract_edit_submit'>Save changes</button>"
			+"</div>"
			+"<div class='reviewerclass'>"
			+reviewer_and_score
			+"<div id='actions'>"+""+"</div>"
			+"</div>" // the left div
			+"<div class='clear'></div>" // clearing floats before the comments section
			+"<div id='comments'>"+comment+"</div>"
		);
		
		if(data[0].approved){
								var rec = data[0].approved;
								switch(rec){
									case '1': recommendation = "<input type='radio' name='recommendation_admin' id='recommendation_admin' value='1' checked='checked'/>Talk <input type='radio' name='recommendation_admin' id='recommendation_admin' value='2'/>Poster <input type='radio' name='recommendation_admin' id='recommendation_admin' value='3'/>Reject";
														break;
														
									case '2': recommendation = "<input type='radio' name='recommendation_admin' id='recommendation_admin' value='1'/>Talk <input type='radio' name='recommendation_admin' id='recommendation_admin' value='2' checked='checked'/>Poster <input type='radio' name='recommendation_admin' id='recommendation_admin' value='3'/>Reject";
														break;
														
									default: recommendation = "<input type='radio' name='recommendation_admin' id='recommendation_admin' value='1' />Talk <input type='radio' name='recommendation_admin' id='recommendation_admin' value='2'/>Poster <input type='radio' name='recommendation_admin' id='recommendation_admin' value='3' checked='checked'/>Reject";
								}
							}
							else{
								recommendation = "<input type='radio' name='recommendation_admin' id='recommendation_admin' value='1' />Talk <input type='radio' name='recommendation_admin' id='recommendation_admin' value='2'/>Poster <input type='radio' name='recommendation_admin' id='recommendation_admin' value='3' checked='checked'/>Reject";
							}
			$("#recommendation_span").html(recommendation);				
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
							"reviewerID": data[j].reviewerID,
							"reviewerFirstName": "<a href='#"+data[j].reviewerID+"' id='reviewer_row_"+data[j].reviewerID+"'  class='reviewer_id'>"+data[j].reviewerFirstName+" "+data[j].reviewerLastName+"</a>",
							//"reviewerLastName": "<a href='#"+data[j].reviewerID+"' class='reviewer_id'>"+data[j].reviewerLastName+"</a>",
							"reviewerEmail": data[j].reviewerEmail,
							"workingAbstracts": data[j].workingAbstracts
						});
					}
					$("#ajaxer").html("<h2 id='title'>REVIEWERS MANAGER</h2><table id='test'></table>");
					$('table#test').dataTable({
								"aaData": obj,
								"fnCreatedRow": function( nRow, aData, iDataIndex ) {
							       $(nRow).attr('id', "reviewerRow_"+aData.reviewerID);
							   },
								"sScrollX": "100%",
				 				"bScrollCollapse": true,
				 				"bScrollAutoCss": false,
				 				"iDisplayLength": 50,
								"aoColumns": [
															{
																"mDataProp": "reviewerFirstName",
																"sTitle": "Name"
															},
															// {
															// 	"mDataProp": "reviewerLastName",
															// 	"sTitle": "Lastname"
															// },
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
		$("#reviewersData").html("");
				$("#reviewersData").append(
					"<div id='editReviewerForm'>"
					+"<label for='inputFirstName'>Firstname</label> <input id='inputFirstName' value='"+data.reviewerFirstName+"'<br><br>"
					+"<label for='inputLastName'>Lastname</label> <input id='inputLastName' value='"+data.reviewerLastName+"'<br><br>"
					+"<label for='inputEmail'>Email</label> <input id='inputEmail' value='"+data.reviewerEmail+"'"
					+"</div>"
				);
		if(data.abstracts){
			if(data.abstracts.length>0){
				$("#reviewersData").append("<div class='larger'>Abstracts Assigned</div> ");
				for(var i=0;i<data.abstracts.length;i++){
					$("#reviewersData").append("<div id='abstract_"+data.abstracts[i].abstractID+"'>"+data.abstracts[i].abstractTitle+" <a href='#"+data.abstracts[i].abstractID+"' data-reviewer='"+data.reviewerID+"' class='unassign_reviewer'>Unassign</a><br></div>");
				}
			}
			else{
				$("#reviewersData").append("<p>This reviewer has not been assigned any abstracts to review.</p>");
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
							"attendeeID": data[i].attendeeID,
							"attendeeFirstName": "<a href='#"+data[i].attendeeID+"' class='attendee_id'>"+data[i].attendeeFirstName+" "+data[i].attendeeLastName+"</a>",
							//"attendeeLastName": "<a href='#"+data[i].attendeeID+"' class='attendee_id'>"+data[i].attendeeLastName+"</a>",
							"attendeeEmail": data[i].attendeeEmail,
							"attendeeInstAffiliation": data[i].attendeeInstAffiliation,
							"attendeeNationality": data[i].attendeeNationality,
							"attendeePhone": data[i].attendeePhone,
							"registered": reg
						});
					}
					$("#ajaxer").html("<h2 id='title'>ATTENDEES MANAGER</h2><button class='csv-btn' id='attendees_csv_btn'><a href='"+base_url+"export/attendees'>Export as CSV &#11015;</a></button><table id='test'></table>");
					$('table#test').dataTable({
								"aaData": obj,
								"fnCreatedRow": function( nRow, aData, iDataIndex ) {
							        $(nRow).attr('id', "attendeeRow_"+aData.attendeeID);
							    },
								"sScrollX": "100%",
				 				"bScrollCollapse": true,
				 				"bScrollAutoCss": false,
				 				"iDisplayLength": 50,
								"aoColumns": [
															
															{
																"mDataProp": "attendeeFirstName",
																"sTitle": "Name"
															},
															// {
															// 	"mDataProp": "attendeeLastName",
															// 	"sTitle": "Lastname"
															// },
															{
																"mDataProp": "attendeeEmail",
																"sTitle": "Email"
															},
															{
																"mDataProp": "attendeeInstAffiliation",
																"sTitle": "Institution Affiliated"
															},
															{
																"mDataProp": "attendeeNationality",
																"sTitle": "Country"
															},
															{
																"mDataProp": "attendeePhone",
																"sTitle": "Phone"
															},
															{
																"mDataProp": "registered",
																"sTitle": "Abstract Submitted?"
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
					+"<label for='inputAttendeeFirstName'>Firstname</label> <input id='inputAttendeeFirstName' value='"+data[0].attendeeFirstName+"'<br><br>"
					+"<label for='inputAttendeeLastName'>Lastname</label> <input id='inputAttendeeLastName' value='"+data[0].attendeeLastName+"'<br><br>"
					+"<label for='inputAttendeeEmail'>Email</label> <input id='inputAttendeeEmail' value='"+data[0].attendeeEmail+"'<br><br>"
					+"<label for='inputAttendeeGender'>Gender</label> <input id='inputAttendeeGender' value='"+data[0].attendeeGender+"'<br><br>"
					+"<label for='inputAttendeeDOB'>Date Of Birth</label> <input id='inputAttendeeDOB' value='"+data[0].attendeeDOB+"'> YYYY-MM-DD<br><br>"
					+"<label for='inputAttendeeAcademic'>Academic Status</label> <input id='inputAttendeeAcademic' value='"+data[0].attendeeAcademic+"'<br><br>"
					+"<label for='inputAttendeeInstAffiliation'>Institution Affiliated</label> <input id='inputAttendeeInstAffiliation' value='"+data[0].attendeeInstAffiliation+"'<br><br>"
					+"<label for='inputAttendeeAddress'>Address</label> <textarea id='inputAttendeeAddress' rows='4' cols='30'>"+data[0].attendeeAddress+"</textarea><br><br>"
					+"<label for='inputAttendeePhone'>Phone</label> <input id='inputAttendeePhone' value='"+data[0].attendeePhone+"'<br><br>"
					+"<label for='inputAttendeeNationality'>Country</label> <input id='inputAttendeeNationality' value='"+data[0].attendeeNationality+"'<br><br>"
					+"<label for='inputAttendeePassport'>Passport</label> <input id='inputAttendeePassport' value='"+data[0].attendeePassport+"'<br><br>"
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
	var title = $("#abstractModalLabel").html().replace(/&nbsp;/gi, "").replace(/(<([^>]+)>)/ig,"");
	//var content = $("#abscontent").html().replace(/&nbsp;/gi, "");
	//var title_strip_html = title.replace(/(<([^>]+)>)/ig,"");
	//var content_strip_html = content.replace(/(<([^>]+)>)/ig,"");
	var methods_content = $("#edit_abstract_methods").html().replace(/&nbsp;/gi, "").replace(/(<([^>]+)>)/ig,"");
	var aim_content = $("#edit_abstract_aim").html().replace(/&nbsp;/gi, "").replace(/(<([^>]+)>)/ig,"");
	var conservation_content = $("#edit_abstract_conservation").html().replace(/&nbsp;/gi, "").replace(/(<([^>]+)>)/ig,"");
	var results_content = $("#edit_abstract_results").html().replace(/&nbsp;/gi, "").replace(/(<([^>]+)>)/ig,"");
	$.post("abstract/update", 
	{
		inputAbstractID: id, 
		inputAbstractTitle: title, 
		inputAbstractMethods: methods_content,
		inputAbstractAim: aim_content,
		inputAbstractConservation: conservation_content,
		inputAbstractResults: results_content
	},
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
		edit_reviewer_change($.parseJSON(data));
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
		inputEmail: $.trim($("#inputAttendeeEmail").val()),
		inputGender: $.trim($("#inputAttendeeGender").val()),
		inputDOB: $.trim($("#inputAttendeeDOB").val()),
		inputAcademic: $.trim($("#inputAttendeeAcademic").val()),
		inputInstAffiliation: $.trim($("#inputAttendeeInstAffiliation").val()),
		inputAddress: $.trim($("#inputAttendeeAddress").val()),
		inputPhone: $.trim($("#inputAttendeePhone").val()),
		inputNationality: $.trim($("#inputAttendeeNationality").val()),
		inputPassport: $.trim($("#inputAttendeePassport").val())
	},
	function(data){
		edit_attendee_change($.parseJSON(data));
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
			'errorMsg': 'There was an error, please try again later!',
			'callback': 'new_reviewer'
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


/**
	*	New Attendee click function
**/

$("#newAttendee").live("click", function(){
	$("#addAttendeeModal").modal({
		keyboard: true,
		backdrop: 'static',
		show: true
	});
	return false;
});


/**
	* Add Attendee click function.
**/

$("form#new_attendee").submit(function(){
	var stat = $(this).validateFormEmpty();
	if(stat.success){
		$(this).asyncSubmit({
			'target': '#js-messages2',
			'loadTarget': '#loader',
			'loader': '<br><img src="<?php echo base_url()."images/loader.gif"; ?>">',
			'successMsg': 'Attendee added successfully!',
			'errorMsg': 'There was an error, please try again later!',
			'callback': 'new_attendee'
		});
	}else{
		$("#js-messages2").html("<span class='span6 alert alert-danger'>"+stat.errorMsg+"</span>").hide().fadeIn(500);
	}
	return false;
});


/**
	*	Manage Pages click function.
**/

$("#managePages").live("click", function(){
	var flag;
	$.getJSON("session", function(session){
		flag=session.adminLoggedin;
		if(flag==true){
			$("#ajaxer").html("<div class='loader'><img src='images/loader.gif'/></div>");
			$.getJSON("page/view", function(data){
				if(data.length > 0){
					var obj = [];
					c = 0;
					for(var i=0;i<data.length;i++){
						var pageType="";
						switch(data[i].pageType){
							case "1": pageType = "Normal Page";
												break;
											
							case "2": pageType = "Plenary";
												break;
											
							case "3": pageType = "Workshop";
												break;
											
							case "4": pageType = "Special Talks";
												break;
						}
						obj.push({
							"pageDbId": data[i].pageID,
							"pageID": ++c,
							"pageTitle": "<a href='#"+data[i].pageID+"' class='single_page' id='page_"+data[i].pageID+"'>"+data[i].pageTitle+"</a>",
							"pageType": pageType
						});
					}
						$("#ajaxer").html("<h2 id='title'>PAGES MANAGER</h2><table id='test'></table>");
						$("table#test").dataTable({
								"aaData": obj,
								"fnCreatedRow": function( nRow, aData, iDataIndex ) {
							        $(nRow).attr('id', "pageRow_"+aData.pageDbId);
							    },
								"sScrollX": "100%",
				 				"bScrollCollapse": true,
				 				"bScrollAutoCss": false,
				 				"iDisplayLength": 50,
				 				"aoColumns": [
				 												{
				 													"mDataProp": "pageID",
																	"sTitle": "Sl. No.",
																	"sClass": "title"
				 												},
				 												{
				 													"mDataProp": "pageTitle",
																	"sTitle": "Title",
																	"sClass": "title"
				 												},
				 												{
				 													"mDataProp": "pageType",
																	"sTitle": "Type",
																	"sClass": "pageType"
				 												}
				 				]
						});
				}
				else{
					$("#ajaxer").html("<h2 class='no-records'>\" No Pages exist! \"</h2>");
				}
			});
			return false
		}
		else{
			window.location = "admin";
			return true;
		}
	});
});


/**
	*	Single Page click function.
**/

$(".single_page").live("click", function(){
	var pageID = $(this).attr("href").substring(1);
	$("#pageData").html("<div class='loader'><img src='images/loader.gif' /></div>");
	$.getJSON("page/"+pageID, function(data){
		console.log(data)
		if(data[0].images.length > 0){
			var page_img = data[0].images[0].image;
			var del_page = "<a href='"+base_url+"/image/delete/"+data[0].images[0].imageID+"' id='delete_page_image'>Delete Image</a>"
		}
		else{
			var page_img = "";
			var del_page = "";
		}
		if(data[0].pageType == 3){
			var seats = "<div><input type='hidden' id='seats_taken_count' value='"+data[0].seats_taken+"'/>Seats Taken: <span id='seats_taken_dynamic'>"+data[0].seats_taken+"</span> / <input type='text' id='page_seats_edit' value='"+data[0].seats+"'/></div>"
			var attendees_list = "";
			for(var a in data[0].attendees){
				attendees_list += "<div id='workshop_attendee_"+data[0].attendees[a].attendeeID+"'>"+data[0].attendees[a].attendeeFirstName+" "+data[0].attendees[a].attendeeLastName+" - "+data[0].attendees[a].attendeeEmail+" <a href='#' class='delete_attendee_workshop' id='delete_attendee_workshop_"+data[0].attendees[a].attendeeID+"' data-attendee='"+data[0].attendees[a].attendeeID+"'>Unassign</a></div>"
			}
			if(attendees_list == "")
				var attendees_workshop = "No Attendees are registered for this workshop yet.";
			else
				var attendees_workshop = "<div id='workshop_attendees' class='workshop_attendees'>"+attendees_list+"</div>";
			var attended_by_label = "<p><h2>Attended By: </h2>"+attendees_workshop+"</p>";
		}
		else{
			var seats = "";
			var attendees_workshop = "";
			var attended_by_label = "";
		}
		$("#pageModalLabel").html("<h2>"+data[0].pageTitle+"</h2>");
		$("#pageData").html("<div><label>Title: </label> <input id='page_title_edit' value='"+data[0].pageTitle+"'/><input id='page_id' type='hidden' value='"+data[0].pageID+"'/><input id='page_type' type='hidden' value='"+data[0].pageType+"'/></div> Content: <div id='pageContent' class='pageContent' contenteditable='true'>"+data[0].pageContent+"</div> Extra Info: <div id='pageSubHeading' class='pageContent' contenteditable='true'>"+data[0].pageSubHeading+"</div>"+seats+" <form action='image/create' method='POST' id='page_image_form'><input type='hidden' id='inputPageID' name='inputPageID' value='"+data[0].pageID+"'/><input type='hidden' name='"+token[0]+"' value='"+token[1]+"'/>Upload Image: <input type='file' id='inputPageImage' name='inputPageImage'/></form> "+del_page+" <p>Uploaded Image: <img src='"+page_img+"' id='cur_img' alt='None'/></p>"+attended_by_label);
		$("#pageModal").modal({
			keyboard: true,
			backdrop: 'static',

			show: true
		});
		var wysiwyg = new Wysiwyg;
		wysiwyg.el.insertBefore('#pageContent');
	});
	return false;
})


/**
	*	Save Page button click function.
**/

$("button#save_page").live("click", function(){
	var title = $("#page_title_edit").val();
	var content = $("#pageContent").html();
	var pageID = $("#page_id").val();
	var pageType = $("#page_type").val();
	var seats = $("#page_seats_edit").val();
	var seats_taken_count = $("#seats_taken_count").val();
	var pageSubHeading = $("#pageSubHeading").html()
	console.log(content)
	$.post(
		"page/update", 
		{
			"inputPageTitle": title,
			"inputPageContent": content,
			"inputPageSubHeading": pageSubHeading,
			"inputPageID": pageID, 
			"inputPageType": pageType,
			"inputSeats": seats,
			"inputSeatsTaken": seats_taken_count
		},
	function(data){
		edit_page_changes($.parseJSON(data));
	});
});


/**
	*	Delet Page click function.
**/

$("button#delete_page").live("click", function(){
	var pageID = $("#page_id").val();
	$.post(
		"page/delete",
		{
			"inputPageID": pageID
		},
		function(data){
			var obj = $.parseJSON(data)
			if(obj.success){
				$("#pageModal").modal("toggle");
				$("#page_"+pageID).parent().parent().fadeOut(500);
			}
		}
	);
	return false;	
});


/**
	*	Create Page click function.
**/

$("#createPage").live("click", function(){
	$("#createPageModal").modal({
		keyboard: true,
		backdrop: 'static',
		show: true
	});
	return false;
});


/**
	*	Create Page form submit function.
**/

$("form#new_page").live("submit", function(){
	var title = $("#inputPageTitle").val();
	var content = $("#inputPageContent").html();
	var subheading = $("#inputPageSubHeading").html();
	var type = $("select[name='inputPageType']").val();
	console.log(title+" & "+content+" & "+type)
	$.post("page/create",
	{
		"inputPageTitle": title,
		"inputPageContent": content,
		"inputPageSubHeading": subheading,
		"inputPageType": type
	},
	function(data){
		var obj = $.parseJSON(data);
		if(obj.success){
			new_page_change(obj);
			$("#js-messages3").html("<span class='alert alert-success'>Page added!</span>");
			$("form#new_page")[0].reset();
			$("#inputPageContent").html('');
			$("#inputPageSubHeading").html('');
		}
	});
	return false;
});


/**
	* Approve Abstract.
**/

$("#abstract_approve_btn").live("click", function(){
	var abstractID = $("#abstractID").val();
	var recommendation_admin = $.trim($('[name=recommendation_admin]:checked').val());
	console.log(recommendation_admin);
	//console.log(abstractID);
	$.post("abstract/approve",
	{
		"abstractID": abstractID,
		"recommendation_admin": recommendation_admin
	},
	function(data){
		console.log(data);
	}
	);
});


/**
	* Manage this conference click function.
**/

$("#manageCurConf").live("click", function(){
	$("#ajaxer").html("<a href='#' id='publish_abstracts'>Publish Abstracts</a> &nbsp; \
										 <a href='#' id='email_sel_att'>Email selected Attendees</a> &nbsp; \
										 <a href='#' id='email_rej_att'>Email rejected Attendees</a> &nbsp;\
										 <a href='#' id='email_all_att'>Email alerts to Attendees</a> &nbsp; \
										 <a href='#' id='set_timer_link'>Set Timers</a>");
	return false;
});


/**
	*	Publish Abstracts Modal.
**/

$("#publish_abstracts").live("click", function(){
	$("#publishAbstractsModal").modal({
		keyboard: true,
		backdrop: 'static',
		show: true
	});
	return false;
});


/**
	*	Publish Abstracts Button.
**/

$("#publish_abstracts_btn").live("click", function(){
	$.get("abstract/publish",
		function(data){
			console.log(data)
		}
	);
	return false;
});


/**
	*	Send Email to selected Attendees Modal.
**/

$("#email_sel_att").live("click", function(){
	$("#emailSelAttModal").modal({
		keyboard: true,
		backdrop: 'static',
		show: true
	});
	return false;
});


/**
	*	Send Email to selected Attendees click function.
**/

$("#send_sel_att_btn").live("click", function(){
	$.post(base_url+"abstract/alert_selected_attendees",
		{
			inputEmailSubject: $.trim($("#inputEmailSubject").val()),
			inputEmailMessage: $.trim($("#inputEmailMessage").val())
		},
		function(data){
			var obj = $.parseJSON(data);
			console.log(obj);
			if(obj.success){
				$("#inputEmailSubject").val('');
				$("#inputEmailMessage").val('');
			}
			else{
				
			}
		}
	);
	return false;
});


/**
	*	Send Email to rejected Attendees Modal.
**/

$("#email_rej_att").live("click", function(){
	$("#emailRejAttModal").modal({
		keyboard: true,
		backdrop: 'static',
		show: true
	});
	return false;
});


/**
	*	Send Email to selected Attendees click function.
**/

$("#send_rej_att_btn").live("click", function(){
	$.post("abstract/alert_rejected_attendees",
		{
			inputEmailSubject: $.trim($("#inputEmailRejSubject").val()),
			inputEmailMessage: $.trim($("#inputEmailRejMessage").val())
		},
		function(data){
			var obj = $.parseJSON(data);
			console.log(obj);
			if(obj.success){
				$("#inputEmailRejSubject").val('');
				$("#inputEmailRejMessage").val('');
			}
			else{
				
			}
		}
	);
	return false;
});


/**
	*	Send Email to All Attendees Modal.
**/

$("#email_all_att").live("click", function(){
	$("#emailAllModal").modal({
		keyboard: true,
		backdrop: 'static',
		show: true
	});
	return false;
});


/**
	*	Send Email alerts to all Attendees click function.
**/

$("#send_all_att_btn").live("click", function(){
	$.post("attendee/alert_all_attendees",
		{
			inputEmailSubject: $.trim($("#inputEmailAllSubject").val()),
			inputEmailMessage: $.trim($("#inputEmailAllMessage").val())
		},
		function(data){
			var obj = $.parseJSON(data);
			console.log(obj);
			/*if(obj.success){
				$("#inputEmailAllSubject").val('');
				$("#inputEmailAllMessage").val('');
			}
			else{
				
			}*/
		}
	);
	return false;
});


/**
	*	Upload page image on change function.
**/
$("#inputPageImage").live("change", function(e){
	e.preventDefault();
	$("#page_image_form").after("<p id='image_upload_msg'>Please wait, your image is being uploaded...</p>")
	$("form#page_image_form").ajaxSubmit(function(data){
		console.log(data);
		var obj = $.parseJSON(data);
		if(obj.success){
			$("#image_upload_msg").html("Image uploaded!");
			$("#cur_img").attr("src", obj.image);
		}
		else{
			
		}
	});
});


/**
	*	Update comment button click function.
**/

$(".update_comments_btn").live("click", function(){
	var comment1_id = $(this).attr("data-comment1");
	var comment2_id = $(this).attr("data-comment2");
	$.post("comment/comment_update",
		{
			comment1_id: comment1_id,
			comment2_id: comment2_id,
			comment1_content: $("#comment_reviewer_"+comment1_id).val(),
			comment2_content: $("#comment_admin_"+comment2_id).val()
		},
		function(data){
			console.log(data);
		}
	);
});


/**
	*	Unassign an attendee from a workshop.
**/

$(".delete_attendee_workshop").live("click", function(){
	var page_id = $("#inputPageID").val();
	var attendee_id = $(this).attr("data-attendee");
	$("#delete_attendee_workshop_"+attendee_id).html("&nbsp;<span class='loader'><img src='images/loader.gif'/></span>")
	$.post(base_url+"page_attendee/delete",
		{
			inputPageID: page_id,
			inputAttendeeID: attendee_id
		},
		function(data){
			var obj = $.parseJSON(data);
			if(obj.success){
				$("#workshop_attendee_"+attendee_id).fadeOut(300);
				$("#seats_taken_dynamic").html(obj.seats_taken);
			}
		}
	);
	return false;
});


/**
	*	Set Timer link click function.
**/

$("#set_timer_link").live("click", function(){
	$.getJSON(base_url+"conference/"+$("#current_conf").val(), function(data){
		if(data[0].timer != null || data[0].timer != ""){
			var obj = $.parseJSON(data[0].timer);
			$("#inputTimer1").val(obj.timerTitle1);
			$("#inputTimer2").val(obj.timerTitle2);
			$("#inputTimer3").val(obj.timerTitle3);
			$("#inputTimer4").val(obj.timerTitle4);
			$("#inputTimerDate1").val(obj.timerDate1);
			$("#inputTimerDate2").val(obj.timerDate2);
			$("#inputTimerDate3").val(obj.timerDate3);
			$("#inputTimerDate4").val(obj.timerDate4);
		}
		$("#setTimerModal").modal({
			keyboard: true,
			backdrop: 'static',
			show: true
		});
	});
	return false;
});


/**
	*	Set Timer button click function.
**/

$("form#set_timer_form").submit(function(){
	$.ajax({
		url: base_url+"conference/set_timer",
		type: "POST",
		data: $(this).serialize(),
		success: function(data){
			console.log(data);
		},
		error: function(data){
			console.log(data)
		}
	});
	return false;
});


/**
	*	Delete Reviewer click function.
**/

$("#reviewer_delete_submit").live("click", function(){
	var reviewer = $("#inputReviewerID").val();
	$.post(base_url+"reviewer/delete",
		{ inputReviewerID: reviewer },
		function(data){
			var obj = $.parseJSON(data);
			if(obj.success){
				$("#reviewersModal").modal('hide');
				$("#reviewer_row_"+reviewer).parent().parent().fadeOut(300);
				$("#total_reviewers_count").html(obj.total_reviewers);
			}
		}
	);
	return false;
});


/**
	*	Delete image click function.
**/

$("#delete_page_image").live("click", function(){
	$.get($(this).attr("href"), function(data){
		var obj = $.parseJSON(data);
		if(obj.success){
			$("#cur_img").fadeOut(300);
			$("#delete_page_image").hide();
		}
	});
	return false;
});


/**
  *	Handles on change after new attendee has been created.
 */

function new_attendee_change(obj){
	$("#addAttendeeModal").modal("hide");
	var attendee = obj.attendee;
	$("table#test tbody").prepend("<tr class='even'>"+
		"<td class='sorting_1'><a href='#"+attendee[0].attendeeID+"' class='attendee_id'>"+attendee[0].attendeeFirstName+" "+attendee[0].attendeeLastName+"</a></td>"+
		"<td>"+attendee[0].attendeeEmail+"</td>"+
		"<td>"+attendee[0].attendeeInstAffiliation+"</td>"+
		"<td>"+attendee[0].attendeeAddress+"</td>"+
		"<td>"+attendee[0].attendeePhone+"</td>"+
		"<td>NO</td>"+
		"</tr>").hide().fadeIn(500);
}

/**
  *	Handles on change after attendee has been updated.
 */

 function edit_attendee_change(obj){
 	if(obj.submitted == 0){
 		var reg = "NO";
 	}
 	else{
 		var reg = "YES";
 	}
 	$("#attendeeModal").modal("hide");
 	$("tr#attendeeRow_"+obj.attendee.inputAttendeeID).html(
		"<td class='sorting_1'><a href='#"+obj.attendee.inputAttendeeID+"' class='attendee_id'>"+obj.attendee.inputFirstName+" "+obj.attendee.inputLastName+"</a></td>"+
		"<td>"+obj.attendee.inputEmail+"</td>"+
		"<td>"+obj.attendee.inputInstAffiliation+"</td>"+
		"<td>"+obj.attendee.inputAddress+"</td>"+
		"<td>"+obj.attendee.inputPhone+"</td>"+
		"<td>"+reg+"</td>"
 	).hide().fadeIn(500);
 }


 /**
   *	New Reviewer Change function.
  */

function new_reviewer_change(obj){
	var reviewer = obj.reviewer;
	var total_reviewers_count = parseInt($("#total_reviewers_count").html());
	total_reviewers_count += 1;
	$("#addReviewerModal").modal('hide');
	$("#total_reviewers_count").html(total_reviewers_count);
	$("table#test tbody").prepend("<tr class='even'>"+
		"<td class='sorting_1'><a href='#"+reviewer[0].reviewerID+"' class='reviewer_id' id='reviewer_row_"+reviewer[0].reviewerID+"'>"+reviewer[0].reviewerFirstName+" "+reviewer[0].reviewerLastName+"</a></td>"+
		"<td>"+reviewer[0].reviewerEmail+"</td>"+
		"<td>0</td>"+
		"</tr>").hide().fadeIn(500);
}

/**
	*	Edit Reviewer changes.
 */

 function edit_reviewer_change(obj){
 	var abs = $("#reviewerRow_"+obj.reviewer.inputReviewerID).find("td")[2].innerHTML;
 	$("#reviewersModal").modal('hide');
 	$("tr#reviewerRow_"+obj.reviewer.inputReviewerID).html(
 		"<td class='sorting_1'><a href='#"+obj.reviewer.inputReviewerID+"' class='reviewer_id' id='reviewer_row_"+obj.reviewer.inputReviewerID+"'>"+obj.reviewer.inputFirstName+" "+obj.reviewer.inputLastName+"</a></td>"+
		"<td>"+obj.reviewer.inputEmail+"</td>"+
		"<td>"+abs+"</td>"
 	).hide().fadeIn(500);
}


/**
	*	New Page Changes function.
*/

function new_page_change(obj){
	console.log(obj);
	var tds = $("table#test tr td");
	var trs = $("table#test tr");
	var i,j;
	for(i=1;i<trs.length;i++){
		var p_id = $(trs[i]).attr("id");
		var c = parseInt($(trs[i]).find("td")[0].innerHTML)+1;
		var ch = $("#"+p_id).find("td")[0];
		$(ch).html(c);
	}
	var pageType="";
						switch(obj.page.inputPageType){
							case "1": pageType = "Normal Page";
												break;
											
							case "2": pageType = "Plenary";
												break;
											
							case "3": pageType = "Workshop";
												break;
											
							case "4": pageType = "Special Talks";
												break;
						}
	$("#createPageModal").modal('hide');
	$("table#test").prepend(
		"<tr id='"+obj.pageID+"'> class='even'"+
			"<td class='title sorting_1'>1</td>"+
			"<td class='title'><a href='#"+obj.pageID+"' class='single_page' id='page_"+obj.pageID+"'>"+obj.page.inputPageTitle+"</a></td>"+
			"<td class='pageType'>"+pageType+"</td>"+
		"</tr>"
	).hide().fadeIn(500);
}


/**
	*	Edit Page changes.
**/

function edit_page_changes(obj){
	console.log(obj)
	var pageType="";
						switch(obj.page.inputPageType){
							case "1": pageType = "Normal Page";
												break;
											
							case "2": pageType = "Plenary";
												break;
											
							case "3": pageType = "Workshop";
												break;
											
							case "4": pageType = "Special Talks";
												break;
						}
	$("#pageModal").modal('hide');
	$("tr#pageRow_"+obj.page.inputPageID).html(
		"<td class='title sorting_1'>1</td>"+
		"<td class='title'><a href='#"+obj.page.inputPageID+"' class='single_page' id='page_"+obj.page.inputPageID+"'>"+obj.page.inputPageTitle+"</a></td>"+
		"<td class='pageType'>"+pageType+"</td>"
	).hide().fadeIn(500);
}