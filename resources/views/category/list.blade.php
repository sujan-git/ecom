@extends('layouts.backend.admin')
@section('content')
        <!-- page content -->
        <div class="right_col" role="main" >
          <div class="">
            <div class="page-title" id="session_info">
              <div class="title_left">
                @if ($message = Session::get('success'))
					       <div class="alert alert-success alert-block">
						        <button type="button" class="close" data-dismiss="alert">×</button>	
        					     <strong>{{ $message }}</strong>
					       </div>
				        @elseif($message = Session::get('error'))
					       <div class="alert alert-success alert-block">
						        <button type="button" class="close" data-dismiss="alert">×</button>	
        					<strong>{{ $message }}</strong>
					       </div>
				        @endif
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <a href="{{route('category-add')}}"><button type="button" class="btn btn-primary">
                      <span class="glyphicon glyphicon-plus"></span>Add New</button></a>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>
                    </p>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Status</th>
                          <th>Is Parent</th>
                          <th>Is featured</th>
                          <th>Action</th>
                        </tr>
                      </thead>


                      <tbody>
                        @if(isset($categories))
                        @foreach($categories as $key=>$cat_data)
                        <tr>
                          <td>{{$cat_data->title}}</td>
                          <td>{{$cat_data->status}}</td>
                          <td>{{($cat_data->parent_id==NULL)?"PARENT":"CHILD"}}</td>
                          <td>{{($cat_data->is_featured == '1')?'True':'False'}}</td>
                          <td><a href="{{route('category-edit',$cat_data->id)}}" class="btn btn-info"><i class="glyphicon glyphicon-pencil"></i></a><a href="{{route('category-delete',$cat_data->id)}}" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a></td>
                          
                        </tr>
                        @endforeach
                        @endif
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
        <!-- /page content -->

    </div>
</div>
</div>

@endsection
@section('script')
<script type="text/javascript">
  setTimeout(function(){
      $("#session_info").fadeOut("slow");
 },5000)
  </script>
@endsection