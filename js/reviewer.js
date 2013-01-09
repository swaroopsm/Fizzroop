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
