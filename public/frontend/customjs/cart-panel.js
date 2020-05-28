$(document).ready(function(){
	$('.js-show-cart').on('click',function(e){
        e.preventDefault();
        $.ajax({
					type: 'get',
					url: "/cartjson",
				}).done(function(data){
					if(typeof(data) != "object"){
						data = $.parseJSON(data);
					}
					//data = $.parseJSON(data.cart);
					console.log(data)
					/*$.each(data.cart,function(index,data){
						console.log(data);
					});*/
				});


        //$('.js-panel-cart').addClass('show-header-cart');
    });
})