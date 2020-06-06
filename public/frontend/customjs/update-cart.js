$(document).ready(function(){
	var qty = 0; var id= null;
	$('.btn-num-product-down ').on('click', function(){
		//alert('here');
			 qty = $('.num-product').val();
			 qty = -1 ;
			 id = $('.num-product').attr('data-id');
			 updateCart(id, qty);
			 console.log(id);
	})
	$('.btn-num-product-up').on('click', function(){
		 qty = $('.num-product').val();
		 id = $('.num-product').attr('data-id');
		 updateCart(id, qty);
		 console.log(id);
	})
	function updateCart(id, quantity){
		$.ajax({
						type: 'get',
						url: "/add/cart/"+id+"/"+quantity,
					}).done(function(data){
						if(typeof(data) != "object"){
							data = $.parseJSON(data);
						}
						if(data.status == true){
							location.reload();
						}else{
							alert('Problem While Updating Cart.');
						}
					});
	}
})