jQuery(function( $ ){

	$(".nav-header").addClass("responsive-menu").before('<div id="responsive-menu-icon"></div>');
	
	$("#responsive-menu-icon").click(function(){
		$(".nav-header").slideToggle();
	});
	
	$(window).resize(function(){
		if(window.innerWidth > 768) {
			$(".nav-header").removeAttr("style");
		}
	});
	
});