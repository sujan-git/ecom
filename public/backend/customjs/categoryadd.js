$(document).ready(function(){
  $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $('#parent_cats').hide();
                $('#parent').val(null);
            }
            else if($(this).prop("checked") == false){
               $('#parent_cats').show(); 
            }
        });
});