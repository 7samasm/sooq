$(function() {
	"use strict";
	// search***********************************************************************
	//open form
	$('#search_submit').click (function(){
       $(window).width() < 562 ? $('nav form').width(160) : $('nav form').width(260) ;
       $('nav form').css('transition','.3s');
	});
	//close form
	$('nav form .fa-times').click (function(){
       $('nav form').width(0);
       $('nav form').css('transition','0s');
	});
	// dropdown *******************************************************************
	$('#more').click (function(){
       $('nav .ul-nav li ul').toggle();
	});
	// signup & login *************************************************************
	$('.login-signup h1 span').click (function(){
       $(this).addClass('selected').siblings().removeClass('selected');
       $('.login-signup form').hide();
       $('.' + $(this).data('class')).fadeIn(100);
	});
	// hide place holder on focus and show on blur **********************************
	$('[placeholder]').focus (function (){

	$(this).attr('data-text',$(this).attr('placeholder'));
	$(this).attr('placeholder','');

	}).blur(function (){

	$(this).attr('placeholder',$(this).attr('data-text'));

	});
    // return confirm when you click on delete button*********************************
	$('.shure').click (function (){
		return confirm('are you shure ?');
	});
	//side nave **********************************************************************
	//open
	$('nav span .fa-bars').click (function () {
      $(window).width() < 450 ? $('.side-nav').width(200) : $('.side-nav').width(300);
      $('.side-nav').css('margin-right','0');
      $('#shadow').show();
	});
	//close
	$('#shadow').click (function () {
       $(this).hide();
       $('.side-nav').css('margin-right','-300px');
	});
	//text riter **********************************************************************
	$('.add .txt-inpt').keyup (function () {
       $('.add .hpd p').text($(this).val());
	});
	$('#num-input').keyup (function () {
       $('.add .price-show-primry').text($(this).val());
	});
	//dropdown2****************************************************************************
	$('.row .opt-bar span:last-child').click (function(){
       $('.row .opt-bar span:last-child ul').toggle();
	});
	//scrol******************************************************************************
	$(window).scroll (function(){
       if (window.scrollY > 44) {
       	  $('.top-line').height(0);
       	  $('.bottom-line').height(0);
       	  $('.bottom-line').css('overflow','hidden');
       	  $('#tr').width(69);
       	  $('#tr').height(43);
       	  $('nav').css('box-shadow','0 3px 3px 0 rgba(0,0,0,.16), 0 3px 3px 0 rgba(0,0,0,.24)');
       } else {
       	  $('.top-line').height(25);
       	  $('.bottom-line').height(42);
       	  $('.bottom-line').css('overflow','visible');
       	  $('#tr').width(80);
       	  $('#tr').height(68);
       	  $('nav').css('box-shadow','none');
       }
	}).scroll();
	//remove href from next&prev************************************************************************
	$('.remove-this-end').removeAttr("href");
	//index-tap************************************************************************
	$('.tap-one > span').click (function () {
		$(this).addClass('selected-tap').siblings('span').removeClass('selected-tap');
		$('.tc-one > div').hide();
		$('.' + $(this).data('class')).show();
	});
	$('.tap-two > span').click (function () {
		$(this).addClass('selected-tap').siblings('span').removeClass('selected-tap');
		$('.tc-two > div').hide();
		$('.' + $(this).data('class')).show();
	});
    /*====================ajax=====*/
    /*$('.ctj').click (function () {
        document.cookie = "order = " + $(this).data('class');
    });*/
});

// java script =============================

Number.prototype.formatMoney = function(c, d, t){
var n = this,
    c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };


var priceSpan = document.getElementsByClassName('price-show-primry');
for (p = 0 ; p < priceSpan.length; p++  ) {
    priceSpan[p].textContent = (parseInt(priceSpan[p].textContent)).formatMoney(2,'.',',');
    }
//======ajax==========================

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function getAjax(place,pageNum,cats) {
    "use strict";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById(place).innerHTML = xmlhttp.responseText;
        }
    }
    var cn = getCookie("order") == "" || getCookie("order") == 'page'  ? "?" : '?order='+getCookie("order")+'&';
    xmlhttp.open("GET", 'server.php'+cn+pageNum+cats, true);
    xmlhttp.send();
}
//document.cookie = "order = asc";
//console.log(document.cookie = "test = m ; expires = Fri Nov 02 2017 20:20:24 GMT+0300 ; path/ ");
console.log(document.cookie);
console.log(getCookie("order"));
