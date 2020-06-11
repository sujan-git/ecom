@extends('layouts.backend.admin')
@section('link')
<link href="{{asset('backend/vendors/dropzone/dist/min/dropzone.min.css')}}" rel="stylesheet">
@endsection
@section('content')

<!-- page content -->
        <div class="right_col" role="main">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Product Information</h2>
                      <a href="{{route('product-list')}}"><button type="button" class="btn btn-primary">
                      <span class="glyphicon glyphicon-th-list"></span> List All</button></a>
                    <div class="clearfix"></div>
                  </div>
                  @if($product)
                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('product-update',$product->id)}}" enctype="multipart/form-data">
                      @csrf
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name" placeholder="" required="required" type="text" value="{{$product->name}}">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select class="form-control" name="status">
                            <option value="active" {{(@$product->status=='active')?'selected':''}}>Active</option>
                            <option value="inactive" {{(@$category->status=='inactive')?'selected':''}}>Inactive</option>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Is Featured</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"  id="" value="yes" name="is_featured" {{(@$product->is_featured=='yes')?'checked':''}}>
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Is Offered</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"  id="offer" value="yes" name="is_offered" {{@($product->offer_id != null)?'checked':''}}>
                            </label>
                          </div>
                          @if(isset($errors) && $errors->has('offer_id'))
                              <strong style="color:red">{{ $errors->first('offer_id') }}</strong>
                           @endif
                        </div>
                       
                      </div>

                      <div class="item form-group" id="offer_selection">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Offer </label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select class="form-control" name="offer_id" id="parent">
                            <option value = "">--Select Offer--</option>
                            @if(isset($offers))
                            @foreach($offers as $offer)
                            <option value="{{$offer->id}}" {{(@$product->offer_id == $offer->id)?"selected":''}}>{{$offer->title}}</option>
                            @endforeach
                             @endif
                          </select>
                           
                        </div> 
                      </div>


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Is Trending<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"  id="" value="yes" name="is_trending" {{(@$product->is_trending=='yes')?'checked':''}}>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Price<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="price_prod" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" placeholder="" required="required" type="number"  name="price" value="{{$product->price}}">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tax %
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="tax_percent" class="form-control col-md-7 col-xs-12"  type="number"  name="tax_percent" value="{{$product->tax_percent}}">
                        </div>
                      </div>

                      <div class="item form-group" id="parent_cats">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Product Category</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select class="form-control" name="parentcategory_id" id="parent">
                            <option value="active">--Select Any One Parent Category--</option>
                            @if(isset($parent_cats))
                            @foreach($parent_cats as $parent)
                            <option value="{{$parent->id}}"  {{(@$product->parent_category->id == $parent->id)?"selected":''}}>{{$parent->title}}</option>
                            @endforeach
                             @endif
                          </select>
                        </div>
                      </div>

                      <div class="item form-group" id="">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Child Category</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          @if(isset($product->child_category) && ($product->child_category != NULL))
                          <select class="form-control" name="childcategory_id" id="edit_child">
                            <option value='{{$product->child_category->id}}'>{{$product->child_category->title}}</option>
                          </select>
                          @endif
                          <select class="form-control" name="childcategory_id" id="child_cats">

                          </select>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3">Enable Discount<span class="required">*</span></label>
                        <div class="col-md-6">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"  id="" value="yes" name="is_discountable" {{(@$product->is_discountable=='yes')?'checked':''}}>
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Discount in RS</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                            <label>
                              <input id="" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="discount_price" placeholder=""  type="number"  placeholder="Mention % value" value="{{@$product->discount_price}}">
                            </label>
                          </div>
                      </div>


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Summary
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="textarea"  name="summary" class="form-control col-md-7 col-xs-12">{{$product->summary}}</textarea>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Description
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="textarea"  name="description" class="form-control col-md-7 col-xs-12">{{$product->description}}</textarea>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Product Thumb Image
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          	<input type="file" name="thumb_image" onchange = "readUrl(this, 'main_thumb')">
                            @if(isset($product, $product->thumb_image) &&
                        file_exists(public_path().'/uploads/productimage/'.$product->thumb_image))
                          <img src="{{asset('uploads/productimage/'.$product->thumb_image) }}" alt=""
                            class="img img-responsive img-thumbnail" id="" required>
                            @else
                            <img src="" alt="" id="main_thumb"> 
                            @endif
                        </div>                           
                      </div>


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Product Images
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" name="image_name[]" accept="image/*" multiple id="files">
                        </div>
                      </div>
                    
                      <div class="col-sm-12">
                        <div class="row">
                          @if(isset($product->product_images))
                          @foreach($product->product_images as $key => $image)
                          @if(file_exists(public_path().'/uploads/productimage/'.$image->image_name))
                            <div class="col-md-4">
                              <div class="caption">
                                <img src="{{ asset('uploads/productimage/'.$image->image_name)}}" alt="" class="img-thumbnail">
                                <div class="caption">
                                  <a  class="btn btn-danger delete-ind-image"  data-id ="{{$image->id}}"><i class="glyphicon glyphicon-remove"></i></a>
                                </div>
                              </div>
                           </div>  
                          @endif
                          @endforeach
                          @endif
                        </div>
                      </div>
                        
                      <div class="item form-group">
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Cancel</button>
                          <button id="send" type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      
  

<!-- /page content -->

@endsection
@section('script')

    <!--<script src="{{asset('backend/customjs/categoryadd.js')}}"></script>-->
    <!--<script src="{{asset('backend/customjs/prevent.js')}}"></script>-->
    <script>
      function readUrl(input, id) {
        alert('Adding New Image Will Delete Existing Image');
        len = input.files.length;
        for(var i=0;i<len;i++){
          if (input.files && input.files[i]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#"+id).attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[i]);
        }
        }
    
}
</script>
<script>

  $(document).ready(function(){
    $('.delete-ind-image').on('click',function(){
      var id = $('.delete-ind-image').attr('data-id');
      console.log(id);
       $.ajax({
          url: '/admin/product/deleteImage/'+id,
          type: 'get'
        }).done(function(data){
            if(data == 'success'){
              location.reload(true);
            }else{
              alert('Sorry! Unable to Proceed Task');
            }
          });
    })
  })
</script>
<script>
  //$("#parent").change(function(){
    $(function(){
      var value= $('#parent').val();
      $('#child_cats').hide();
      callAjax();
      $("#parent").change(function(){
        $('#edit_child').hide();
        $('#child_cats').show();
         value= $('#parent').val();
        callAjax();
      });


      function callAjax(){
        $.ajax({
          url: 'http://localhost/myblog/public/admin/category/get_child/category/'+value,
          type: 'get'
        }).done(function(data){

              if(typeof(data) != "object"){
                  data = $.parseJSON(data);
              }
              var html = '';
              if(data==''){html+= "<option value=''>NO CHILD CATEGORIES AVAILABLE</option>";$('#child_cats').html(html);}else{
              $.each(data, function(index, value){
                    html+= "<option value="+value.id+">"+value.title+"</option>";
                  });
                  $('#child_cats').html(html);
            }
          });
    }
    
        
  })
  </script>
<script src="{{asset('backend/customjs/offer.js')}}"></script>


@endsection
