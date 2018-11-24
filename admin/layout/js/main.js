$(function() {
	"use strict";
	// hide place holder on focus and show on blur *****************
	$('[placeholder]').focus (function (){

	$(this).attr('data-text',$(this).attr('placeholder'));
	$(this).attr('placeholder','');

	}).blur(function (){

	$(this).attr('placeholder',$(this).attr('data-text'));
	
	});
    // return confirm when you click on delete button***************
	$('.shure').click (function (){
		return confirm('are you shure ?');
	});
    // toggle next element [.toggle-h3] of mange cats page**********
	$('.mr h3').click (function (){
		$(this).next('.toggle-h3').toggle();
	});
    // toggle next element [.all-crle] == dashboard->settings panel*
	$('.admin-add h4').click (function (){
		$(this).toggleClass('toggle-c').next('.all-crle').toggle();
        // change scroll on + 988 screens
		screen.width > 988 ? window.scrollTo(0,400) : null ; //scroll to end after click h4
	});
    // change icons == dashboard->settings panel**********************
    $('#h4-icon-1').click (function () {
    	if ($(this).hasClass('toggle-c')) {
    	    $(this).html("<i class='fa fa-minus'></i> Add");    		
    	} else {
            $(this).html("<i class='fa fa-plus'></i> Add");
    	}
    });
    $('#h4-icon-2').click (function () {
    	if ($(this).hasClass('toggle-c')) {
    	    $(this).html("<i class='fa fa-minus'></i> Admin");    		
    	} else {
            $(this).html("<i class='fa fa-plus'></i> Admin");
    	}
    });
});
// java script =============================