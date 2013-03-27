$(document).ready(function() {
	// Stuff to do as soon as the DOM is ready;
	
	var i=0;

});


$(window).load(function() {
	// Once images are loaded
	
	var slidewidth = $('.slide').width();
	var slidewidth1 = slidewidth * -1;
	var slidewidth2 = slidewidth1 *2;

	var slidetiming = 5000;
	var slidetiming2 = 2500;

	var i = 0;
	
	var slideanimate = function(){
		$(".galwrap1").animate({"marginLeft": slidewidth1 }).delay(slidetiming).animate({"marginLeft": slidewidth2 }).delay(slidetiming).animate({"marginLeft": 0 }).delay(slidetiming);
	};


	var workslidewidth = $('.workslide').width();
	var workslidewidth1 = workslidewidth * -1;
	var workslidewidth2 = workslidewidth1 *2;


	var slideanimate2 = function(){
		$(".galwrap2").delay(slidetiming2).animate({"marginLeft": workslidewidth1 }).delay(slidetiming).animate({"marginLeft": workslidewidth2 }).delay(slidetiming).animate({"marginLeft": 0 }).delay(slidetiming2);
	};

	for (var j=0; j < 1000; j++) {
		slideanimate();
		slideanimate2();
	}
});