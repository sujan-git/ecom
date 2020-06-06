$(document).ready(function(){
	$('.js-addcart-detail').on('click',function(e){
		e.preventDefault();
		var id = $('.js-addcart-detail').attr('data-id');
		var quantity = $('#quantity').val();
		console.log(id, quantity);
		$.ajax({
					type: 'get',
					url: "/add/cart/"+id+"/"+quantity,
				}).done(function(data){
					if(typeof(data) != "object"){
						data = $.parseJSON(data);
					}
					if(data.status == true){
						/*$('.js-addcart-detail').each(function(e){
				            var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
				            $(this).on('click', function(){
				                swal(nameProduct, "is added to cart !", "success");
				        	});
				        });*/
				        var nameProduct = data.data.current_item.name;
				        
				        /*
				        <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="{{$cart['image']}}" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                {{$cart['name']}}
                            </a>

                            <span class="header-cart-item-info">
                               {{$cart['quantity']}} x Rs.{{$cart['price']}}
                            </span>
                        </div>
                    </li>
				        */
				       // debugger;
				        if(data.data.cart){
				        	var html = '';
				        	var qty = 0;
				        	var total_amount = 0;
					        $.each(data.data.cart, function(key,cart){
					        	html += '<li class="header-cart-item flex-w flex-t m-b-12"><div class="header-cart-item-img">';
					        	html += '<img src="'+cart.image+'" alt="IMG"></div>';
					        	html += '<div class="header-cart-item-txt p-t-8"><a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">';
					        	html += cart.name;
					        	html += '</a><span class="header-cart-item-info">'+cart.quantity+' x Rs.'+cart.price+'';
	                            html += ' </span></div> </li>';
	                            qty += parseInt(cart['quantity']);
	                            total_amount += parseFloat(cart['total_amount']);
	                            console.log(total_amount, qty);
	                        
					        })
					        $('.icon-header-noti').attr('data-notify',qty);
					        $('.header-cart-total').html('Total: Rs '+total_amount);
				        	$('.header-cart-wrapitem').append(html);
				        	swal(nameProduct, "is added to cart !", "success");
				        }
				        
				        
					}else{
						swal("Unable to add to cart!");
					}
				});
	});
});