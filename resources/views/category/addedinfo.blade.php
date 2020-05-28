@if(isset($success))
<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    @if (session('error'))
                    <h2>{{ session('error') }}</h2>
                    @else
                    <h2>Category Added Successfully</h2>
                    @endif
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                  </div>
                </div>
              </div>
            </div>
@endif