<?php 

function lang($phrase) {

	static $lang =  array(
		//navbar start=================
		'home'   	    => 'Home',
		'cat'    	    => 'Categories',
		'items'  	    => 'Items',
		'members'	    => 'Members',
		'comments'      => 'Comments',
		'statics'	    => 'Statics',
		'logs'   	    => 'Logs',
		//drop down menu
		'edit_profile'  => 'Edit profile',
		'settings'      => 'Settings',
		'log_out'       => 'Log out',
		/* navbar end=================== 
		*************
		** cat start====================
		** mange cat*/
		'mange-cat'     => 'Mange Categories',
		'panel-cat'     => 'Cats Mange Panel',
		'sort-cat'      => 'Sort'
	 );

	return $lang[$phrase];
}