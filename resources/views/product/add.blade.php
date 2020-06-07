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
                     <div class="title_left">
                      @if($message = Session::get('success'))
                       <div class="alert alert-success alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                             <strong>{{ $message }}</strong>
                       </div>
                      @elseif($message = Session::get('error'))
                       <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>
                       </div>
                       @endif
                       
                     </div>
                    <h2>Product Information</h2>
                      <a href="{{route('product-list')}}"><button type="button" class="btn btn-primary">
                      <span class="glyphicon glyphicon-th-list"></span> List All</button></a>
                    <div class="clearfix"></div>
                  </div>

                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('product-post')}}" enctype="multipart/form-data">
                      @csrf
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name" placeholder="" required="required" type="text">
                          @if(isset($errors) && $errors->has('name'))
                              <strong style="color:red">{{ $errors->first('name') }}</strong>
                           @endif
                        </div>
                        
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select class="form-control" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                          </select>
                          @if(isset($errors) && $errors->has('status'))
                              <strong style="color:red">{{ $errors->first('status') }}</strong>
                           @endif
                        </div>
                        
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Is Featured</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"  id="" value="yes" name="is_featured">
                            </label>
                          </div>
                          @if(isset($errors) && $errors->has('is_featured'))
                              <strong style="color:red">{{ $errors->first('is_featured') }}</strong>
                           @endif
                        </div>
                        
                      </div>

                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Is Offered</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"  id="offer" value="yes" name="is_offered">
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
                            <option value="{{$offer->id}}">{{$offer->title}}</option>
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
                              <input type="checkbox"  id="" value="yes" name="is_trending">
                            </label>
                             @if(isset($errors) && $errors->has('is_trending'))
                              <strong style="color:red">{{ $errors->first('is_trending') }}</strong>
                           @endif
                          </div>
                        </div>
                       
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Product Price<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="price" class="form-control col-md-7 col-xs-12" required="required" type="number" id="price_prod">
                          @if(isset($errors) && $errors->has('price'))
                              <strong style="color:red">{{ $errors->first('price') }}</strong>
                           @endif
                        </div>
                        
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tax %
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="tax_percent" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="tax_percent" placeholder=""  type="number" min="1" placeholder="Mention % value" name="tax_percent">
                          @if(isset($errors) && $errors->has('tax_percent'))
                              <strong style="color:red">{{ $errors->first('tax_percent') }}</strong>
                           @endif
                        </div>
                        
                      </div>

                      <div class="item form-group" id="parent_cats">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Product Category</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select class="form-control" name="parentcategory_id" id="parent">
                            <option value="">--Select Any One Parent Category--</option>
                            @if(isset($parent_cats))
                            @foreach($parent_cats as $parent)
                            <option value="{{$parent->id}}">{{$parent->title}}</option>
                            @endforeach
                             @endif
                          </select>
                          @if(isset($errors) && $errors->has('parentcategory_id'))
                              <strong style="color:red">{{ $errors->first('parentcategory_id') }}</strong>
                           @endif
                        </div>
                      </div>
                       

                      <div class="item form-group" id="">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Child Category</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select class="form-control" name="childcategory_id" id="child_cats">
                            
                          </select>
                          @if(isset($errors) && $errors->has('childcategory_id'))
                              <strong style="color:red">{{ $errors->first('childcategory_id') }}</strong>
                           @endif
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3">Enable Discount<span class="required">*</span></label>
                        <div class="col-md-6">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value="yes" id=""  name="is_discountable">
                            </label>
                            @if(isset($errors) && $errors->has('is_discountable'))
                              <strong style="color:red">{{ $errors->first('is_discountable') }}</strong>
                           @endif
                          </div>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Discount in RS</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                            <label>
                              <input id="" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="discount_price" placeholder=""  type="number" min="1" placeholder="Mention % value">
                            </label>
                          </div>
                      </div>


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Summary
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="textarea"  name="summary" class="form-control col-md-7 col-xs-12"></textarea>
                          @if(isset($errors) && $errors->has('summary'))
                              <strong style="color:red">{{ $errors->first('summary') }}</strong>
                           @endif
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Description
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="textarea"  name="description" class="form-control col-md-7 col-xs-12"></textarea>
                          @if(isset($errors) && $errors->has('description'))
                              <strong style="color:red">{{ $errors->first('description') }}</strong>
                           @endif
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Product Thumb Image
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          	<input type="file" name="thumb_image" onchange = "readUrl(this, 'main_thumb')">
                            <img src="" alt="" id="main_thumb"> 
                            @if(isset($errors) && $errors->has('thumb_image'))
                              <strong style="color:red">{{ $errors->first('thumb_image') }}</strong>
                           @endif
                        </div>                           
                      </div>


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Product Images
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file" name="image_name[]" accept="image/*" multiple id="files">
                            @if(isset($errors) && $errors->has('images_name'))
                              <strong style="color:red">{{ $errors->first('images_name') }}</strong>
                           @endif
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <output id="result" />
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
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      
  

<!-- /page content -->

@endsection
@section('script')
<script src="{{asset('backend/vendors/moment/min/moment.min.js.')}}"></script>
<script src="{{asset('backend/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js')}}"></script>
    <script src="{{asset('backend/vendors/jquery.hotkeys/jquery.hotkeys.js')}}"></script>
    <script src="{{asset('backend/vendors/google-code-prettify/src/prettify.js')}}"></script>
    <!-- jQuery Tags Input -->
    <script src="{{asset('backend/vendors/jquery.tagsinput/src/jquery.tagsinput.js')}}"></script>
    <!-- Switchery -->
    <script src="{{asset('backend/vendors/switchery/dist/switchery.min.js')}}"></script>
    <!-- Select2 -->
    <script src="{{asset('backend/vendors/select2/dist/js/select2.full.min.js')}}"></script>
    <!-- Parsley -->
    <script src="{{asset('backend/vendors/parsleyjs/dist/parsley.min.js')}}"></script>
    <!-- Autosize -->
    <script src="{{asset('backend/vendors/autosize/dist/autosize.min.js')}}"></script>
    <!-- jQuery autocomplete -->
    <script src="{{asset('backend/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js')}}"></script>
    <!-- starrr -->
    <script src="{{asset('backend/vendors/starrr/dist/starrr.js')}}"></script>
    <!--<script src="{{asset('backend/customjs/categoryadd.js')}}"></script>-->
    <script src="{{asset('backend/customjs/prevent.js')}}"></script>
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
          url: '/admin/category/get_child/category/'+value,
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
  <script>
          function readUrl(input, id) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();

              reader.onload = function(e) {
                  $("#"+id).attr("src", e.target.result);
              };

              reader.readAsDataURL(input.files[0]);
          }
      }
  </script>
   <script src="{{asset('backend/customjs/offer.js')}}"></script>
   
@endsection
