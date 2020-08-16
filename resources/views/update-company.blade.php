@extends('layouts.app')
@section('content')

<div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                
                 <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Company</strong><span style="float: right;"><a href="/ShowCompany"><i class="fa fa-arrow-left"></i> Back</a></span>
                        </div>
                        <div class="card-body">
                          <!-- Credit Card -->
                          <div id="pay-invoice">
                              <div class="card-body">
                                  <div class="card-title">
                                      <h3 class="text-center">Update Company</h3>
                                  </div>
                                  <hr>

                    <form  action="{{action('CompanyController@updateCompany', $id)}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" class="form-control" value="{{$company->name}}" name="name" placeholder="Enter Company Name" required>
                        </div>
                         <div class="form-group">
                        <label for="logo">Company Logo</label><br>
                        <span><img src="{{asset('/company_logo/'.$company->logo)}}" style="width: 50px; height: 50px; border-radius: 50%;"></span>
                         <input type="file" name="logo" class="form-control" style="width: 93%; float: right;">
                         
                         </div>
                         
                        <button type="submit" class="btn btn-info btn-flat m-b-30 m-t-30">Submit</button>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
</div>
</div>

</div>
        
@endsection