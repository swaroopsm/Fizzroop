/**
	* Check if Reviewer Logged in.
**/

$.getJSON("session", function(data){
	if(data.reviewerLoggedin){
		/**
			* Load assigned Abstracts of the loggedin reviewers' 
		**/
		console.log(data)
		$.getJSON("reviewer/reviewer_abstracts/"+data.id,
		function(abstract){
			console.log(abstract)
		});
	}
});
