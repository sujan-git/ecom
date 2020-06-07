$(document).ready(function() {
       //$("#offer_selection").hide();
      $("#offer").on('click',function(){
        if($('#offer').is(':checked')){
          $("#offer_selection").show();
        }else{
          $("#offer_selection").hide();
        }; 
      });
      
    })