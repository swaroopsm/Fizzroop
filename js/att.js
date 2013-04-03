// Setup links for loading into modals and divs.

// Load abstract form
$("a.absubmit").click(function(){
	// clear the holding div first
	$('.submitabstractform').css({display:'block'});
	$('.message').css({display: 'none'});
	return false;
});