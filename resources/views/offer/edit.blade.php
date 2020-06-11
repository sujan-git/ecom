@extends('layouts.backend.admin')
@section('content')

<!-- page content -->
        <div class="right_col" role="main">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <a href="{{route('offer-list')}}"><button type="button" class="btn btn-primary">
                        <span class="glyphicon glyphicon-th-list"></span> List All</button></a>
                    <div class="clearfix"></div>
                  </div>
                  @if(isset($offer) && !empty($offer))
                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('offer-update',$offer->id)}}" enctype="multipart/form-data">
                      @csrf
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Offer Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="title" placeholder="" required="required" type="text" value="{{@$offer->title}}">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Status<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <select class="form-control" name="status">
                            <option value="active" {{(@$offer->status == 'active'?'selected':'')}}>Active</option>
                            <option value="inactive" {{(@$offer->status == 'inactive'?'selected':'')}}>Inactive</option>
                          </select>
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Summary</label>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                          <textarea id="textarea"  name="summary" class="form-control col-md-7 col-xs-12">{{$offer->summary}}</textarea>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Offer Banner Image
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          	<input type="file" name="banner_image" id="banner_image"> 
                        </div>                           
                      </div>
                      <div class="item form-group" id="preview">
                          <div class = "col-xs-12">
                            @if($offer->banner_image && file_exists(public_path().'/uploads/bannerimage/'.$offer->banner_image))
                                <img class="img-responsive" src="{{asset('uploads/bannerimage/'.$offer->banner_image) }}" id="preview_image" >
                            @endif
                          </div>
                      </div>
                      
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

    <script src="{{asset('backend/customjs/categoryadd.js')}}"></script>
    <script src="{{asset('backend/customjs/prevent.js')}}"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                $('#preview_image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#banner_image").change(function() {
            readURL(this);
        });
    </script>
    
@endsection