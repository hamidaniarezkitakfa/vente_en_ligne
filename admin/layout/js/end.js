$(function(){
 'use strict';
    //accueil le plus et le moin qu'il ya dans les 3 dernier membres et produits
    $('.toggle-info').click(function(){
       $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
        if($(this).hasClass('selected')){
            
          $(this).html('<i class="fa fa-minus fa-lg"></i>');
            
        }else{
          
            $(this).html('<i class="fa fa-plus fa-lg"></i>');
        }
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
    //convertir le champ mdp en text qd on click
    var passField = $('.password');
    
    $('.show-pass').hover(function (){
    
      passField.attr('type', 'text');
        
    }, function(){
        
      passField.attr('type', 'password');
    
    });
    //confirmation message on button
    $('.confirm').click(function(){
         return confirm('Etes-vous sur?');
    });
    
     $('.confirme').click(function(){
         return confirm('Etes-vous sur de vouloir modifier?');
    });
    
    // full view qd on click sur la categories leur info s'affiche
    $('.cat h3').click(function(){
     $(this).next('.full-view').fadeToggle(200);
    });
    
    $('.option span ').click(function(){
       $(this).addClass('active').siblings('span').removeClass('active');
    });
    
 $('.option span').click(function(){
  $(this).addClass('active').siblings('span').removeClass('active');
     if($(this).data('view') === 'full'){
        $('.cat .full-view').fadeIn(200);
     }else{
         $('.cat .full-view').fadeOut(200);
     }
 });
    
    });