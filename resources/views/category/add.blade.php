@extends('layouts.backend.admin')
@section('content')

<!-- page content -->
        <div class="right_col" role="main">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Category Information</h2>
                      <a href="{{route('category-list')}}"><button type="button" class="btn btn-primary">
                      <span class="glyphicon glyphicon-th-list"></span> List All</button></a>
                    <div class="clearfix"></div>
                  </div>

                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('category-post')}}" enctype="multipart/form-data">
                      @csrf
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="title" placeholder="" required="required" type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select class="form-control" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Is Parent<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value="" id="check">
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="item form-group" id="parent_cats">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Parent Category</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select class="form-control" name="parent_id" id="parent">
                            <option value="active">--Select Any One Parent Category--</option>
                            @if(isset($parent_cats))
                            @foreach($parent_cats as $parent)
                            <option value="{{$parent->id}}">{{$parent->title}}</option>
                            @endforeach
                             @endif
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Featured Collection<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value='1' name="is_featured">
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Summary
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="textarea"  name="summary" class="form-control col-md-7 col-xs-12"></textarea>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Category Image
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" name="category_image" onchange = "readUrl(this, 'main_thumb')">
                            <img src="" alt="" id="main_thumb"> 
                        </div>
                      </div>
                      <div class="ln_solid"></div>
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
    <script src="{{asset('backend/customjs/categoryadd.js')}}"></script>
    <script src="{{asset('backend/customjs/prevent.js')}}"></script>
    <script>
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
    </script>
@endsection