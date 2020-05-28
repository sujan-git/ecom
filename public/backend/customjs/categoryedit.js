$(document).ready(function(){
  			var $this = $("#check");
  			//console.log($this);
        
            if($("#check").prop("checked") == true){
                $('#parent_cats').hide();
            }
            else if($("#check").prop("checked") == false){
               $('#parent_cats').show(); 
            }
            $('input[type="checkbox"]').click(function(){
      
            if($(this).prop("checked") == true){
                $('#parent_cats').hide();
                
            }
            else if($(this).prop("checked") == false){
               $('#parent_cats').show(); 
            }
        });
});