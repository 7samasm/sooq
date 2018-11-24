<?php 

function lang($phrase) {

	static $lang =  array(
		//navbar start=================
		'home'   	    => 'الرئيسية',
		'cat'    	    => 'التصنيفات',
		'items'  	    => 'العناصر',
		'members'	    => 'الاعضاء',
		'comments'      => 'التعليقات',
		'statics'	    => 'الاحصائيات',
		'logs'   	    => 'التقارير',
		//drop down menu
		'edit_profile'  => 'التعديل',
		'settings'      => 'الاعدادات',
		'log_out'       => 'تسجيل الخروج',
		// navbar end 
	    /* navbar end=================== 
		*************
		** cat start====================
		** mange cat*/
		'mange-cat'     => 'إدارة التصنيفات',
		'panel-cat'     => 'لوحة إدارة التصنيفات ',
		'sort-cat'      => 'ترتيب' 
	 );

	return $lang[$phrase];
}