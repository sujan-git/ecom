@extends('layouts.frontend.home')
@section('content')
<!-- Slider -->
    <section class="section-slide">
        <div class="wrap-slick1">
            @if($offers)
            <div class="slick1">
                @foreach($offers as $offer)
                <div class="item-slick1" style="background-image: url({{asset('uploads/bannerimage/'.$offer->banner_image)}});">
                    <div class="container h-full">
                        <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                            <!--<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                                <span class="ltext-101 cl2 respon2">
                                    
                                </span>
                            </div>-->
                                
                            <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                                <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
                                   {{$offer->title}}
                                </h2>
                            </div>
                                
                            <div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                                <a href="product.html" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
            @endif
        </div>
    </section>

  
    @if($featured_collections)
        <!-- Banner -->
    <div class="sec-banner bg0 p-t-80 p-b-50">
        <div class="container">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                   Featured Collection
                </h3>
            </div>
            <div class="row">

                @foreach($featured_collections as $key=>$collection)
                <div class="col-md-6 col-xl-2 p-b-30 ">
                    <!-- Block1 -->
                    <div class="block1 wrap-pic-w">

                       @if(file_exists(public_path().'/uploads/categoryimage/'. $collection->category_image))
                            <img src="{{asset('uploads/categoryimage/'.$collection->category_image)}}" alt="IMG-PRODUCT">
                            @endif

                        <a href="{{route('category-shop',$collection->slug)}}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">

                            <div class="block1-txt-child2 p-b-4 trans-05">
                                <div class="block1-link stext-101 cl0 trans-09">
                                   {{$collection->title}}
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                @endforeach
            </div>
        </div>
    </div>

    @endif

           <!-- Product -->
    <section class="bg0 p-t-23 p-b-140">
        <div class="container">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    Top Selllings
                </h3>
            </div>

            <div class="flex-w flex-sb-m p-b-52">
                <!--
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
                        All Products
                    </button>

                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".women">
                        Women
                    </button>

                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".men">
                        Men
                    </button>

                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".bag">
                        Bag
                    </button>

                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".shoes">
                        Shoes
                    </button>

                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".watches">
                        Watches
                    </button>
                </div>-->

               @include('frontend.search')
            </div>
            @if($all_products)
            <div class="row isotope-grid" id="productSection" >
                @foreach($all_products as $key=>$product)
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ">
                    <!-- Block2 -->
                    <div class="block2">
                        <a href="{{route('product-detail',$product->slug)}}">
                        <div class="block2-pic hov-img0">
                            @if(file_exists(public_path().'/uploads/productimage/'. $product->thumb_image))
                            <img src="{{asset('uploads/productimage/'.$product->thumb_image)}}" alt="IMG-PRODUCT">
                            @endif
                            
                        </div>
                        </a>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="{{route('product-detail',$product->slug)}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6" id="product_title">
                                    {{$product->name}}
                                </a>
                                @if($product->is_discountable =='yes')
                                <span class="stext-105 cl3">
                                    RS {{$product->price - $product->discount_price}}
                                    <del style="color:red">Rs {{$product->price}}</del>
                                </span>
                                @else
                                <span class="stext-105 cl3">
                                    RS {{$product->price}}
                                </span>
                                @endif

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
                @endforeach

            </div>
            @endif
             <div class="flex-c-m flex-w w-full p-t-45">
                {{ $all_products->links() }}
            </div>
            <!-- 
            <div class="flex-c-m flex-w w-full p-t-45">
                <a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04" id="loadmore_btn" data-slug="{{$product->slug}}">
                    {{ $all_products->links() }}
                </a>
            </div>Load more -->
        </div>
    </section>
@endsection
@section('script')
<script src = "{{asset('frontend/customjs/loadmore.js')}}"></script>
@endsection