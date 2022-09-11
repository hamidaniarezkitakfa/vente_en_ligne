$(function(){
 'use strict';
    
    //sign up et login qd on clique sur eux
    $(' .login-page h1 span').click(function (){
      $(this).addClass('selected').siblings().removeClass('selected');
        
      $('.login-page form').hide();
        
      $('.' + $(this).data('class')).fadeIn(100);
        
    });
   
    
    $("select").selectBoxIt();
      autoWidth: false;
    
    $('[placeholder]').focus(function(){
    $(this).attr('data-text',$(this).attr('placeholder'));
    $(this).attr('placeholder','');}).blur(function(){
      $(this).attr('placeholder',$(this).attr('data-text'));
    });
    //ajouter une etoile on required champ
    $('input').each(function(){
      if($(this).attr('required') === 'required'){
        $(this).after('<span class="asterisk">*</span>');
      }
    
    });
   
    //confirmation message on button
    $('.confirm').click(function(){
         return confirm('Confirmer votre inscription');
    });
    
  

});