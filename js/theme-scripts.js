
jQuery(function($) {


 $(".entry-content").fitVids();

//Switch url to app for iphones
 $(".social-links a").switcher();
//lazy load video
//$('iframe').sleepyHead();

/*Scroll to top code*/
	jQuery(window).scroll(function() {
		if(jQuery(this).scrollTop() != 0) {
			jQuery('#toTop, #backtotop').fadeIn();
		} else {
			jQuery('#toTop, #backtotop').fadeOut();
		}
	});
	jQuery('#toTop, #options a').click(function() {
		jQuery('body,html').animate({scrollTop:0},800);
	});











});//End on load