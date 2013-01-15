var page = $("body").attr("data-page");

if(page == "reviewerDashboard"){
	/**
		* Check if Reviewer Logged in.
	**/
$("#ajaxer").html("<div class='loader'><img src='images/loader.gif' /></div>");
$.getJSON("session", function(data){
	if(data.reviewerLoggedin){
		/**
			* Load assigned Abstracts of the loggedin reviewers' 
		**/
		var obj = [];
		$.getJSON("reviewer/reviewer_abstracts/"+data.id,
		function(abstract){
			var score, recommendation, recommended = "-";
			for(var i=0;i<abstract.length;i++){
				if(abstract[i].score == null){
					score = "-";
				}
				else{
					score = abstract[i].score;
				}
				recommendation = abstract[i].recommendation;
				switch(recommendation){
					case "1": recommended = "<img src='images/talk.png'>";
										break;
										
					case "2": recommended = "<img src='images/poster.png'>";
										break;
										
					case "3": recommended = "<img src='images/reject.gif'>";
										break;
					
					default: recommended = "-";
				}
				obj.push({
					"title": "<a href='#"+abstract[i].abstractID+"' class='abstract_title'>"+abstract[i].abstractTitle+"</a>",
					"score": score,
					"recommendation": recommended
				});
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
											"mDataProp": "score",
											"sTitle": "Score",
											"sClass": "score"
										},
										{
											"mDataProp": "recommendation",
											"sTitle": "Recommendation",
											"sClass": "recommendation"
										}
					]
			});
		});
		
		/**
			*	Abstract Title click function.
		**/
		
		$(".abstract_title").live("click", function(){
			var abstractID = $(this).attr("href").substring(1);
			$.getJSON("reviewer/abstract/assigned/"+abstractID, function(data){
				console.log(data)
				$("#abstractModalLabel").html(data[0].abstractTitle);
				$("#hidden_abstractID").val(data[0].abstractID);
				$("#abstractContent").html('');
				var score="", recommendation="", comments="";
				if(data[0].comments){
					if(data[0].comments.length>0){
						for(var i=0;i<data[0].comments.length;i++){
							if(data[0].comments[i].commentType == 1){
								comments = comments+"<p>Comment to Reviewer: <textarea id='comment_reviewer'>"+data[0].comments[i].commentContent+"</textarea><input type='hidden' id='hidden_reviewer_commentID' value='"+data[0].comments[i].commentID+"'/></p>"
							}
							if(data[0].comments[i].commentType == 2){
								comments = comments+"<p>Comment to Admin: <textarea id='comment_admin' data-commentID='"+data[0].comments[i].commentID+"'>"+data[0].comments[i].commentContent+"</textarea><input type='hidden' id='hidden_admin_commentID' value='"+data[0].comments[i].commentID+"'/></p>"
							}
						}
					}
					else{
						comments = comments+"<p>Comment to Reviewer: <textarea id='comment_reviewer'></textarea><input type='hidden' id='hidden_reviewer_commentID' value=''/></p>"
						comments = comments+"<p>Comment to Admin: <textarea id='comment_admin'></textarea><input type='hidden' id='hidden_reviewer_commentID' value=''/></p>"
					}
				}
				if(data[0].scores){
					if(data[0].scores.length>0){
						for(var j=0;j<data[0].scores.length;j++){
							if(data[0].scores[j].score==null){
								var score_obj="";
								score = score+"<input type='hidden' id='score_id' value=''/><p>Conservation Score: <input type='text' id='conservation_score' value='0' /></p><p>Science Score: <input type='text' id='science_score' value='0' /></p>"
							}
							else{
								var score_obj = $.parseJSON(data[0].scores[j].score);
								score = score+"<input type='hidden' id='score_id' value='"+data[0].scores[j].scoreID+"'/><p>Conservation Score: <input type='text' id='conservation_score' value='"+score_obj.conservation+"' /></p><p>Science Score: <input type='text' id='science_score' value='"+score_obj.science+"' /></p>"
							}
							if(data[0].scores[j].recommendation){
								var rec = data[0].scores[j].recommendation;
								switch(rec){
									case '1': recommendation = "<input type='radio' name='recommendation' id='recommendation' value='1' checked='checked'/>Talk <input type='radio' name='recommendation' id='recommendation' value='2'/>Poster <input type='radio' name='recommendation' id='recommendation' value='3'/>Reject";
														break;
														
									case '2': recommendation = "<input type='radio' name='recommendation' id='recommendation' value='1'/>Talk <input type='radio' name='recommendation' id='recommendation' value='2' checked='checked'/>Poster <input type='radio' name='recommendation' id='recommendation' value='3'/>Reject";
														break;
														
									case '3': recommendation = "<input type='radio' name='recommendation' id='recommendation' value='1'/>Talk <input type='radio' name='recommendation' id='recommendation' value='2'/>Poster <input type='radio' name='recommendation' id='recommendation' value='3' checked='checked'/>Reject";
														break;
														
									default: recommendation = "<input type='radio' name='recommendation' id='recommendation' value='1' />Talk <input type='radio' name='recommendation' id='recommendation' value='2'/>Poster <input type='radio' name='recommendation' id='recommendation' value='3'/>Reject";
								}
							}
							else{
								recommendation = "<input type='radio' name='recommendation' id='recommendation' value='1' />Talk <input type='radio' name='recommendation' id='recommendation' value='2'/>Poster <input type='radio' name='recommendation' id='recommendation' value='3'/>Reject";
							}
						}
					}
					else{
						score = score+"<input type='hidden' id='score_id' value=''/><p>Conservation Score: <input type='text' id='conservation_score' value='0' /></p><p>Science Score: <input type='text' id='science_score' value='0' /></p>";
						recommendation = "<input type='radio' name='recommendation' id='recommendation' value='1' />Talk <input type='radio' name='recommendation' id='recommendation' value='2'/>Poster <input type='radio' name='recommendation' id='recommendation' value='3'/>Reject";
					}
				}
				else{
					score = score+"<p>Conservation Score: <input type='text' id='conservation_score' value='' /></p><p>Science Score: <input type='text' id='science_score' value='' /></p>"
				}
				$("#abstractContent").append(
					"Content: "+data[0].abstractContent+
					comments+
					score+
					recommendation+
					"<img src='"+data[0].abstractImageFolder+"' />"
				);
				$("#myModal").modal({
					keyboard: true,
					backdrop: 'static',
					show: true
				});
			});
		});
		
		
		/**
			*	reviewer_abstract_submit click function.
		**/
		
	$("#reviewer_abstract_submit").live("click", function(){
		var abstract_id = $.trim($("#hidden_abstractID").val());
		var reviewer_id = $.trim($("#hidden_reviewerID").val());
		var comment_reviewer = $.trim($("#comment_reviewer").val());
		var comment_admin = $.trim($("#comment_admin").val());
		var comment_reviewer_id = $.trim($("#hidden_reviewer_commentID").val());
		var comment_admin_id = $.trim($("#hidden_admin_commentID").val());
		var conservation_score = $.trim($("#conservation_score").val());
		var science_score = $.trim($("#science_score").val());
		var score = "{\"conservation\": "+conservation_score+", \"science\": "+science_score+"}";
		var recommendation = $.trim($('[name=recommendation]:checked').val());
		var scoreID = $.trim($("#score_id").val());
		console.log(scoreID)
		$.post(
			"reviewer/reviewer_abstract_submit",
			{
				"abstractID": abstract_id,
				"reviewerID": reviewer_id,
				"comment_reviewer": comment_reviewer,
				"comment_admin": comment_admin,
				"comment_reviewer_id": comment_reviewer_id,
				"comment_admin_id": comment_admin_id,
				"score": score,
				"recommendation": recommendation,
				"scoreID": scoreID
			},
			function(data){
				$("#myModal").modal('toggle');
			}
		);
		return false;
	});
		
	}
});
}

if(page == "reviewerAbstract"){
	var abstractID = document.URL.split("/")[6];
	if(abstractID.substring(abstractID.length-1) == "#"){
		abstractID = abstractID.substring(0, abstractID.length-1);
	}
	$.getJSON("assigned/"+abstractID, function(data){
		//@TODO Display the json data appropriately in the view.
		console.log(data)
	});	
}
