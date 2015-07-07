jQuery(function($) {

	$('#about h1').waypoint(function() {
		$(this).toggleClass( 'animated bounceInDown' );
	},
	{
		offset: '100%',
		// triggerOnce: true
	});
	
	$('#about img').waypoint(function() {
		$(this).toggleClass( 'animated flash' );
	},
	{
		offset: '90%',
		// triggerOnce: true
	});
	
	$('#service .left').waypoint(function() {
		$(this).toggleClass( 'animated slideInLeft' );
	},
	{
		offset: '90%',
		// triggerOnce: true
	});
	
	$('#service .right').waypoint(function() {
		$(this).toggleClass( 'animated slideInRight' );
	},
	{
		offset: '90%',
		// triggerOnce: true
	});

	$('#portfolio img').waypoint(function() {
		$(this).toggleClass( 'animated fadeInUp' );
	},
	{
		offset: '90%',
		// triggerOnce: true
	});

});