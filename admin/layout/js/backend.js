$(function (){
  'use strict';

  //dashboard 
  $('.toggel-info').click(function(){
    $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(200);

    if ($(this).hasClass('selected')) {

      $(this).html('<i class="fa fa-plus fa-lg"></i>');

    }else{

       $(this).html('<i class="fa fa-minus fa-lg"></i>');
    }
  });

  //trigger the selectboxit 
   $("select").selectBoxIt({
      autoWidth :false
   });

  //hide placeholder on form focuse
  $('[placeholder]').focus(function (){
     $(this).attr('data-text',$(this).attr('placeholder'));
     $(this).attr('placeholder','');


    }).blur(function (){

      $(this).attr('placeholder',$(this).attr('data-text'));

    });




// convert password faild to text faild in hover 
var passField = $('.password');

	$('.show-pass').hover(function () {

		passField.attr('type', 'text');

	}, function () {

		passField.attr('type', 'password');

	});

  //confirmtion message on botton

  $('.confirm').click(function() {
    return confirm('you are sure');
  });

//category view option

 $('.cat h3').click(function(){
    $(this).next('.full-view').fadeToggle(250);
  });

$('.option span').click(function(){
    $(this).addClass('active').siblings('span').removeClass('active');

    if ( $(this).data('view') ==='full' ) {

      $('.cat .full-view').fadeIn(200);

    }else{
      $('.cat .full-view').fadeOut(250);
    }
  });


// show delet boton on child cat 

$('.child-link').hover(function(){
    $(this).find('.delete-child').fadeIn(400);
}, function(){
  $(this).find('.delete-child').fadeOut(400);
});
});