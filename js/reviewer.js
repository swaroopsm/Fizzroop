var page = $("body").attr("data-page");

if(page == "reviewerDashboard"){
	/**
		* Check if Reviewer Logged in.
	**/

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
				console.log(data);
				$("#abstractModalLabel").html(data[0].abstractTitle);
				$("#hidden_abstractID").val(data[0].abstractID);
				$("#abstractContent").html('');
				var score="", recommendation="", comments="";
				if(data[0].comments){
					if(data[0].comments.length>0){
						for(var i=0;i<data[0].comments.length;i++){
							if(data[0].comments[i].commentType == 1){
								comments = comments+"<p>Comment to Reviewer: <textarea id='comment_reviewer'>"+data[0].comments[i].commentContent+"</textarea></p>"
							}
							if(data[0].comments[i].commentType == 2){
								comments = comments+"<p>Comment to Admin: <textarea id='comment_admin'>"+data[0].comments[i].commentContent+"</textarea></p>"
							}
						}
					}
					else{
						comments = comments+"<p>Comment to Reviewer: <textarea id='comment_reviewer'></textarea></p>"
						comments = comments+"<p>Comment to Admin: <textarea id='comment_admin'></textarea></p>"
					}
				}
				if(data[0].scores){
					if(data[0].scores.length>0){
						for(var j=0;j<data[0].scores.length;j++){
							if(score==null){
								var score_obj = $.parseJSON(data[0].scores[j].score);
								score = score+"<p>Conservation Score: <input type='text' id='conservation_score' value='"+score_obj.conservation+"' /></p><p>Science Score: <input type='text' id='science_score' value='"+score_obj.science+"' /></p>"
							}
							else{
								var score_obj="";
								score = score+"<p>Conservation Score: <input type='text' id='conservation_score' value='' /></p><p>Science Score: <input type='text' id='science_score' value='' /></p>"
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
														
									default: recommendation = "<input type='radio' name='recommendation' id='recommendation' value='1' />Talk <input type='radio' name='recommendation' id='recommendation' value='2'/>Poster <input type='radio' name='recommendation' id='recommendation' value='3' Reject/>";
								}
							}
							else{
								recommendation = "<input type='radio' name='recommendation' id='recommendation' value='1' />Talk <input type='radio' name='recommendation' id='recommendation' value='2'/>Poster <input type='radio' name='recommendation' id='recommendation' value='3' Reject/>";
							}
						}
					}
					else{
						score = score+"<p>Conservation Score: <input type='text' id='conservation_score' value='' /></p><p>Science Score: <input type='text' id='science_score' value='' /></p>";
						recommendation = "<input type='radio' name='recommendation' id='recommendation' value='1' />Talk <input type='radio' name='recommendation' id='recommendation' value='2'/>Poster <input type='radio' name='recommendation' id='recommendation' value='3' Reject/>";
					}
				}
				else{
					score = score+"<p>Conservation Score: <input type='text' id='conservation_score' value='' /></p><p>Science Score: <input type='text' id='science_score' value='' /></p>"
				}
				$("#abstractContent").append(
					"Content: "+data[0].abstractContent+
					comments+
					score+
					recommendation
				);
				$("#myModal").modal({
					keyboard: true,
					backdrop: 'static',
					show: true
				});
			});
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
