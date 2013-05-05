/**
	* Validate form for emptyness
*/

jQuery.fn.validateFormEmpty = function(){
	
	var inputsTextList = $(this).find("input[type=text], input[type=password], textarea, select, input[type=file]");
	var inputsLabelList = $(this).find("label");
	console.log(inputsLabelList);
	console.log(inputsTextList);
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

// read image for previews
function readURL(input) {
if (input.files && input.files[0]) {
	var reader = new FileReader();

	reader.onload = function (e) {
		$('#img_prev')
		.attr('src', e.target.result)
		//.width(150)
		//.height(200)
		;
	};

	reader.readAsDataURL(input.files[0]);
	}
}

// Setup links for loading into modals and divs.

// Load abstract form
$("a.absubmit").click(function(){
	// clear the holding div first
	$('.attcontainer').css({display: 'block'});
	$('.submitabstractform').css({display:'block'});
	$('.message').css({display: 'none'});
	$('.guidelines').css({display: 'none'});
	$('.workshop').css({display: 'none'});
	$('.account').css({display: 'none'});
	return false;
});

$("a.absguide").click(function(){
	// clear the holding div first
	$('.guidelines').css({display:'block'});
	$('.message').css({display: 'none'});
	$('.attcontainer').css({display: 'none'});
	$('.submitabstractform').css({display:'none'});
	$('.workshop').css({display: 'none'});
	$('.account').css({display: 'none'});
	return false;
});


$("form#new_abstract").live("submit", function(e){
	e.preventDefault();
	$('body').css({"cursor":"progress"});
	$('#loaderspace').css({"display":"block"}).animate({"opacity":0.8}, 1000);
	var stat = $(this).validateFormEmpty();
	// if(stat.success){
		$(this).ajaxSubmit(function(data){
		var success = $.parseJSON(data);
		console.log(success);
		// if(success.success == true) {
		// 	console.log(success.success);
		// } else {
		// 	console.log('fail');
		// }
		// reload the page
		window.location="attendee";
	});
	// }
	return false;
});

$("a.abview").click(function(){
	$.getJSON("abstract/"+absid, function(data){
		console.log(data);
		var bursary = data[0].bursary;
		bursary = $.parseJSON(bursary);
		console.log(bursary);
		var messagediv = $('.message');
		messagediv.html('');
		messagediv.append("<h2>"+data[0].abstractTitle+"</h2><a id='absdown' href='"+base_url+"abstract/pdf/"+data[0].abstractID+"'>download abstract as pdf</a><p class='name'>"+data[0].abstractAuthors+"</p><br><img src='"+data[0].abstractImageFolder+"'>");
		var abscontent = data[0].abstractContent;
		abscontent = $.parseJSON(abscontent);
		messagediv.append("<br><br><strong>What conservation problem or question does your talk/poster address?</strong><p>"+abscontent.aim+"</p>");
		messagediv.append("<br><br><strong>What were the main research methods you used?</strong><p>"+abscontent.methods+"</p>");
		messagediv.append("<br><br><strong>What are your most important results?</strong><p>"+abscontent.results+"</p>");
		messagediv.append("<br><br><strong>What is the relevance of your results to conservation?</strong><p>"+abscontent.conservation+"</p><br><br><br><hr>");
		if (bursary.bursary_for == "No") {
			messagediv.append("You have not applied for a bursary.");
		} else {
			messagediv.append("Bursary applied for : "+bursary.bursary_for);
			messagediv.append("Bursary applied for : "+bursary.bursary_why);
		};
		messagediv.append("<br>Accomodation applied for : "+bursary.accomodation);
		
	});
	$('.guidelines').css({display:'none'});
	$('.workshop').css({display: 'none'});
	$('.attcontainer').css({display: 'block'});
	$('.message').css({display: 'block'});
	$('.account').css({display: 'none'});
});


$("a.workshops").click(function(){
	$('.submitabstractform').css({display:'none'});
	$('.message').css({display: 'none'});
	$('.guidelines').css({display: 'none'});
	$('.attcontainer').css({display: 'none'});
	$('.workshop').css({display: 'block'});
	$('.account').css({display: 'none'});

	// $.getJSON("page/view_page_type/3", function(data) {
	// 	console.log(data);
	// 	var wdiv = $('.workshop');
	// 	wdiv.html('');
	// 	wdiv.append("<h2>Workshops</h2>");
	// 	for(i=0;i<data.length;i++){
	// 		wdiv.append("<div class='attsinglewshop'><h3>"+data[i].pageTitle+"</h3>");
	// 		wdiv.append("<p>Seats Taken: "+data[i].seats_taken+" Total Seats: "+data[i].seats+"</p>");
	// 		wdiv.append("<p>"+data[i].pageContent+"</p><div class='workshopactions'>I want to attend. I don't want to attend</div>");
	// 		wdiv.append("</div>")
	// 	}
		
	// });

	var wdiv = $('.workshop');
	wdiv.html('');
	wdiv.append("<h2>Workshops</h2><p>Workshop registrations will open in August. Please check the website for updates</p>");

});


$("a.my_account").click(function(){
	$('.submitabstractform').css({display:'none'});
	$('.message').css({display: 'none'});
	$('.guidelines').css({display: 'none'});
	$('.attcontainer').css({display: 'none'});
	$('.workshop').css({display: 'none'});
	$(".account").css({display: 'block'});
});

/**
	*	Bursary Submission.
**/

$("#submit_bursary").click(function(){
	if($("#inputAbstractID").val() == ""){
		console.log("No abstract submitted!");
	}
	else{
		$.post(base_url+"abstract/add_bursary",
		{
			inputAbstractID: $("#inputAbstractID").val(),
			inputBursary_For: $("#bursary_for").val(),
			inputBursary_Why: $("#bursary_why").val()
		},
		function(data){
			console.log(data);
		});
	}
	return false;
})


/**
	*	Bursaries radio button click function.
// **/

// $("input#bursary_yes").live("click", function(){
// 	var id = $(this).val();
// 	$(this).attr("checked", true)
// 	if(id == "1"){
// 		$("#inputBursary_For").val("");
// 		$("#inputBursary_Why").val("");
// 		$("#bursary_no").removeAttr("checked");
// 		$("#bursaries").show();
// 	}
// 	else{
// 		$("#inputBursary_For").val("nil");
// 		$("#inputBursary_Why").val("nil");
// 		$("#bursary_yes").removeAttr("checked");
// 		$("#bursaries").hide();
// 	}
// 	return false;
// });


/**
	*	Attended reset form submit function
**/

$("#attendee_reset").live("submit", function(){
	if($.trim($("#inputNewPassword").val()) != $.trim($("#inputConfNewPwd").val())){
		console.log("Confirm your passwords");
	}
	else{
		$.post($(this).attr("action"),
		{
			inputAttendeeID: $("#hidden_attendeeID").val(),
			inputConfPassword: $("#inputConfPassword").val(),
			inputNewPassword: $("#inputNewPassword").val()
		},
		function(data){
			var obj = $.parseJSON(data);
			console.log(obj);
			if(obj.success){
				$("#attendee_reset")[0].reset();
			}
		});
	}
	return false;
});

$("input#bursary_yes").click(function(){
	$("#bursaries_options").html('<div class="burwhy"><p>If yes, please us the space below to provide a justification for why you should receive a bursary (max 400 characters)</p><textarea id="inputBursary_Why" name="inputBursary_Why" placeholder="Tell us why you think you need a bursary." "data-maxlength"="400" "data-required"="true"></textarea></div>').delay(50, function(){
		console.log("binding parsley");
		$('#new_abstract').parsley('addItem', '#inputBursary_Why');
	});
});

$("input#bursary_no").click(function(){
	$("#bursaries_options").html('');
});
