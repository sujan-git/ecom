$(document).ready(function(){
	$("#loadmore_btn").on('click', function(e){
		e.preventDefault();
		var slug = $("#loadmore_btn").attr('data-slug');
		 $.ajax({
					type: 'get',
					url: "/loadmore/"+slug,
				}).done(function(data){
					if(typeof(data) != "object"){
						data = $.parseJSON(data);
					}
					if(data.status == true){
						/*
						 <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ">
                    <!-- Block2 -->
                    <div class="block2">
                        <a href="{{route('product-detail',$product->slug)}}">
                        <div class="block2-pic hov-img0">
                            @if(file_exists(public_path().'/uploads/productimage/'.$product->thumb_image))
                            <img src="{{asset('uploads/productimage/'.$product->thumb_image)}}" alt="IMG-PRODUCT">
                            @endif
                            
                        </div>
                        </a>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="{{route('product-detail',$product->slug)}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6" id="product_title">
                                    {{$product->name}}
                                </a>

                                <span class="stext-105 cl3">
                                    RS {{$product->price}}
                                </span>
                            </div>

                            <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                    <img class="icon-heart1 dis-block trans-04" src="{{asset('frontend/images/icons/icon-heart-01.png')}}" alt="ICON">
                                    <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{asset('frontend/images/icons/icon-heart-02.png')}}" alt="ICON">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
						*/
						var html = null;
						var icon1 = " http://ecom.loc/frontend/images/icons/icon-heart-01.png";
						console.log(icon1);
						var icon2 = "http://ecom.loc/frontend/images/icons/icon-heart-02.png";
						$.each(data.products ,function(key,product){
							
							html += '<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item "><!-- Block2 --><div class="block2">';
                    		html += ' <a href="'+product.route+'"><div class="block2-pic hov-img0">';
                    		html += ' <img src="'+product.image+'" alt="IMG-PRODUCT">';
                    		html += '</div></a><div class="block2-txt flex-w flex-t p-t-14"><div class="block2-txt-child1 flex-col-l ">';
                    		html += '<a href="'+product.route+'" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6" id="product_title">'+product.name+'</a>';
                            if(product.is_discountable == 'yes'){
                            	html += '<span class="stext-105 cl3">RS '+parseFloat(product.price - product.discount_price)+'<del style="color:red">Rs '+product.price+'</del></span>';
							 }else{
							 	html += '<span class="stext-105 cl3"> RS '+parseFloat(product.price)+'</span>';                             
                            }  
              
                    		html += '</div><div class="block2-txt-child2 flex-r p-t-3"><a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">'
                    		html += '<img class="icon-heart1 dis-block trans-04" src="'+icon1+'" alt="ICON"><img class="icon-heart2 dis-block trans-04 ab-t-l" src="'+icon2+'" alt="ICON">';
                    		html += ' </a></div></div></div></div>';
       						slug = product.slug;
						})
						console.log(html);
						$("#loadmore_btn").attr('data-slug',slug);
						$('.row isotope-grid').appendChild(html);
					}
				});
	});
})